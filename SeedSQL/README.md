## Dataset processing

#### Set up SeedSQL
- Config TOP_COURSE, TOP_ENROLL to filter raw dataset
- Declare all courses's name corresponding TOP_COURSE, user will be set by index [user0, user1, ...user_n] to 
- Specific version to save new dataset in experiment
- Run ProcessDataset

#### Set up Experiment
+ Run ExportEnrollMatrix to create new input from new dataset
+ Execute collaborative_filtering.py to show new precision and recall
