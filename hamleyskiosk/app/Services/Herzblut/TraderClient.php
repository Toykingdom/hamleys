<?php

namespace App\Services\Herzblut;

use Illuminate\Support\Facades\App;
use SoapClient;

class TraderClient
{
    public static $client;
    public static $customerTypeIds = [28]; // set the Customer Type Ids here. 28 = Hamleys

    static public function client()
    {
        if (is_object(static::$client)) {
            return static::$client;
        }

        $wsdl = dirname(__FILE__) . "/WSDL/integrity.wsdl";


        if (file_exists($wsdl)) {
            static::$client = new SoapClient($wsdl, array(
                'trace' => true,
                'keep_alive' => true,
                'connection_timeout' => 5000,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
            ));
        } else {
            trigger_error("Unknown wsdl file: $wsdl", E_USER_ERROR);
        }

        return static::$client;

    }

    static protected function loadSQL($file)
    {
        return file_get_contents(dirname(__FILE__) . '/Queries/' . $file . '-sql.php');
    }

    static public function fetchCustomer($account_code)
    {
        $limit = 1;
        $where = "DB_ACCOUNTCODE = '$account_code'";
        $sql = sprintf(static::loadSQL("customers"), $limit, $where);
        return static::resultsToSingle(static::client()->CustomQuery($sql));
    }

    static public function searchCustomers($search)
    {
        $limit = 1000;
        $where = [];
        $search_txt = '%' . strtoupper($search) . '%';
        $where[] = "UPPER(DB_ACCOUNTCODE) LIKE '" . $search_txt . "'";
        $where[] = "UPPER(DB_EMAILADDRESS) LIKE '" . $search_txt . "'";
        $where[] = "DB_MOBILE LIKE '" . $search_txt . "'";
//        $where[] = "UPPER(DB_NAME) LIKE '" . $search_txt . "'";
//        $where[] = "UPPER(DB_CONTACT) LIKE '" . $search_txt . "'";
        $where_search = implode(" OR ", $where);

        $where_str = "DB_CUSTOMERTYPE_ID IN (" . implode(",", static::$customerTypeIds) . ")";
        //$where_str .= App::environment('production') ? "" : " AND UPPER(DB_ACCOUNTCODE) LIKE 'HB%'";
        $sql = sprintf(static::loadSQL("customers"), $limit, $where_str . " AND (" . $where_search . ")");
        return static::resultsToArray(static::client()->CustomQuery($sql));
    }

    /**
     * @param TraderCustomer $customer
     * @return mixed
     */
    static public function sendCustomer(TraderCustomer $customer)
    {
        $response = static::client()->AddCustomer($customer->mapClassToTrader());
        return !!(is_object($response) && isset($response->Resultcode) && $response->Resultcode === 0);
    }

    /**
     * Convert a CSV string (returned from Trader queries) to an associative array
     * The first row is always the header, so we extract that first and use each column as the associative array's key names
     * @param $results
     * @return array
     */
    static public function resultsToArray($results)
    {
        $rows = array_map('str_getcsv', $results);
        $header = array_shift($rows);

        $result = [];
        foreach($rows as $i => $item) {
            foreach($item as $y => $col) {
                $key = strtolower($header[$y]);
                $result[$i][$key] = $col;
            }
        }

        return $result;
    }

    static public function resultsToSingle($results)
    {
        $rows = static::resultsToArray($results);
        return is_array($rows) && isset($rows[0]) ? $rows[0] : null;
    }

    static public function normalizeArray($rows, $class) {
        $result = [];
        foreach($rows as $row) {
            $result[] = static::normalizeSingle($row, $class);
        }

        return $result;
    }

    static public function normalizeSingle($item, $class) {
        $class = "App\\Services\\Herzblut\\" . $class;
        return new $class($item, 'trader');
    }

    static public function logErrors($error = null)
    {
        $logs = [
            "soap_error" => $error,
            "request" => static::client()->__getLastRequest(),
            "response" => static::client()->__getLastResponse(),
            "response_headers" => static::client()->__getLastResponseHeaders()
        ];
    }
}
