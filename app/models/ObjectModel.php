<?php

namespace app\models;

class ObjectModel
{
    public static function getOthers(int $myId): array
    {
        $db = \Flight::db();
        $myId = (int) $myId;

        $sql = "SELECT id_object, id_user, title, description FROM objects WHERE id_user <> $myId ORDER BY title";
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

        $sql = "SELECT id_object, id_user, title, description FROM objects WHERE id_object = $id LIMIT 1";
        $res = mysqli_query($db, $sql);
        if ($res) {
            $row = mysqli_fetch_assoc($res);
            if ($row) {
                return $row;
            }
        }
        return null;
    }
}
