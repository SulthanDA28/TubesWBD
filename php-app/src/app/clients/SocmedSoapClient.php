<?php

require_once SRC_ROOT_PATH . "/app/utils/SoapWrapper.php";

class SocmedSoapClient
{
    private static $instance;
    private $client;

    private function __construct()
    {
        $opts = array(
            'http' => array(
                'header' => 'Authorization: ' . getenv("MONOLITHIC_SOAP_API_KEY"))
        );

        $params = array(
            'encoding' => 'UTF-8',
            'soap_version' => 'SOAP_1_2',
            'trace' => 1,
            'exceptions' => 1,
            'connection_timeout' => 180,
            'stream_context' => stream_context_create($opts),
        );
 
        $this->client = new SoapWrapper($_ENV['MONOLITHIC_SOAP_URL'], $params);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function requestUnlocking($socmed_id, $link_code)
    {
        $res = $this->client->call("requestUnlocking", array(
            'socmed_id' => $socmed_id,
            'link_code' => $link_code,
        ));
        return $res;
    }

    public function getUnlocking()
    {
        $res = $this->client->call("getUnlocking", null);
        return $res;
    }

    public function getUnlockingBySocmedId($socmed_id)
    {
        $response = self::getInstance()->getUnlockingBySocmedId(
            array(
                "socmed_id" => $socmed_id,
            )
        );
        return $response;
    }

    public function verifyUnlocking($socmed_id, $dashboard_id, $link_code)
    {
        $res = $this->client->call("verifyUnlocking", array(
            'arg0' => $socmed_id,
            'arg1' => $dashboard_id,
            'arg2' => $link_code,
        ));
        return $res;
    }
}
