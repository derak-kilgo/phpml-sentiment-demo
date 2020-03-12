<?php
namespace PhpmlExercise;
ini_set('memory_limit','25G');

require __DIR__ .'/vendor/autoload.php';

use Phpml\Classification\SVC;
use Phpml\Dataset\CsvDataset;
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


echo "Loading pipeline from file...\n";
$modelManager = new ModelManager();
$pipeline = $modelManager->restoreFromFile(__DIR__ . '/data/amazonreview.phpml');

echo "Loading data...\n";

$samples = ['Broken with in one week. I will never buy from this company again.',
    'Avoid at all costs. This is the worst seller on amazon.',
    'Loved it. Worth every penny.',
    'Super happy with my purchase'
];
$predicted = $pipeline->predict($samples);
var_dump($samples);
var_dump($predicted);

