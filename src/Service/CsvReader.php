<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Service;

use Fahim\CommissionTask\Exception\ColumnsNotFoundException;
use Fahim\CommissionTask\Exception\FileCanNotOpenException;
use Fahim\CommissionTask\Exception\FileNotFoundException;
use Fahim\CommissionTask\Exception\NoDataFoundException;

/**
 * Read CSV file and convert to an array with provided columns
 */
class CsvReader
{
    /**
     * Csv file
     *
     * @var mixed
     */
    private $file;

    /**
     * Name of columns
     * @var array
     */
    private $columns;

    /**
     * File and columns
     *
     * @param mixed $file
     * @param array $columns
     */
    public function __construct($file = null, array $columns=[])
    {
        $this->init($file, $columns);
    }

    /**
     * Initialization
     *
     * @param mixed $file
     * @param array $columns
     * @return void
     */

    protected function init($file, array $columns)
    {
        $this->setFile($file);

        $this->setColumns($columns);
    }

    /**
     * Process and get array data
     *
     * @return array
     */
    public function toArray(): array
    {
        $processedToArray = $this->processCsvFile();
        if (empty($processedToArray)) {
            throw new NoDataFoundException('No data found');
        }
        return $processedToArray;
    }


    /**
     * Set file
     *
     * @param mixed $file
     * @return self
     */
    private function setFile($file):self
    {
        if (empty($file)) {
            throw new FileNotFoundException('File not found');
        }

        $this->file = $file;

        return $this;
    }


    /**
     * Set Columns
     *
     * @param array $columns
     * @return self
     */
    private function setColumns(array $columns):self
    {
        if (empty($columns)) {
            throw new ColumnsNotFoundException('Columns not found');
        }

        $this->columns = $columns;

        return $this;
    }

    /**
     * read and process
     *
     * @return array
     */
    private function processCsvFile(): array
    {
        if (($handle = fopen($this->file, "r")) === false) {
            throw new FileCanNotOpenException('Failed to open file');
        }
        
        $rowNo = 0;
        $rawData = [];

        while (($row = fgetcsv($handle, null, ",")) !== false) {
            $rawData[] = $this->remapToAssocArray($row);
            $rowNo++;
        }

        fclose($handle);
        
        return $rawData;
    }

    /**
     * Assign in to associative array by columns
     *
     * @param array $row
     * @return array
     */
    private function remapToAssocArray(array $row): array
    {
        foreach ($this->columns as $key => $column) {
            $temp[$column] = $row[$key];
        }

        return $temp;
    }
}
