<?php
namespace PhpmlExercise;
//No set limit.
ini_set('memory_limit','-1');

require __DIR__ .'/vendor/autoload.php';

use Demo\CustomCsv;
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
$split = new StratifiedRandomSplit($dataset, 0.1);
unset($dataset);

echo "Assemble pipeline...\n";
$pipeline = new Pipeline([
    new TokenCountVectorizer(new NGramTokenizer(3, 5), new English()),
    new TfIdfTransformer()
], new NaiveBayes());

echo "Training model...\n";
$pipeline->train($split->getTrainSamples(),$split->getTrainLabels());

echo "Testing model ...\n";
$predicted = $pipeline->predict($split->getTestSamples());
echo 'Accuracy: ' . Accuracy::score($split->getTestLabels(), $predicted) . "\n";

echo "Saving model...\n";
$modelManager = new ModelManager();
$modelManager->saveToFile($pipeline, __DIR__ . '/data/amazonreview.phpml');
