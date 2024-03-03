<?php

require_once SRC_ROOT_PATH . "/baseclasses/BaseService.php";
require_once SRC_ROOT_PATH . "/utils/SoapWrapper.php";
require_once SRC_ROOT_PATH . "/clients/SocmedSoapClient.php";
require_once SRC_ROOT_PATH . "/models/UnlockingModel.php";
require_once SRC_ROOT_PATH . "/repositories/UnlockingRepository.php";

class UnlockingService extends BaseSrv {
  protected static $instance;
  private $client;
  
  private function __construct($client) {
    parent::__construct();
    $this->client = $client;
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        SocmedSoapClient::getInstance()
      );
    }
    return self::$instance;
  }

  public function getVerifiedUnlockingBySocmedId($socmedId) {
    $unlocksSQL = UnlockingRepository::getInstance()->getVerifiedUnlockingBySocmedId($socmedId);

    $unlocks = [];
    foreach ($unlocksSQL as $unlockSQL) {
      $unlock = new UnlockingModel();
      $unlocks[] = $unlock->constructFromArray($unlockSQL);
    }
    return $unlocks;
  }

  public function update($socmed_id, $dashboard_id, $link_code) {
    return UnlockingnRepository::getInstance()
            ->updateUnlocking($socmed_id, $dashboard_id, $link_code);
  }

  public function requestUnlocking($socmed_id, $link_code) {
    $resp = $this->client->requestUnlocking($socmed_id, $link_code);
    UnlockingRepository::getInstance()->insertUnlocking($socmed_id, null, $link_code);

    return $resp;
  }

  public function getSoapUnlocking() {
    return $this->client->getUnlocking();
  }

  public function getUnlocking() {
    $sqlRes = UnlockingRepository::getInstance()->getAllUnlockings();

    $unlocks = [];
    foreach ($sqlRes as $unlockSQL) {
      $unlock = new UnlockingModel();
      $unlocks[] = $unlock->constructFromArray($unlockSQL);
    }

    return $subs;
  }

  public function verifyUnlocking($socmed_id, $dashboard_id, $link_code) {
    return $this->client->verifyUnlocking($socmed_id, $dashboard_id, $link_code);
  }
}
