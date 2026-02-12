<?php include __DIR__ . '/../layouts/header.php'; ?>
<h1>Objets disponibles</h1>
<div style="display:flex;flex-wrap:wrap;gap:12px;">
<?php foreach ($objects as $o): ?>
  <div style="border:1px solid #ddd;padding:8px;width:220px;">
    <h3><?= htmlspecialchars($o['title']) ?></h3>
    <p><?= htmlspecialchars(substr($o['description'] ?? '',0,80)) ?></p>
    <p><a href="/objects/<?= (int)$o['id_object'] ?>">Voir</a></p>
  </div>
<?php endforeach; ?>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>