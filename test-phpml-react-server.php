<?php

use Phpml\ModelManager;
use Sentiment\Analyzer;

ini_set('memory_limit','12G');

require __DIR__ .'/vendor/autoload.php';
$loop = React\EventLoop\Factory::create();

$modelManager = new ModelManager();
$pipeline = $modelManager->restoreFromFile(__DIR__ . '/data/amazonreview.phpml');

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($pipeline){
    $params = $request->getQueryParams();
    $test = '';
    if(isset($params['test'])){
        $test = $params['test'];
    }
    $label = $pipeline->predict([$test]);

    //Using a different tools for analysis.
    $analyzer = SentimentAnalysis\Analyzer::withDefaultConfig();
    $result = $analyzer->analyze($test);

    $analyzer = new \Sentiment\Analyzer();
    $vader = $analyzer->getSentiment($test);

    return new React\Http\Response(
    200,
        array('Content-Type' => 'Application/json charset=utf8'),
        json_encode(
            [
                'input'=>$test,
                'phpml'=>
                    [
                        'result'=>$label
                    ],
                'risan'=>
                    [
                        'result'=>$result->category(),
                        'score'=>$result->scores()
                    ],
                'vader'=>
                [
                    'result'=>$vader
                ]
            ],
            JSON_PRETTY_PRINT
        )
    );
});

$socket = new React\Socket\Server(8080, $loop);
$server->listen($socket);
echo "Server running at http://127.0.0.1:8080\n CTRL+C to exit.\n";
$loop->run();
