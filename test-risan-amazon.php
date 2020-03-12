<?php
namespace PhpmlExercise;
//No set limit.
ini_set('memory_limit','-1');

require __DIR__ .'/vendor/autoload.php';

use Demo\AFINNSentimentAnalysis;
use Demo\CustomCsv;
use Demo\RisanSentimentAnalysis;
use Phpml\Classification\SVC;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Dataset\CsvDataset;
use Phpml\Exception\FileException;
use Phpml\FeatureExtraction\StopWords;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\ModelManager;
use Phpml\Pipeline;
use Phpml\Preprocessing\Imputer;
use Phpml\Tokenization\NGramTokenizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Classification\NaiveBayes;
use Phpml\Metric\Accuracy;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\StopWords\English;
use Phpml\Transformer;

echo "Loading data...\n";
$dataset = new CustomCsv(0,1,
    __DIR__ . '/data/amazonreviews/split/xaa',
    false,
    ',',
    500);

echo "Testing model ... \n";
$classifier = new RisanSentimentAnalysis();
$predicted = $classifier->predict($dataset->getSamples());
echo 'Accuracy: ' . Accuracy::score($dataset->getTargets(), $predicted) . "\n";