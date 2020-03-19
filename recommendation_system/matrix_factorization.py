import numpy as np
import pandas as pd


class MF(object):

    def __init__(self, Y_data, K, lam = 0.1, X_init = None, W_init = None,
                learning_rate = 0.5, max_iter = 1000, print_every = 100):

        self.Y_raw_data = Y_data
        # number latent features need to learn
        self.K = K
        # regularization parameter
        self.lam = lam
        # learning rate for gradient descent
        self.learning_rate = learning_rate
        # maximum number of iterations
        self.max_iter = max_iter
        # print results after print_every iterations
        self.print_every = print_every
        # user-based or item-based

        # number of users, items, and ratings.
        self.n_users = np.max(self.Y_raw_data[:, 0]) + 1
        self.n_items = np.max(self.Y_raw_data[:, 1]) + 1
        self.n_ratings = self.Y_raw_data.shape[0]

        self.X = np.random.randn(self.n_items, K) if X_init is None else X_init
        self.W = np.random.randn(K, self.n_users) if W_init is None else W_init
        self.Y_data = self.Y_raw_data.copy()

    def normalize_Y(self):
        items_col = self.Y_raw_data[:, 1]
        # non-unique values of movies from all records in Y_data

        self.mu = np.zeros((self.n_items,))
        # Cal mu for to normalize each items by subtract mu
        # ------- u0 -- u1 -- u2 -- u3 ------- mu  (len = n_items)
        # i1       3     4     ?     6         4.3
        # i2      ...   ...
        # i3      ...   ...

        # Traversal each items
        for n in range(self.n_items):
            ids = np.where(items_col == n)[0].astype(np.int32)
            user_ids = self.Y_raw_data[ids, 0]
            ratings = self.Y_raw_data[ids, 2]

            m = np.mean(ratings) # mean rating for this items from all rated users
            self.mu[n] = 0 if np.isnan(m) else m
            self.Y_data[ids, 2] = ratings - self.mu[n]

    def loss(self):
        L = 0
        N = self.n_users
        for n in range(N):
            M, ratings = self.get_items_rated_by_user(n)
            for m, rating in zip(M, ratings):
                # user n rated item m a predict_value
                predict_rating = self.X[m, :].dot(self.W[:, n])
                L += (rating - predict_rating) ** 2

        L /= self.n_ratings
        L += 0.5*self.lam*(np.linalg.norm(self.X, 'fro') + np.linalg.norm(self.W, 'fro'))
        return L

    def get_users_who_rate_item(self, item_id):
        items_col = self.Y_data[:, 1]
        ids = np.where(items_col == item_id)[0]
        N, ratings = self.Y_data[ids, 0], self.Y_data[ids, 2]
        return (N, ratings)

    def get_items_rated_by_user(self, user_id):
        users_col = self.Y_data[:, 0]
        ids = np.where(users_col == user_id)[0]
        M, ratings = self.Y_data[ids, 1], self.Y_data[ids, 2]
        return (M, ratings)

    def updateW(self):
        # Keep X, update W to minimal loss
        N = self.n_users
        for n in range(N):
            M, ratings = self.get_items_rated_by_user(n)
            Xm = self.X[M, :] # all item features  (M, K) each item m in M has K features

            grad = np.transpose(Xm) * (ratings - np.dot(Xm, self.W)) + self.lam * self.W[:, n]
            grad = grad / self.n_ratings

            self.W[:, n] -= self.learning_rate * grad.reshape((self.K,))

    def fit(self):
        self.normalize_Y()
        for it in range(self.max_iter):
            # self.updateX()
            self.updateW()
            if (it + 1) % self.print_every == 0:
                rmse_train = self.evaluate_RMSE(self.Y_raw_data)
                print('iter =', it + 1, ', loss =', self.loss(), ', RMSE train =', rmse_train)

    def pred(self, u, i):
        """
        predict the rating of user u for item i
        if you need the un
        """
        bias = self.mu[i]
        pred = self.X[i, :].dot(self.W[:, u]) + bias
        if pred < 1:
            return 1
        if pred > 5:
            return 5
        return pred

    def evaluate_RMSE(self, rate_test):
        n_tests = rate_test.shape[0]
        SE = 0 # squared error
        for n in range(n_tests):
            pred = self.pred(rate_test[n, 0], rate_test[n, 1])
            SE += (pred - rate_test[n, 2])**2

        RMSE = np.sqrt(SE/n_tests)
        return RMSE

if __name__ == '__main__':

    r_cols = ['user_id', 'movie_id', 'rating', 'unix_timestamp']

    ratings_base = pd.read_csv('ml-100k/ub.base', sep='\t', names=r_cols, encoding='latin-1')
    ratings_test = pd.read_csv('ml-100k/ub.test', sep='\t', names=r_cols, encoding='latin-1')

    rate_train = ratings_base.values
    rate_test = ratings_test.values

    # indices start from 0
    rate_train[:, :2] -= 1
    rate_test[:, :2] -= 1

    rs = MF(rate_train, K=10, lam=.1, print_every=10,
            learning_rate=0.75, max_iter=100)
    rs.fit()
