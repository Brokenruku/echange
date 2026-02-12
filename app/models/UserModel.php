<?php

namespace app\models;

class UserModel
{
  public static function getAllExcept(int $excludedId): array
  {
    $db = \Flight::db();
    $excludedId = (int) $excludedId;

    $sql = "SELECT id, username FROM users WHERE id <> $excludedId ORDER BY username";
    $res = mysqli_query($db, $sql);

    $rows = [];
    if ($res) {
      while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
      }
    }
    return $rows;
  }

  public static function getById(int $id): ?array
  {
    $db = \Flight::db();
    $id = (int) $id;

    $sql = "SELECT id, username FROM users WHERE id = $id LIMIT 1";
    $res = mysqli_query($db, $sql);

    if ($res) {
      $row = mysqli_fetch_assoc($res);
      return $row ?: null;
    }
    return null;
  }
}
