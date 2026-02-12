<?php include __DIR__ . '/../layouts/header.php'; ?>
<h1>Échanges</h1>
<h2>Reçues</h2>
<?php foreach ($received as $r): ?>
  <div style="border:1px solid #ddd;padding:8px;margin-bottom:8px;">
    <strong><?= htmlspecialchars($r['offered_title']) ?></strong> propose <em><?= htmlspecialchars($r['target_title']) ?></em>
    <p>Status: <?= htmlspecialchars($r['status']) ?></p>
    <?php if ($r['status'] === 'pending'): ?>
      <form method="post" action="/echanges/<?= (int)$r['id'] ?>/accepter" style="display:inline-block;margin-right:8px;"><button>Accepter</button></form>
      <form method="post" action="/echanges/<?= (int)$r['id'] ?>/refuser" style="display:inline-block;"><button>Refuser</button></form>
    <?php endif; ?>
    <div style="clear:both;"></div>
  </div>
<?php endforeach; ?>

<h2>Envoyées</h2>
<?php foreach ($sent as $s): ?>
  <div style="border:1px solid #ddd;padding:8px;margin-bottom:8px;">
    <strong><?= htmlspecialchars($s['offered_title']) ?></strong> -> <em><?= htmlspecialchars($s['target_title']) ?></em>
    <p>Status: <?= htmlspecialchars($s['status']) ?></p>
    <div style="clear:both;"></div>
  </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>