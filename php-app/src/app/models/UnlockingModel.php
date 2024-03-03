<?php

require_once SRC_ROOT_PATH . "/baseclasses/BaseModel.php";

class UnlockingModel extends BaseModel
{
  public $socmed_id;
  public $dashboard_id;
  public $link_code;

  public function __construct()
  {
    $this->_primary_key = ["socmed_id"];
    return $this;
  }

  public function constructFromArray($array)
  {
    $this->socmed_id = $array["socmed_id"];
    $this->dashboard_id = $array["dashboard_id"];
    $this->link_code = ($array["link_code"]);
    return $this;
  }

  public function toResponse()
  {
    return array(
      "socmed_id" => $this->socmed_id,
      "dashboard_id" => $this->dashboard_id,
      "link_code" => $this->link_code,
    );
  }
}
