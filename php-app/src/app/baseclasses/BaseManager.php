<?php

require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

abstract class BaseManager
{
  protected static $instance;
  protected $pdo;
  protected $tableName = '';

  protected function __construct()
  {
    $this->pdo = PDOHandler::getInstance()->getPDO();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public static function arrToSQLArr($array)
  {
    return "{" . implode(",", $array) . "}";
  }

  public function getPDO()
  {
    return $this->pdo;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM $this->tableName";
    return $this->pdo->query($sql);
  }

  public function countRow($where = []) {
    $sql = "SELECT COUNT(*) AS count FROM $this->tableName";

    if (count($where) > 0) {
      $sql .= " WHERE ";
      $sql .= implode(" AND ", array_map(function ($key, $value) {
        if ($value[2] == 'LIKE') {
          return "$key LIKE :$key";
        }

        return "$key = :$key";
      }, array_keys($where), array_values($where)));
    }
    $stmt = $this->pdo->prepare($sql);
    foreach ($where as $key => $value) {
      $stmt->bindValue(":$key", $value[0], $value[1]);
      if ($value[2] == 'LIKE') {
        $stmt->bindValue(":$key", "%$value[0]%", $value[1]);
      } else {
        $stmt->bindValue(":$key", $value[0], $value[1]);
      }
    }

    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function findAll(
    $where = [], // where[$attribute] = $condition = [$operator, $value, $type]
    $orderCategory = null,
    $pageNo = null,
    $pageSize = null,
    $isDesc = false,
  ) {
    $sql = "SELECT * FROM $this->tableName ";

    if (count($where) > 0) {
      $sql .= "WHERE ";
      $sql .= implode(" AND ", array_map(function ($attribute, $condition) {
        $operator = $condition[0];
        return "$attribute $operator :$attribute";
      }, array_keys($where), array_values($where)));
    }

    if ($orderCategory) {
      $sql .= " ORDER BY $orderCategory";
    }

    if ($isDesc) {
      $sql .= " DESC";
    }

    if ($pageSize && $pageNo) {
      $sql .= " LIMIT :pageSize";
      $sql .= " OFFSET :offset";
    }

    // Start preparing statement for execute(), prevent SQL Injection using bindValue()
    $stmt = $this->pdo->prepare($sql);

    foreach ($where as $attribute => $condition) {
      if ($condition[0] == 'LIKE') {
        $stmt->bindValue(":$attribute", "%$condition[1]%", $condition[2]);
      } else {
        $stmt->bindValue(":$attribute", $condition[1], $condition[2]);
      }
    }

    if ($pageSize && $pageNo) {
      $offset = ($pageNo - 1) * $pageSize;

      $stmt->bindValue(":pageSize", $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function findOne($where) // where[$attribute] = $condition = [$operator, $value, $type]
  {$sql = "SELECT * FROM $this->tableName ";

    if (count($where) > 0) {
      $sql .= "WHERE ";
      $sql .= implode(" AND ", array_map(function ($attribute, $condition) {
        $operator = $condition[0];
        return "$attribute $operator :$attribute";
      }, array_keys($where), array_values($where)));
    }

    // Start preparing statement for execute(), prevent SQL Injection using bindValue()
    $stmt = $this->pdo->prepare($sql);

    foreach ($where as $attribute => $condition) {
      if ($condition[0] == 'LIKE') {
        $stmt->bindValue(":$attribute", "%$condition[1]%", $condition[2]);
      } else {
        $stmt->bindValue(":$attribute", $condition[1], $condition[2]);
      }
    }

    $stmt->execute();
    return $stmt->fetch();
  }

  public function insert($model, $attributes, $retIDName = null) // attributes[$attribute] = $type
  {
    $sql = "INSERT INTO $this->tableName (";

    $sql .= implode(", ", array_keys($attributes));

    $sql .= ") VALUES (";
    
    $sql .= implode(", ", array_map(function ($attribute) {
      return ":$attribute";
    }, array_keys($attributes)));

    $sql .= ")";

    if(!is_null($retIDName)) $sql .= "RETURNING $retIDName";

    // Start preparing statement for execute(), prevent SQL Injection using bindValue()
    $stmt = $this->pdo->prepare($sql);

    foreach ($attributes as $attribute => $type) {
      $stmt->bindValue(":$attribute", $model->get($attribute), $type);
    }

    $stmt->execute();

    if(!is_null($retIDName)) return $stmt->fetch();
    return null;
  }

  public function update($model, $attributes) // attributes[$attribute] = $type
  {
    $sql = "UPDATE $this->tableName SET ";
    
    $sql .= implode(", ", array_map(function ($attribute) {
      return "$attribute = :$attribute";
    }, array_keys($attributes)));

    $sql .= " WHERE ";

    $primaryKey = $model->get('_primary_key');
    if (is_array($primaryKey)) {
      $sql .= implode(", ", array_map(function ($keyAttribute) {
        return "$keyAttribute = :key_$keyAttribute";
      }, $primaryKey));
    }
    else {
      $sql .= "$primaryKey = :key_$primaryKey";
    }

    // Start preparing statement for execute(), prevent SQL Injection using bindValue()
    $stmt = $this->pdo->prepare($sql);

    foreach ($attributes as $attribute => $type) {
      $stmt->bindValue(":$attribute", $model->get($attribute), $type);
    }

    if (is_array($primaryKey)) {
      foreach ($primaryKey as $keyAttribute) {
        $stmt->bindValue(":key_$keyAttribute", $model->get($keyAttribute), PDO::PARAM_INT);
      }
    }
    else {
      $stmt->bindValue(":key_$primaryKey", $model->get($primaryKey), PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function delete($model)
  {
    $sql = "DELETE FROM $this->tableName WHERE ";

    $primaryKey = $model->get('_primary_key');
    if (is_array($primaryKey)) {
      $sql .= implode(", ", array_map(function ($keyAttribute) {
        return "$keyAttribute = :key_$keyAttribute";
      }, $primaryKey));
    }
    else {
      $sql .= "$primaryKey = :key_$primaryKey";
    }

    // Start preparing statement for execute(), prevent SQL Injection using bindValue()
    $stmt = $this->pdo->prepare($sql);
    
    if (is_array($primaryKey)) {
      foreach ($primaryKey as $keyAttribute) {
        $stmt->bindValue(":key_$keyAttribute", $model->get($keyAttribute), PDO::PARAM_INT);
      }
    }
    else {
      $stmt->bindValue(":key_$primaryKey", $model->get($primaryKey), PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function getNLastRow($N)
  {
    $sql = "SELECT COUNT(*) FROM $this->tableName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count < $N) {
      $N = $count;
    }

    $offset = $count - $N;
    $sql = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":limit", $N, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
