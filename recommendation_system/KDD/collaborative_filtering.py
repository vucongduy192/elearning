import numpy as np
import pandas as pd

from sklearn.metrics.pairwise import cosine_similarity
from sklearn.cluster import SpectralClustering
from scipy import sparse


class CF(object):

    def __init__(self, data, simC, k, c=0.8, dist_func=cosine_similarity):
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
        self.items = np.array(data.columns[1:].astype(int))

        self.n_users = len(self.users)
        self.n_items = len(self.items)

        self.k = k
        self.c = c
        self.dist_func = dist_func
        self.simI_matrix = None
        self.simC_matrix = np.array(simC.drop('course_id', axis=1))
        print(self.n_users, self.n_items)
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
        self.simI_matrix  = self.dist_func(csr_matrix.T, csr_matrix.T)
        # print(self.simI_matrix)
        assert self.simI_matrix.shape == (self.n_items, self.n_items)
        self.sim_matrix = self.c * self.simC_matrix + (1-self.c) * self.simI_matrix

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

    def recommend(self, user_id):
        # User u already enroll course i
        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]

        items = {}
        for item_id in range(self.n_items):
            if item_id not in enrolled_c_ids:
                items[item_id] = self.predict(user_id, item_id)

        r_items = [k for k, v in sorted(items.items(), key=lambda i: -i[1])[:5]]
        return r_items

    def ground_truth(self, user_id):
        gt_items = []
        gt_row = test_df[test_df['user'] == user_id]
        if gt_row.empty:
            return []

        for col in gt_row.columns:
            if col != 'user' and gt_row[col].values[0] > 0:
                gt_items.append(col)
        return gt_items

    def evaluate(self, test_df):
        precision = 0
        recall = 0
        n_users = 0
        for idx, u in enumerate(rs.users):
            r_items = self.recommend(u)
            gt_items = self.ground_truth(u)

            n_hit = len([i in r_items for i in gt_items])
            n_hidden = len([i not in r_items for i in gt_items])
            n_rs = len(r_items)

            if n_hidden != 0:
                n_users += 1
                precision += n_hit / n_rs
                recall += n_hit / n_hidden

            print('-------------- {} -------------'.format(u))
            print('rs : {}'.format(r_items))
            print('gt : {}'.format(gt_items))

        precision /= n_users
        recall /= n_users
        print(precision, recall)

    def example(self, user_id, courses_df, users_df):
        # print(self.e_matrix[user_id])
        enrolled_c_ids = np.where(self.e_matrix[user_id].flatten() > 0)[0]
        enrolled_c = courses_df[courses_df['course_id'].isin(enrolled_c_ids)][['course_id', 'category']]
        print(enrolled_c)

        r_items = self.recommend(user_id)
        gt_items = self.ground_truth(user_id)
        print(r_items, gt_items)
        return enrolled_c


if __name__ == '__main__':
    """
    course id cluster [2 4 2 0 4 1 1 5 5 1 1 0 3 0 3 0 5 3 3 2] before shuffle
    user 2 category [37, 40, 49, 50, 56, 57, 89, 113, 126, 127, 130, 139, 151, 159, 162, 166, 167, 178, 185, 198, 229, 231, 234]
    unique_2_category = []
    for i in range(rs.n_users):
        enrolled_c_ids = np.where(rs.e_matrix[i].flatten() > 0)[0]
        enrolled_c = courses_df[courses_df['course_id'].isin(enrolled_c_ids)][['course_id', 'category']]

        if len(enrolled_c.category.unique()) < 3:
            print(i, enrolled_c)
            unique_2_category.append(i)

    print(unique_2_category)
    """

    data_df = pd.read_csv('./enroll_matrix_train.csv')
    test_df = pd.read_csv('./enroll_matrix_test.csv')
    users_df = pd.read_csv('./users.csv')
    courses_df = pd.read_csv('./courses.csv')
    simC = pd.read_csv('./simC_matrix.csv')

    k_neighbor = 3

    rs = CF(data_df, simC, k_neighbor, c=0.2)
    rs.fit()

    """
        rs.evaluate(test_df)
        Consider user_id = 
        Enrolled 5 course in "Math and Logic" & "Personal Development"
        Normal CF Recommend:
            + With c = 0.2 (weight for simC):
                course 10 in "Math and Logic"
                course 12  in "Personal Development"
        [2, 6, 13, 3, 18] []
    """

    rs.example(37, courses_df, users_df)
