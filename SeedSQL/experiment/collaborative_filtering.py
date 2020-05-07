import numpy as np
import pandas as pd

from sklearn.metrics.pairwise import cosine_similarity
from sklearn.cluster import SpectralClustering
from scipy import sparse


class CF(object):

    def __init__(self, data, k, dist_func=cosine_similarity):
        """
        Build item-item based rs
        :param data: enroll matrix (unary data (0, 1))
        :param categories: similarity btw each pairs of category
        :param k:
        :param dist_func:
        """
        self.data = data
        self.e_matrix = np.array(data.drop('user', axis=1))  # (n_users, n_items), drop user col
        self.users = np.array(data['user'])
        self.items = np.array(data.columns[1:])

        self.n_users = len(self.users)
        self.n_items = len(self.items)

        self.k = k
        self.dist_func = dist_func
        self.sim_matrix = None
        # print(self.n_users, self.n_items)
        # print(self.users, self.items)

    def normalize_matrix(self):
        """ Magnitude normalize
        Normalize the user vectors u0 = (0, 1, 0, ... 1) to express the importance of user' enroll between users.
        A enroll from a user who has only enroll 5 items is more valuable to us than a like from
        someone who enroll everything.
        :return:
        """
        magnitude = np.sqrt(np.square(self.e_matrix).sum(axis=1))
        assert magnitude.shape == (self.n_users, )
        self.e_matrix = np.divide(self.e_matrix, magnitude.reshape(self.n_users, 1) + 1e-8)

    def similarity(self):
        # Calculate sim item
        csr_matrix = sparse.csr_matrix(self.e_matrix)  # Compressed Sparse Row matrix
        self.sim_matrix  = self.dist_func(csr_matrix.T, csr_matrix.T)

    def fit(self):
        self.normalize_matrix()
        self.similarity()

    def predict(self, user_id, item_id):
        """
        Only predict if user u do not enroll course i
        :param u:
        :param i:
        :return:
        """
        # Get all course the user u has enrolled
        if self.e_matrix[user_id, item_id] > 0:
            return self.e_matrix[user_id, item_id]

        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]
        enrolled_c_vals = self.e_matrix[user_id, enrolled_c_ids]

        # Determine similar btw course i with those items
        sim = self.sim_matrix[item_id, enrolled_c_ids]
        c_neighbors = sim.argsort()[-self.k:]
        course_vals = enrolled_c_vals[c_neighbors]
        sim = sim[c_neighbors]

        return np.dot(sim, course_vals) / np.sum(self.sim_matrix[item_id])

    def recommend(self, user):
        # User u already enroll course i
        user_id = np.where(self.users == user)[0]
        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]

        items = {}
        for item_id in range(self.n_items):
            if item_id not in enrolled_c_ids:
                items[item_id] = self.predict(user_id, item_id)

        r_items = [k for k, v in sorted(items.items(), key=lambda i: -i[1])[:5]]
        return r_items

    def ground_truth(self, user, test_df):
        gt_items = []
        gt_row = test_df[test_df['username'] == user]
        if gt_row.empty:
            return []

        for idx, row in gt_row.iterrows():
            gt_item_id = np.where(self.items == row['course_id'])[0][0]
            gt_items.append(gt_item_id)

        return gt_items

    def evaluate(self, test_df):
        precision = 0
        recall = 0
        r_users = 0
        for idx, u in enumerate(self.users):
            r_items = self.recommend(u)
            gt_items = self.ground_truth(u, test_df)

            n_hit = np.sum([i in r_items for i in gt_items])
            n_as = len(gt_items)    # actualy set (users actualy enroll in test data)
            n_rs = len(r_items)     # recommend set

            if n_as != 0:
                print('-------------- {} -------------'.format(u))
                print('rs : {}'.format(r_items))
                print('gt : {}'.format(gt_items))

                r_users += 1
                precision += n_hit / n_rs
                recall += n_hit / n_as

        precision /= r_users
        recall /= r_users
        print(precision, recall)


if __name__ == '__main__':
    train = pd.read_csv('./enroll_train.csv')
    test = pd.read_csv('./enroll_test.csv')
    k_neighbor = 5

    rs = CF(train, k_neighbor)
    rs.fit()

    # -----------Test predict score ---------------
    # Get user_id, item_id
    user_id = np.where(rs.users == 'user1')[0]
    item_id = np.where(rs.items == 'course3')[0]
    score = rs.predict(user_id, item_id)
    print(score)

    # -----------Recommend for a user---------------
    items_id = rs.recommend('user1')
    print(rs.items[items_id])

    # ---------------------Evalute------------------
    rs.evaluate(test)
