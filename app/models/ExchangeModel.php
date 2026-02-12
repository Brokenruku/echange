<?php

namespace app\models;

class ExchangeModel
{
    public static function create(int $proposerUserId, int $targetObjectId, int $offeredObjectId): bool
    {
        $db = \Flight::db();
        $p = (int) $proposerUserId;
        $t = (int) $targetObjectId;
        $o = (int) $offeredObjectId;

        // basic validations
        if ($p <= 0 || $t <= 0 || $o <= 0) {
            return false;
        }

        // ensure offered belongs to proposer
        $sql = "SELECT id_object, id_user FROM objects WHERE id_object = $o LIMIT 1";
        $res = mysqli_query($db, $sql);
        $row = $res ? mysqli_fetch_assoc($res) : null;
        if (!$row || (int)$row['id_user'] !== $p) {
            return false;
        }

        // ensure target not user's own
        $sql = "SELECT id_object, id_user FROM objects WHERE id_object = $t LIMIT 1";
        $res = mysqli_query($db, $sql);
        $row2 = $res ? mysqli_fetch_assoc($res) : null;
        if (!$row2 || (int)$row2['id_user'] === $p) {
            return false;
        }

        $p_esc = (int)$p;
        $sql = "INSERT INTO echanges (id_user_proposer, id_object_target, id_object_offered, status) VALUES ($p_esc, $t, $o, 'pending')";
        return (bool) mysqli_query($db, $sql);
    }

    public static function getReceived(int $myId): array
    {
        $db = \Flight::db();
        $myId = (int) $myId;

        $sql = "SELECT e.id, e.id_user_proposer, e.id_object_target, e.id_object_offered, e.status, o1.title AS target_title, o2.title AS offered_title
                FROM echanges e
                JOIN objects o1 ON o1.id_object = e.id_object_target
                JOIN objects o2 ON o2.id_object = e.id_object_offered
                WHERE o1.id_user = $myId";

        $res = mysqli_query($db, $sql);
        $rows = [];
        if ($res) {
            while ($r = mysqli_fetch_assoc($res)) {
                $rows[] = $r;
            }
        }
        return $rows;
    }

    public static function getSent(int $myId): array
    {
        $db = \Flight::db();
        $myId = (int) $myId;

        $sql = "SELECT e.id, e.id_user_proposer, e.id_object_target, e.id_object_offered, e.status, o1.title AS target_title, o2.title AS offered_title
                FROM echanges e
                JOIN objects o1 ON o1.id_object = e.id_object_target
                JOIN objects o2 ON o2.id_object = e.id_object_offered
                WHERE e.id_user_proposer = $myId";

        $res = mysqli_query($db, $sql);
        $rows = [];
        if ($res) {
            while ($r = mysqli_fetch_assoc($res)) {
                $rows[] = $r;
            }
        }
        return $rows;
    }

    public static function refuse(int $exchangeId, int $myId): bool
    {
        $db = \Flight::db();
        $exchangeId = (int) $exchangeId;
        $myId = (int) $myId;

        // ensure this exchange is pending and target belongs to myId
        $sql = "SELECT e.id, o.id_user AS target_owner FROM echanges e JOIN objects o ON o.id_object = e.id_object_target WHERE e.id = $exchangeId LIMIT 1";
        $res = mysqli_query($db, $sql);
        $row = $res ? mysqli_fetch_assoc($res) : null;
        if (!$row || (int)$row['target_owner'] !== $myId) {
            return false;
        }

        $sql = "UPDATE echanges SET status = 'refused' WHERE id = $exchangeId";
        return (bool) mysqli_query($db, $sql);
    }

    public static function accept(int $exchangeId, int $myId): bool
    {
        $db = \Flight::db();
        $exchangeId = (int) $exchangeId;
        $myId = (int) $myId;

        mysqli_begin_transaction($db);
        try {
            $sql = "SELECT * FROM echanges WHERE id = $exchangeId FOR UPDATE";
            $res = mysqli_query($db, $sql);
            $ex = $res ? mysqli_fetch_assoc($res) : null;
            if (!$ex || $ex['status'] !== 'pending') {
                mysqli_rollback($db);
                return false;
            }

            // check target owner
            $sql = "SELECT id_user FROM objects WHERE id_object = " . (int)$ex['id_object_target'] . " LIMIT 1";
            $r = mysqli_query($db, $sql);
            $t = $r ? mysqli_fetch_assoc($r) : null;
            if (!$t || (int)$t['id_user'] !== $myId) {
                mysqli_rollback($db);
                return false;
            }

            // check offered still belongs to proposer
            $sql = "SELECT id_user FROM objects WHERE id_object = " . (int)$ex['id_object_offered'] . " LIMIT 1";
            $r2 = mysqli_query($db, $sql);
            $o = $r2 ? mysqli_fetch_assoc($r2) : null;
            if (!$o || (int)$o['id_user'] !== (int)$ex['id_user_proposer']) {
                mysqli_rollback($db);
                return false;
            }

            // perform swap
            $targetObj = (int)$ex['id_object_target'];
            $offeredObj = (int)$ex['id_object_offered'];
            $proposerId = (int)$ex['id_user_proposer'];

            $sql = "UPDATE objects SET id_user = $proposerId WHERE id_object = $targetObj";
            if (!mysqli_query($db, $sql)) { mysqli_rollback($db); return false; }

            $sql = "UPDATE objects SET id_user = $myId WHERE id_object = $offeredObj";
            if (!mysqli_query($db, $sql)) { mysqli_rollback($db); return false; }

            $sql = "UPDATE echanges SET status = 'accepted' WHERE id = $exchangeId";
            if (!mysqli_query($db, $sql)) { mysqli_rollback($db); return false; }

            mysqli_commit($db);
            return true;
        } catch (\Throwable $e) {
            mysqli_rollback($db);
            return false;
        }
    }
}
