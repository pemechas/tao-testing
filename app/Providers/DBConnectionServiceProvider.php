<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\DBConnection\CustomDBConnectionInterface;

/**
 * Service that determine what DB to use based on configuration file.
 *
 * @author Jose Maria Toribio
 */
class DBConnectionServiceProvider extends ServiceProvider
{
    CONST JSON_CONECTION = 'json';
    CONST CSV_CONECTION = 'csv';

    /**
     * Register services for different DB connections
     *
     * @return void
     */
    public function register()
    {
        /**
         * We get the database type from the config.
         * It can be modified in the .env file
         * under 'DB_CONNECTION' variable
         */
        $dbType = config('database.default');
        switch($dbType) {
            case self::JSON_CONECTION:
                $className = 'JSONConnection';
                break;
            case self::CSV_CONECTION:
                $className = 'CSVConnection';
                break;
            default:
                // Default DB connection to JSON file
                $className = 'JSONConnection';
        }

        $this->app->bind(
            CustomDBConnectionInterface::class,
            "App\\DBConnection\\{$className}",
        );
    }
}
