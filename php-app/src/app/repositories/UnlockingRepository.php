<?php

require_once SRC_ROOT_PATH . "/baseclasses/BaseRepository.php";

class UnlockingRepository extends BaseRepository{
  protected static $instance;

  private function __construct() {
    parent::__construct();
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function getAllUnlockings() {
    $sql = "SELECT * FROM unlocking";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getUnlocking($socmed_id, $dashboard_id) {
    $sql = "SELECT * FROM unlocking WHERE socmed_id = :socmed_id AND dashboard_id = :dashboard_id";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':socmed_id', $socmed_id, PDO::PARAM_INT);
    $stmt->bindParam(':dashboard_id', $dashboard_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getVerifiedUnlockingBySocmedID($socmed_id) {
    $sql = "SELECT * FROM unlocking WHERE socmed_id = :socmed_id and dashboard_id IS NOT NULL";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':socmed_id', $socmed_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function insertUnlocking($socmed_id, $dashboard_id, $link_code) {
    $sql = "INSERT INTO unlocking (socmed_id, dashboard_id, link_code) VALUES (:socmed_id, :subscriber_id, :link_code)";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':socmed_id', $socmed_id, PDO::PARAM_INT);
    $stmt->bindParam(':dashboard_id', $dashboard_id, PDO::PARAM_INT);
    $stmt->bindParam(':link_code', $link_code, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->rowCount();
  }
}

