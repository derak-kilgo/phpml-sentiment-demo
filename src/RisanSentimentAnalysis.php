<?php


namespace Demo;



use Phpml\Classification\Classifier;
use Phpml\Helper\Predictable;
use SentimentAnalysis\Analyzer;

class RisanSentimentAnalysis implements Classifier
{
    use Predictable;

    private $model;

    public function __construct()
    {
        $this->model = Analyzer::withDefaultConfig();
    }

    public function train(array $samples, array $targets): void
    {
        //Stub. This model is already trained.
    }

    /**
     * @param array $sample
     * @return string
     */
    protected function predictSample(array $sample)
    {
        $predict = [];
        foreach($sample as $index => $single){
            $result = $this->model->analyze($single);
            $predict[$index] = $result->category();
        }
        return $predict;
    }
}