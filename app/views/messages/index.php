<h1>Messagerie - Messages reçus</h1>

<?php if (empty($threads)): ?>
  <p>Aucun message reçu pour le moment.</p>
<?php else: ?>
  <ul>
    <?php foreach ($threads as $t): ?>
      <li style="margin-bottom:12px;">
        <a href="/tomtroc/public/messages/thread/<?= (int)$t['conversation_id'] ?>">
          Discussion avec <strong><?= htmlspecialchars($t['other_username']) ?></strong>
        </a>
        <?php if (!empty($t['last_body'])): ?>
          <div style="color:#666;">
            <?= htmlspecialchars(mb_strimwidth($t['last_body'], 0, 80, '...')) ?>
          </div>
        <?php endif; ?>

        <?php if ((int)$t['unread_count'] > 0): ?>
          <span>(<?= (int)$t['unread_count'] ?> non lu)</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
