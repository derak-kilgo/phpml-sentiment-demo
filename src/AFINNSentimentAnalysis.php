<?php


namespace Demo;


use CertifiedWebNinja\Caroline\Analysis;
use Phpml\Classification\Classifier;
use Phpml\Helper\Predictable;

class AFINNSentimentAnalysis implements Classifier
{
    use Predictable;

    private $model;

    public function __construct()
    {
        $this->model = new Analysis;
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
            $score = $result->getScore();
            if($score > 0){
                $predict[$index] = 'positive';
            }elseif($score < 0 ){
                $predict[$index] = 'negative';
            }else{
                $predict[$index] = 'neutral';
            }
        }
        return $predict;
    }
}