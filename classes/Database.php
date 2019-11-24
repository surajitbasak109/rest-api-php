<?php

class DB
{
  private static function connect()
  {
    $pdo = new PDO('mysql:host=localhost;dbname=php_rest_api', 'root', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  }

  public static function query($query, $params = [])
  {
    $stmt = self::connect()->prepare($query);
    $stmt->execute($params);
    if (explode(' ', $query)[0] == 'SELECT') {
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $data;
    }
  }
}
