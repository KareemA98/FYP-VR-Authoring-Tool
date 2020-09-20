# FYP-VR-Authoring-Tool
This is a repo of the code used for my Final Year Project, this projects goal was to make a website which allowed users to create a VR enviroment that they can see on their phone.

* A website was created using HTML, CSS and JavaScript.
* The website was interactive and allowed the user the freedom to place objects, change the size of rooms, have multiple rooms, load previous creations, make tasks to be completed and add sounds
* A database was set up using MySQL
* The website connects to the Database using PHP to send and recive data.
* Using the Unity Game Engine a mobile application was made which using C# scripts receivees data from the database using PHP on what the user desinged on the webiste and then 
# Process
Data Collection was done using a python script with the selenium library. This process used python multiprocessing to make the process as efficient as possible.
Data transformation by converting the resulting XML files into a single CSV file. During this process, missing values were fixed.
Feature engineering was also done: categorical values were one-hot encoded, a database containing additional data was connected to instances of the dataset, features were combined and removed and finally overhauled of features was done to make sure each instance was able to accurately modelled in the same number of features.
The dataset was split up into three smaller datasets for use as a train, test and validation sets.
7 different machine learning models were tuned and compared to find the best possible model. The models used were Lasso, ElasticNet, Sequential, LSTM, BILSTM, XGB and LGB.
The results showed a stacked combination of XGB and LGB produced the best results with the dataset. With these models, we were able to get an 0.86 R2 Value over the dataset.
Libraries, Tools and Methods
Python Libraries:

Numpy
Pandas
Sci-Kit Learn
SciPy
Keras
XGB
LGB
Selenium
Python Multiprocessing
XML
openpyx1
venv
Tools used:

Excel
WEKA
MATLAB
LaTeX
Deep Feature Selection Methods:

AFS: https://github.com/upup123/AAAI-2019-AFS
CancelOut: https://github.com/unnir/CancelOut
Concrete Autoencoders: https://github.com/mfbalin/Concrete-Autoencoders
TSFS: https://github.com/alimirzaei/TSFS
