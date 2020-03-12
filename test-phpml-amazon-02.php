<?php
namespace PhpmlExercise;
//No set limit.
ini_set('memory_limit','-1');

require __DIR__ .'/vendor/autoload.php';

use Demo\CustomCsv;
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

/*
 * Re-load a modal and continue training
 */

echo "Loading pipeline from file...\n";
$modelManager = new ModelManager();
$modelFile = __DIR__ . '/data/amazonreview.phpml';
/** @var Pipeline $pipeline */
$pipeline = $modelManager->restoreFromFile($modelFile);

$filelist = [
//    __DIR__ . '/data/amazonreviews/split/xab',
//    __DIR__ . '/data/amazonreviews/split/xac',
//    __DIR__ . '/data/amazonreviews/split/xad',
];

foreach($filelist as $file){
    if(!file_exists($file)){
        die($file . ' is missing or cannot be read.');
    }
}

foreach($filelist as $file){
    echo "Loading ($file) data...\n";
    $dataset = new CustomCsv(0,1,
         $file,
        false,
        ',',
        500);
    echo "training model \n";
    $pipeline->train($dataset->getSamples(),$dataset->getTargets());
}

echo "re-Saving model...\n";
$modelManager->saveToFile($pipeline, $modelFile);

