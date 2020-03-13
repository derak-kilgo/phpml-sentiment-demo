#Code samples from "Data Science with PHP Machine Learning"
Austin PHP Meet-up - Mar.12, 2020
https://www.meetup.com/austinphp/events/mtdbrqybcfbqb/

To use these examples; you'll also need to download a dataset to work with.
The source data set is from kaggle.com
https://www.kaggle.com/bittlingmayer/amazonreviews
I reformatted it into a CSV
https://www.derakkilgo.com/files/datasets/amazonreviews/
The "split" folder contains parts of the larger set which should be easier to test with.

Code requires php 7.2 or better.
All samples are run from the command line.

##Files
* test-afin.amazon.php - statistics based sentament analysis using "CertifiedWebNinja\Caroline\Analysis" library.
* test-risan-amazon.php - statistics based sentament analysis using "davmixcool/php-sentiment-analyzer" library.
* test-phpml-amazon-01.php - Sample of creating a pipeline and NaiveBays model for sentament analysis.
* test-phpml-amazon-02.php - Sample re-loading a saved pipeline and doing additional training.
* test-phpml-amazon-03.php - Sample re-loading a saved pipeline and doing arbitrary testing with the model.
* test-phpml-react-server.php - Sample loading saved pipeline into a php server and doing arbitrary testing via a web client.

