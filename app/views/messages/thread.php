<h1>Fil de discussion</h1>

<?php if (!empty($otherUser)): ?>
  <p>Conversation avec : <strong><?= htmlspecialchars($otherUser['username'] ?? 'Utilisateur') ?></strong></p>
<?php endif; ?>

<?php if (empty($thread)): ?>
  <p>Aucun message dans ce fil pour le moment.</p>
<?php else: ?>
  <ul>
    <?php foreach ($thread as $msg): ?>
      <li>
        <strong><?= htmlspecialchars($msg['sender_username']) ?></strong> :
        <?= nl2br(htmlspecialchars($msg['content'])) ?>
        <em>(<?= htmlspecialchars($msg['created_at']) ?>)</em>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<hr>

<h2>Répondre</h2>
<form method="POST" action="/tomtroc/public/messages/sendPost">
  <input type="hidden" name="receiver_id" value="<?= (int)($otherUser['id'] ?? 0) ?>">
  <textarea name="content" rows="4" cols="50" required></textarea>
  <br><br>
  <button type="submit">Envoyer</button>
</form>

<p><a href="/tomtroc/public/messages">← Retour à la liste</a></p>
