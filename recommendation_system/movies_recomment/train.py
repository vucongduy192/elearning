import tensorflow as tf
import argparse
from Dataset import Dataset
import numpy as np
from sklearn.metrics import mean_squared_error
import random
import math
from sklearn.utils import shuffle


class MF:
    def __init__(self, user_num, item_num, factor_num, regs):
        self._factor_num = factor_num
        self._user_num = user_num
        self._item_num = item_num
        self._reg = regs

    def build_graph(self):
        self._user = tf.placeholder(tf.int32, shape=[None, 1])
        self._item = tf.placeholder(tf.int32, shape=[None, 1])
        self._real_rate = tf.placeholder(tf.float32, shape=[None, ])

        # biases = tf.get_variable('biases', [1])
        user_embedding = tf.get_variable('user_embedding', [self._user_num, self._factor_num],
                                         initializer=tf.random_normal_initializer(mean=0., stddev=0.01, seed=2018))
        item_embedding = tf.get_variable('item_embedding', [self._item_num, self._factor_num],
                                         initializer=tf.random_normal_initializer(mean=0., stddev=0.01, seed=2018))
        bias_u_embedding = tf.get_variable('bias_u_embedding', [self._user_num],
                                           initializer=tf.random_normal_initializer(mean=0., stddev=0.01, seed=2018))
        bias_i_embedding = tf.get_variable('bias_i_embedding', [self._item_num],
                                           initializer=tf.random_normal_initializer(mean=0., stddev=0.01, seed=2018))

        embedded_user_id = tf.nn.embedding_lookup(user_embedding, self._user)
        embedded_item_id = tf.nn.embedding_lookup(item_embedding, self._item)
        embedded_bias_u = tf.nn.embedding_lookup(bias_u_embedding, self._user)
        embedded_bias_i = tf.nn.embedding_lookup(bias_i_embedding, self._item)

        user_latent = tf.contrib.layers.flatten(embedded_user_id)
        item_latent = tf.contrib.layers.flatten(embedded_item_id)

        bias_i = tf.squeeze(embedded_bias_i)
        bias_u = tf.squeeze(embedded_bias_u)

        predict_vector = tf.multiply(user_latent, item_latent)

        predict = tf.reduce_sum(predict_vector, axis=1) + bias_u + bias_i
        predict = tf.squeeze(predict)

        loss = tf.losses.mean_squared_error(labels=self._real_rate, predictions=predict) + \
               self._reg * 0.5 * (tf.nn.l2_loss(user_latent) + tf.nn.l2_loss(item_latent) +
                                  tf.nn.l2_loss(bias_i) + tf.nn.l2_loss(bias_u))
        self._predict = predict
        self._loss = loss

    def trainer(self, learning_rate):
        self._train_op = tf.train.AdamOptimizer(learning_rate).minimize(self._loss)

    def fit_and_evaluate_mrse(self, train, test, batch_size, epochs, saved_model=False):
        # tf.reset_default_graph()
        data_reader = DataReader(data=train, batch_size=batch_size)
        min_mrse = 1000
        patient_count = 0
        patient_threshold = 5
        mrse = []
        epoch = 0
        saver = tf.train.Saver()
        with tf.Session() as sess:
            sess.run(tf.global_variables_initializer())
            while epoch < epochs and patient_count <= patient_threshold:
                users, items, ratings, end_epoch = data_reader.next_batch()
                rating_eval, loss_eval, _ = sess.run([self._predict, self._loss, self._train_op],
                                                     feed_dict={self._user: users, self._item: items,
                                                                self._real_rate: ratings})
                if end_epoch:
                    epoch += 1
                    test_data_reader = DataReader(data=test)
                    test_rating_eval = sess.run(self._predict,
                                                feed_dict={self._user: test_data_reader._users,
                                                           self._item: test_data_reader._items,
                                                           self._real_rate: test_data_reader._labels})
                    mrse.append(math.sqrt(mean_squared_error(test_data_reader._labels, test_rating_eval)))
                    print
                    epoch, ': ', mrse[-1]
                    if mrse[-1] < min_mrse:
                        min_mrse = mrse[-1]
                        patient_count = 0
                        if saved_model:
                            saver.save(sess, 'mf_model/model.ckpt')
                    else:
                        patient_count += 1

        tf.reset_default_graph()
        return min_mrse, mrse

    def predict(self, test):
        self.build_graph()
        saver = tf.train.Saver()
        with tf.Session() as sess:
            sess.run(tf.global_variables_initializer())
            saver.restore(sess, 'mf_model/model.ckpt')
            print
            'load param done'
            test_data_reader = DataReader(data=test)
            test_rating_eval = sess.run(self._predict, feed_dict={self._user: test_data_reader._users,
                                                                  self._item: test_data_reader._items,
                                                                  self._real_rate: test_data_reader._labels})
        return test_rating_eval


def parse_args():
    parser = argparse.ArgumentParser(description="Run MF.")
    parser.add_argument('--path', nargs='?', default='Data/',
                        help='Input data path.')
    parser.add_argument('--dataset', nargs='?', default='ml-1m',
                        help='Choose a dataset.')
    parser.add_argument('--epochs', type=int, default=1000,
                        help='Number of epochs.')
    parser.add_argument('--batch_size', type=int, default=256,
                        help='Batch size.')
    parser.add_argument('--num_factors', type=int, default=8,
                        help='Embedding size.')
    parser.add_argument('--lr', type=float, default=0.001,
                        help='Learning rate.')
    parser.add_argument('--verbose', type=int, default=1,
                        help='Show performance per X iterations')
    parser.add_argument('--out', type=int, default=1,
                        help='Whether to save the trained model.')
    return parser.parse_args()


class DataReader:
    def __init__(self, data, batch_size=0):
        self._batch_size = batch_size
        self._users = data[:, 0].reshape(len(data), 1)
        self._items = data[:, 1].reshape(len(data), 1)
        self._labels = data[:, 2].reshape(len(data), )
        self._num_epoch = 0
        self._batch_id = 0
        self._end_epoch = False
        if self._batch_size == 0:
            self._batch_size = self._users.shape[0]

    def next_batch(self):
        if self._end_epoch:
            indices = list(range(len(self._users)))
            indices = shuffle(indices, random_state=self._num_epoch)
            self._users, self._items, self._labels = self._users[indices], self._items[indices], self._labels[indices]

        self._end_epoch = False
        start = self._batch_id * self._batch_size
        end = start + self._batch_size
        self._batch_id += 1

        if end + self._batch_size > len(self._users):
            self._end_epoch = True
            end = len(self._users)
            self._num_epoch += 1
            self._batch_id = 0

        return self._users[start:end], self._items[start:end], self._labels[start:end], self._end_epoch


def get_the_best_hyper_parameters(train, valid, batch_size, learning_rate, epochs):
    def validation(LAMBDA, K):
        mf = MF(user_num=num_users, item_num=num_items, factor_num=K, regs=LAMBDA)
        mf.build_graph()
        mf.trainer(learning_rate=learning_rate)
        mrse = mf.fit_and_evaluate_mrse(train=train, test=valid, batch_size=batch_size, epochs=epochs)
        return mrse

    def range_scan(best_LAMBDA, best_K, minimum_mrse, LAMBDA_values, K_values):
        for current_LAMBDA in LAMBDA_values:
            for current_K in K_values:
                mrse, mrse_arr = validation(LAMBDA=current_LAMBDA, K=current_K)
                if minimum_mrse > mrse:
                    best_LAMBDA = current_LAMBDA
                    best_K = current_K
                    minimum_mrse = mrse
                print('lambda:', current_LAMBDA, 'K: ', current_K, 'mrse:', mrse)
                with open('validation/mf.txt', 'a') as file:
                    file.write(
                        str(current_LAMBDA) + '\t' + str(current_K) + '\t' + str(mrse) + '\t' + str(mrse_arr) + '\n')
        return best_LAMBDA, best_K, minimum_mrse

    best_LAMBDA = 0.
    LAMBDA_values = [0.0003, 0.0006, 0.001, 0.002, 0.003]
    minimum_mrse = 1e5
    best_K = 0
    K_values = [20, 30, 40, 50, 70]
    best_LAMBDA, best_K, minimum_RSS = range_scan(best_LAMBDA=best_LAMBDA, best_K=best_K, minimum_mrse=minimum_mrse,
                                                  LAMBDA_values=LAMBDA_values, K_values=K_values)
    return best_LAMBDA, best_K, minimum_RSS


def give_recommend_id(id, num):
    dataset = Dataset()
    num_users = dataset.num_users
    num_items = dataset.num_items
    print
    'load datadone'

    _lambda = 0.001
    _K = 30

    datas = []
    for movie_id in range(1, num_items + 1):
        data = [id, movie_id, 0]
        datas.append(data)

    mf = MF(user_num=num_users, item_num=num_items, factor_num=_K, regs=_lambda)
    test_rate_pred = mf.predict(np.array(datas))
    rec_ids = []
    for i in range(num):
        rec_id = test_rate_pred.argmax()
        test_rate_pred = np.delete(test_rate_pred, rec_id)
        rec_ids.append(rec_id)
    return rec_ids


if __name__ == '__main__':
    random.seed(2018)

    args = parse_args()
    num_factors = args.num_factors
    learning_rate = args.lr
    epochs = args.epochs
    batch_size = args.batch_size
    lambda_values = [0., 0.001, 0.003, 0.006, 0.01, 0.03, 0.06, 0.1, 0.3, 0.6, 1., 3., 6., 10.]
    factors = range(10, 101, 10)
    early_stop = True

    # Loading data
    dataset = Dataset()
    trainRatings, validRatings, testRatings = dataset.trainRatings, dataset.validRatings, dataset.testRatings
    data_reader = DataReader(data=trainRatings, batch_size=batch_size)
    num_users = dataset.num_users
    num_items = dataset.num_items
    print('load data done.', ' Num users: ', num_users, ' Num items: ', num_items)

    # _lambda, _K, min_loss = get_the_best_hyper_parameters(trainRatings, validRatings, batch_size,
    #                                                       learning_rate, epochs=200)
    # print _lambda, _K, min_loss

    _lambda = 0.001
    _K = 30

    mf = MF(user_num=num_users, item_num=num_items, factor_num=_K, regs=_lambda)
    mf.build_graph()
    mf.trainer(learning_rate)
    mf.fit_and_evaluate_mrse(train=trainRatings, test=validRatings, batch_size=batch_size, epochs=epochs,
                             saved_model=True)

    mf = MF(user_num=num_users, item_num=num_items, factor_num=_K, regs=_lambda)
    test_rate_pred = mf.predict(testRatings)
    test_data_reader = DataReader(data=testRatings)
    print('RMSE on test data:', math.sqrt(mean_squared_error(test_data_reader._labels, test_rate_pred)))
