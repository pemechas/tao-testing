<?php
namespace App\Http\Controllers;

use App\DBConnection\CustomDBConnectionInterface;
use Illuminate\Http\Request;
use App\libs\Translate;

/**
 * Controller for Questions
 *
 * @author Jose Maria Toribio
 */
class QuestionController extends Controller
{
    CONST VALID_DB_CONNECTIONS = [
        'App\DBConnection\CSVConnection',
        'App\DBConnection\JSONConnection'
    ];

    public function __construct(CustomDBConnectionInterface $dbConnection)
    {
        if (empty($dbConnection) ||
            !in_array(get_class($dbConnection), self::VALID_DB_CONNECTIONS)
        ) {
            return response()->json([
                'error' => 'Something went wrong with DB conection.'
            ], 500);
        }

        $this->dbConnection = $dbConnection;
        $this->dbConnection->connect('questions');
    }

    public function index(Request $request)
    {
        if (empty($this->dbConnection)) {
            return response()->json([
                'error' => 'Something went wrong with DB conection.'
            ], 500);
        }

        $lang = $request->get('lang');
        if (is_null($lang)) {
            return response()->json([
                'error' => 'Bad request. Query paramater "lang" is missing from the request.'
            ], 400);
        }

        $results = $this->dbConnection->read();

        $str = new Translate($lang);
        $results['data'] = $str->translateArray($results['data']);

        return response()->json($results, $results['code']);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data) ||
            !isset($data['text']) ||
            !isset($data['createdAt']) ||
            !isset($data['choices']) ||
            !is_array($data['choices']) ||
            count($data['choices']) !== 3
        ) {
            return response()->json([
                'error' => 'Data provided is incorrect.'
            ], 500);
        }

        $response = $this->dbConnection->write($data);

        return response()->json($response, $response['code']);
    }
}
