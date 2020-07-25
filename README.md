## Tao Testing test Jose Maria Toribio
All the changes done by me are tagged with `@author Jose Maria Toribio`

## Changing DB 
Change the enviroment variable `DB_CONNECTION` in `.env` file to either `csv` or `json`
You will need to run `php artisan config:cache` for changes to be applied

## DB files 
* DB files for JSON are store under `database/files/json`
* DB files for CSV are store under `database/files/csv`
