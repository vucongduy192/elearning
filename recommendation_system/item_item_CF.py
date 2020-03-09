# File ex.txt mô tả dữ liệu đã biết cho ví dụ.
# Thứ tự của ba cột là user_id, item_id, và rating.
# Ví dụ, hàng đầu tiên nghĩa là u_0 rates i_0 số sao là 5.

import pandas as pd
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
from scipy import sparse


class CF(object):
    """docstring for CF"""

    def __init__(self, Y_data, k, uuCF=1):
        self.uuCF = uuCF  # user-user (1) or item-item (0) CF
        self.Y_data = Y_data if uuCF else Y_data[:, [1, 0, 2]]
        self.k = k  # number of neighbor points
        self.dist_func = cosine_similarity
        self.Ybar_data = None

        # number of users and items. Remember to add 1 since id starts from 0
        self.n_users = int(np.max(self.Y_data[:, 0])) + 1
        self.n_items = int(np.max(self.Y_data[:, 1])) + 1

    def add(self, new_data):
        """
        Update Y_data matrix when new ratings come.
        For simplicity, suppose that there is no new user or item.
        """
        self.Y_data = np.concatenate((self.Y_data, new_data), axis=0)

    def normalize_Y(self):
        users = self.Y_data[:, 0]  # all users - first col of the Y_data
        self.Ybar_data = self.Y_data.copy()
        self.mu = np.zeros((self.n_users,))  # mean

        for n in range(self.n_users):
            pass


# data file
r_cols = ['user_id', 'item_id', 'rating']
ratings = pd.read_csv('ex.txt', sep=' ', names=r_cols, encoding='latin-1')
Y_data = ratings.values
print(Y_data)
print(Y_data.shape)

rs = CF(Y_data, k=2, uuCF=1)
