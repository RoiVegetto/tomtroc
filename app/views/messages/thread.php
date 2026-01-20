    <div class="container">
        <?php
        $myId = (int)($_SESSION['user_id'] ?? 0);
        ?>

        <h1>
          <strong><?= htmlspecialchars($otherUser['username'] ?? 'Utilisateur') ?></strong>
        </h1>

        <?php if (!empty($error)): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (empty($messages)): ?>
          <p>Aucun message.</p>
        <?php else: ?>
          <div class="thread">
            <?php foreach ($messages as $m): ?>
              <?php $isMe = ((int)$m['sender_id'] === $myId); ?>

              <div class="message <?= $isMe ? 'message--me' : 'message--other' ?>">
                <div class="message__meta">
                  <?= htmlspecialchars($m['created_at']) ?>
                </div>
                <div class="message__bubble">
                  <?= nl2br(htmlspecialchars($m['body'])) ?>
                </div>
              </div>

            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <hr>

        <form method="POST" action="/tomtroc/public/messages/thread/<?= (int)$conversationId ?>" class="message-form">
          <textarea name="body" rows="3" cols="60" placeholder="Tapez votre message ici..." required></textarea>
          <br><br>
          <button type="submit">Envoyer</button>
        </form>

        <p><a href="/tomtroc/public/messages">Retour messagerie</a></p>
    </div>
