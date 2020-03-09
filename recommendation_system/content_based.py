import numpy as np
import pandas as pd

from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.linear_model import Ridge
from sklearn import linear_model

# Reading user file:
u_cols = ['user_id', 'age', 'sex', 'occupation', 'zip_code']
users = pd.read_csv('ml-100k/u.user', sep='|', names=u_cols, encoding='latin-1')

n_users = users.shape[0]
print('Number of users:', n_users)

# Reading ratings file:
r_cols = ['user_id', 'movie_id', 'rating', 'unix_timestamp']

ratings_base = pd.read_csv('ml-100k/ua.base', sep='\t', names=r_cols, encoding='latin-1')
ratings_test = pd.read_csv('ml-100k/ua.test', sep='\t', names=r_cols, encoding='latin-1')

rate_train = ratings_base.values
rate_test = ratings_test.values

print('Number of traing rates:', rate_train.shape[0])
print('Number of test rates:', rate_test.shape[0])

# Reading items file:
i_cols = ['movie id', 'movie title', 'release date', 'video release date', 'IMDb URL', 'unknown', 'Action', 'Adventure',
          'Animation', 'Children\'s', 'Comedy', 'Crime', 'Documentary', 'Drama', 'Fantasy',
          'Film-Noir', 'Horror', 'Musical', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller', 'War', 'Western']

items = pd.read_csv('ml-100k/u.item', sep='|', names=i_cols,
                    encoding='latin-1')

n_items = items.shape[0]
print('Number of items:', n_items)

# Only get 19 last features to determine type of movie
X0 = items.values
X_train_counts = X0[:, -19:]

# Convert to TF-IDF vector. Instead of 0, 1 label, tf-idf convert to compare importance between
transformer = TfidfTransformer(smooth_idf=True, norm='l2')
tfidf = transformer.fit_transform(X_train_counts.tolist()).toarray()


# Tiếp theo, với mỗi user, chúng ta cần đi tìm những bộ phim nào mà user đó đã rated, và giá trị của các rating đó.
def get_items_rated_by_user(rate_matrix, user_id):
    """
    in each line of rate_matrix, we have infor: user_id, item_id, rating (scores), time_stamp
    we care about the first three values
    return (item_ids, scores) rated by user user_id
    """
    y = rate_matrix[:, 0]  # all users
    # item indices rated by user_id
    # we need to +1 to user_id since in the rate_matrix, id starts from 1
    # while index in python starts from 0
    rate_ids = np.where(y == user_id + 1)[0]
    item_ids = rate_matrix[rate_ids, 1] - 1  # index starts from 0
    rate_scores = rate_matrix[rate_ids, 2]
    return item_ids, rate_scores


d = tfidf.shape[1]  # data dimension
W = np.zeros((d, n_users))
b = np.zeros((1, n_users))

for n in range(n_users):
    ids, scores = get_items_rated_by_user(rate_train, n)
    clf = Ridge(alpha=0.01, fit_intercept=True)
    Xhat = tfidf[ids, :]

    clf.fit(Xhat, scores)
    W[:, n] = clf.coef_
    b[0, n] = clf.intercept_

# predicted scores
Yhat = tfidf.dot(W) + b
# Print sample
n = 100
ids, scores = get_items_rated_by_user(rate_test, 10)

print(W.shape)
print(b.shape)
print('Rated movies ids:', ids)
print('True ratings:', scores)
print('Predicted ratings:', Yhat[ids, n])