<h1>Messagerie - Messages reçus</h1>

<?php if (empty($messages)): ?>
  <p>Aucun message reçu pour le moment.</p>
<?php else: ?>
  <ul>
    <?php foreach ($messages as $m): ?>
      <li>
        <strong><?= htmlspecialchars($m['sender_username']) ?></strong>
        — <?= htmlspecialchars($m['content']) ?>
        <em>(<?= htmlspecialchars($m['created_at']) ?>)</em>

        <?php if ((int)$m['is_read'] === 0): ?>
          <strong>[non lu]</strong>
        <?php endif; ?>

        — <a href="/tomtroc/public/messages/thread/<?= (int)$m['sender_id'] ?>">Voir le fil</a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
