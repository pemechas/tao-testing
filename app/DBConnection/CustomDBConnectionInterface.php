<?php

namespace App\DBConnection;

/**
 * Interface for DB connection
 *
 * @author Jose Maria Toribio
 */
Interface CustomDBConnectionInterface
{
    /**
     * Makes DB connection
     *
     * @param string $DBname
     * @return void
     */
    public function connect(string $DBname): void;
}
