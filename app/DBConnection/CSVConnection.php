<?php

namespace App\DBConnection;

use App\DBConnection\Crud\CustomDBCrudInterface;

/**
 * Class that implements DB functionality for CSV file.
 *
 * @author Jose Maria Toribio
 */
class CSVConnection extends ResponseHttpApi implements CustomDBConnectionInterface, CustomDBCrudInterface
{
    private $connection;

    /**
     * Initialize the CSV database (file) connection
     *
     * @param string $DBname
     * @return void
     */
    public function connect(string $DBname): void
    {
        $dbPathFile = database_path() . '/files/csv/' . $DBname . '.csv';
        $dbPathFile = file_exists($dbPathFile) ? $dbPathFile : null;
        $this->setConnection($dbPathFile);
    }

    /**
     * Reads from database (CSV file)
     *
     * @return array
     * @throws \Exception
     */
    public function read(): array
    {
        if(empty($this->connection)) {
            throw new \Exception('Something went wrong with DB conection');
        }

        return $this->response(
            'success',
            200,
            $this->readCsvFile()
        );
    }

    /**
     * Writes into database (JSON file)
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function write(array $data): array
    {
        if (empty($this->connection) || empty($data)) {
            throw new \Exception('Something went wrong while writting to DB.');
        }

        $csvData = [];
        array_walk_recursive($data, function($value) use(&$csvData) {
            array_push($csvData, $value);
        });

        $handle = fopen($this->connection, 'a');
        $write = fputcsv($handle, $csvData);
        fclose($handle);

        if (!$write) {
            throw new \Exception('Something went wrong while writting to DB.');
        }

        return $this->response(
            'success',
            201,
            $data
        );
    }

    /**
     * Reads data from CSV file
     *
     * @return array
     */
    private function readCsvFile(): array
    {
        $results = [];
        if (($handle = fopen($this->connection, "r")) !== false) {
          fgetcsv($handle);
          while (($row = fgetcsv($handle)) !== false) {
              array_push($results, [
                  'text' => $row[0],
                  'createdAt' => $row[1],
                  'choices' => [
                      ['text' => $row[2]],
                      ['text' => $row[3]],
                      ['text' => $row[4]]
                  ]
              ]);
          }
          fclose($handle);
        }

        return $results;
    }

    /**
     * Assigns connection
     *
     * @param mixed $connection
     * @return void
     */
    protected function setConnection($connection): void
    {
        $this->connection = $connection;
    }
}
