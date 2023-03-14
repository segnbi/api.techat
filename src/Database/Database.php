<?php

namespace Api\Database;

use PDO;
use PDOException;

class Database
{
  private const HOST = 'localhost';
  private const DB_NAME = 'forum_tech_db';
  private const USER = 'root';
  private const PASSWORD = 'root';

  public static function connect(): PDO
  {
    try {
      $pdo = new PDO(
        'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME,
        self::USER,
        self::PASSWORD,
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
      );
    } catch (PDOException $e) {
      die(json_encode(['Error' => $e->getMessage()]));
    }

    return $pdo;
  }
}
