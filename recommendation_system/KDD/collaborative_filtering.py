import numpy as np
import pandas as pd

from sklearn.metrics.pairwise import cosine_similarity
from scipy import sparse


class CF(object):

    def __init__(self, data, k, dist_func=cosine_similarity):
        """
        Build item-item based rs
        :param data: enroll matrix (unary data (0, 1))
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
        self.similar_matrix = None

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
        csr_matrix = sparse.csr_matrix(self.e_matrix)  # Compressed Sparse Row matrix
        self.similar_matrix = self.dist_func(csr_matrix.T, csr_matrix.T)
        assert self.similar_matrix.shape == (self.n_items, self.n_items)

    def fit(self):
        self.normalize_matrix()
        self.similarity()

    def predict(self, u, i):
        """
        Only predict if user u do not enroll course i
        :param u:
        :param i:
        :return:
        """
        # Get all course the user u has enrolled
        user_id = np.where(self.users == u)[0][0]
        course_id = np.where(self.items == i)[0][0]
        if self.e_matrix[user_id, course_id] > 0:
            self.e_matrix[user_id, course_id]
        # cac course duoc enroll boi user u
        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]
        enrolled_c_vals = self.e_matrix[user_id, enrolled_c_ids]
        # print(enrolled_c_ids, enrolled_c_vals)

        # Determine similar btw course i with those items
        simI = self.similar_matrix[course_id, enrolled_c_ids]
        c_neighbors = simI.argsort()[-self.k:]
        course_vals = enrolled_c_vals[c_neighbors]
        simI = simI[c_neighbors]
        # print(simI, course_vals, c_neighbors)

        return np.dot(simI, course_vals) / np.sum(self.similar_matrix[course_id])

    def recommend(self, u):
        # User u already enroll course i
        user_id = np.where(self.users == u)[0][0]
        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]

        items = {}
        for idx, i in enumerate(self.items):
            if idx not in enrolled_c_ids:
                items[i] = self.predict(u, i)
        return items


if __name__ == '__main__':
    """
        39 courses
        720 users
    """
    data_df = pd.read_csv('./enroll_matrix_train.csv')
    test_df = pd.read_csv('./enroll_matrix_test.csv')

    k_neighbor = 3

    rs = CF(data_df, k_neighbor)
    rs.fit()
    # score = rs.predict('user0', 'course7')
    # print(score)
    total = 0
    for idx, u in enumerate(rs.users):
        r_items = rs.recommend(u)
        r_items = [k for k, v in sorted(r_items.items(), key=lambda item: -item[1])[:5]]

        gt_row = test_df[test_df['user'] == u]
        gt_items = []
        display = False
        if not gt_row.empty:
            for col in gt_row.columns:
                if col != 'user' and gt_row[col].values[0] > 0:
                    if col in r_items:
                        display = True
                        total += 1
                    gt_items.append(col)
        if display:
            print(u)
            print('Recommend for {} : {}'.format(u, r_items))
            print('Gt enrolled of {} : {}'.format(u, gt_items))
    print(total)
