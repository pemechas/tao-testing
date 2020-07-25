<?php

namespace App\DBConnection;

use App\DBConnection\Crud\CustomDBCrudInterface;

/**
 * Class that implements DB functionality for JSON file.
 *
 * @author Jose Maria Toribio
 */
class JSONConnection extends ResponseHttpApi implements CustomDBConnectionInterface, CustomDBCrudInterface
{
    private $connection;

    /**
     * Initialize the JSON database (file) connection
     *
     * @param string $DBname
     * @return void
     */
    public function connect(string $DBname): void
    {
        $dbPathFile = database_path() . '/files/json/' . $DBname . '.json';
        $dbPathFile = file_exists($dbPathFile) ? $dbPathFile : null;
        $this->setConnection($dbPathFile);
    }

    /**
     * Reads from database (JSON file)
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
            json_decode(file_get_contents($this->connection), true)
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

        $fileData = file_get_contents($this->connection);
        $fileData = json_decode($fileData, true);
        array_push($fileData, $data);

        if (!file_put_contents($this->connection, json_encode($fileData, JSON_PRETTY_PRINT))) {
            throw new \Exception('Something went wrong while writting to DB.');
        }

        return $this->response(
            'success',
            201,
            $data
        );
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
