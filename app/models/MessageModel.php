<?php

namespace app\models;

class MessageModel
{
  public static function getInbox(int $receiverId): array
  {
    $db = \Flight::db();
    $receiverId = (int) $receiverId;

    $sql = "
      SELECT m.id, m.sender_id, m.receiver_id, m.content, m.is_read, m.created_at,
             u.username AS sender_name
      FROM messages m
      JOIN users u ON u.id = m.sender_id
      WHERE m.receiver_id = $receiverId
      ORDER BY m.created_at DESC
    ";

    $res = mysqli_query($db, $sql);
    $rows = [];

    if ($res) {
      while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
      }
    }
    return $rows;
  }

  public static function countUnread(int $receiverId): int
  {
    $db = \Flight::db();
    $receiverId = (int) $receiverId;

    $sql = "SELECT COUNT(*) AS c FROM messages WHERE receiver_id = $receiverId AND is_read = 0";
    $res = mysqli_query($db, $sql);

    if ($res) {
      $row = mysqli_fetch_assoc($res);
      return (int) ($row['c'] ?? 0);
    }
    return 0;
  }

  public static function send(int $senderId, int $receiverId, string $content): void
  {
    $db = \Flight::db();
    $senderId = (int) $senderId;
    $receiverId = (int) $receiverId;

    $contentEsc = mysqli_real_escape_string($db, $content);

    $sql = "
      INSERT INTO messages (sender_id, receiver_id, content, is_read)
      VALUES ($senderId, $receiverId, '$contentEsc', 0)
    ";
    mysqli_query($db, $sql);
  }

  public static function getOneForReceiver(int $messageId, int $receiverId): ?array
  {
    $db = \Flight::db();
    $messageId = (int) $messageId;
    $receiverId = (int) $receiverId;

    $sql = "
      SELECT m.*, u.username AS sender_name
      FROM messages m
      JOIN users u ON u.id = m.sender_id
      WHERE m.id = $messageId AND m.receiver_id = $receiverId
      LIMIT 1
    ";
    $res = mysqli_query($db, $sql);

    if ($res) {
      $row = mysqli_fetch_assoc($res);
      return $row ?: null;
    }
    return null;
  }

  public static function markRead(int $messageId, int $receiverId): void
  {
    $db = \Flight::db();
    $messageId = (int) $messageId;
    $receiverId = (int) $receiverId;

    $sql = "UPDATE messages SET is_read = 1 WHERE id = $messageId AND receiver_id = $receiverId";
    mysqli_query($db, $sql);
  }
}
