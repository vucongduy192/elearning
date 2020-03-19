Dataset:
**train:**
    - enrollment_train.csv: raw data from KDD dataset
    - enroll_train.csv: 
        + filter only user_id enroll greater 5 times 
        + add new 2 column user(user0, user1) and course(course0, course1)
**test:**
    - enrollment_test.csv: raw data from KDD dataset
    - enroll_test.csv:
        + Filter to only get user_id, course_id appear in enroll_train 
        + add new 2 column user(user0, user1) and course(course0, course1) 
