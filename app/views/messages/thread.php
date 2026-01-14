<h1>
  Discussion avec
  <strong><?= htmlspecialchars($otherUser['username'] ?? 'Utilisateur') ?></strong>
</h1>

<?php if (!empty($error)): ?>
  <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (empty($messages)): ?>
  <p>Aucun message.</p>
<?php else: ?>
  <div>
    <?php
      $prevSender = null;
      $meId = (int)($_SESSION['user_id'] ?? 0);
      $otherName = $otherUser['username'] ?? 'Utilisateur';
    ?>

    <?php foreach ($messages as $m): ?>
      <?php
        $senderId = (int)$m['sender_id'];
        $isMe = ($senderId === $meId);

        // Affiche un "label" seulement quand l'expéditeur change
        if ($prevSender === null || $prevSender !== $senderId):
      ?>
          <div style="margin-top:18px; font-weight:bold;">
            <?= $isMe ? 'Vous' : htmlspecialchars($otherName) ?>
          </div>
      <?php endif; ?>

      <div style="margin:6px 0; padding:10px; border:1px solid #eee;">
        <div style="font-size:12px; color:#666;">
          <?= htmlspecialchars($m['created_at']) ?>
        </div>
        <div><?= nl2br(htmlspecialchars($m['body'])) ?></div>
      </div>

      <?php $prevSender = $senderId; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<hr>

<form method="POST" action="/tomtroc/public/messages/thread/<?= (int)$conversationId ?>">
  <textarea name="body" rows="4" cols="60" placeholder="Répondre..." required></textarea>
  <br><br>
  <button type="submit">Envoyer</button>
</form>

<p><a href="/tomtroc/public/messages">Retour messagerie</a></p>
