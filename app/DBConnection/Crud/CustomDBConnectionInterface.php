<?php

namespace App\DBConnection\Crud;

/**
 * Interface for CRUD
 *
 * @author Jose Maria Toribio
 */
Interface CustomDBCrudInterface
{
    /**
     * Reads from DB
     *
     * @return array
     */
    public function read(): array;

    /**
     * Writes into DB
     *
     * @param array $data
     * @return array
     */
    public function write(array $data): array;
}
