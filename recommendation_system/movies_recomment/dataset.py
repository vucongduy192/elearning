"""
Created on Aug 8, 2016
Processing datasets.

@author: Xiangnan He (xiangnanhe@gmail.com)
"""
import scipy.sparse as sp
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split


class Dataset(object):

    def __init__(self):
        trainRatings, validRatings, testRatings, num_users, num_items = self.load_data()
        self.trainRatings = trainRatings
        self.testRatings = testRatings
        self.validRatings = validRatings
        self.num_users = num_users
        self.num_items = num_items

    def load_data(self):
        r_cols = ['user_id', 'movie_id', 'rating', 'time']

        ratings_base = pd.read_csv('ml-1m/ratings.dat', sep='::', names=r_cols, encoding='latin-1')
        ratings = ratings_base.values

        num_users = np.max(ratings[:, 0])
        num_items = np.max(ratings[:, 1])
        # indices in Python start from 0
        ratings[:, :2] -= 1
        rate_train, rate_test = train_test_split(ratings, test_size=0.1, random_state=42)
        rate_train, rate_valid = train_test_split(rate_train, test_size=0.1, random_state=42)

        return rate_train, rate_valid, rate_test, num_users, num_items