<?php

namespace Demo;

use Phpml\Dataset\ArrayDataset;
use Phpml\Exception\FileException;

class CustomCsv extends ArrayDataset {

    /**
     * @var array
     */
    protected $columnNames = [];

    /**
     * Allows me to pick which column is the label and which is the sample.
     * Limited to a single column for sample.
     * CustomCsv constructor.
     * @param int $labelColIndex
     * @param int $sampleColIndex
     * @param string $filepath
     * @param bool $headingRow
     * @param string $delimiter
     * @param int $maxLineLength
     * @throws FileException
     * @throws \Phpml\Exception\InvalidArgumentException
     */
    public function __construct(int $labelColIndex, int $sampleColIndex, string $filepath, bool $headingRow = false, string $delimiter = ',', int $maxLineLength = 0)
    {
        if (!file_exists($filepath)) {
            throw new FileException(sprintf('File "%s" missing.', basename($filepath)));
        }

        $handle = fopen($filepath, 'rb');
        if ($handle === false) {
            throw new FileException(sprintf('File "%s" can\'t be open.', basename($filepath)));
        }

        if ($headingRow) {
            $data = fgetcsv($handle, $maxLineLength, $delimiter);
            $this->columnNames = array_slice((array) $data, 0, 1);
        } else {
            $this->columnNames = range(0,1);
        }

        $samples = $targets = [];
        while (($data = fgetcsv($handle, $maxLineLength, $delimiter)) !== false) {
            if(!empty($data[$sampleColIndex]) && !empty($data[$labelColIndex])) {
                $samples[] = $data[$sampleColIndex];
                $targets[] = $data[$labelColIndex];
            }
        }
        fclose($handle);
        parent::__construct($samples, $targets);
    }

    public function getColumnNames(): array
    {
        return $this->columnNames;
    }
}