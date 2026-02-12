<?php include __DIR__ . '/../layouts/header.php'; ?>
<h1><?= htmlspecialchars($object['title']) ?></h1>
<div style="display:flex;gap:20px;">
  <div style="flex:1;">
  </div>
  <div style="width:320px;">
    <h3>Détails</h3>
    <p><?= nl2br(htmlspecialchars($object['description'] ?? '')) ?></p>

    <?php if ($myId && $object['id_user'] !== $myId): ?>
      <h4>Proposer un échange</h4>
      <form method="post" action="/echanges/proposer">
        <input type="hidden" name="target_object_id" value="<?= (int)$object['id_object'] ?>">
        <label>Choisir un de vos objets:</label>
        <select name="offered_object_id">
          <?php
            $db = \Flight::db();
            $myId = (int)$myId;
            $sql = "SELECT id_object, title FROM objects WHERE id_user = $myId";
            $res = mysqli_query($db, $sql);
            while ($r = mysqli_fetch_assoc($res)):
          ?>
            <option value="<?= (int)$r['id_object'] ?>"><?= htmlspecialchars($r['title']) ?></option>
          <?php endwhile; ?>
        </select>
        <div style="margin-top:8px;"><button>Envoyer proposition</button></div>
      </form>
    <?php elseif (!$myId): ?>
      <p><a href="/login">Connecte-toi pour proposer un échange</a></p>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>