<h1><?= htmlspecialchars($book['title']) ?></h1>

<p><strong>Auteur :</strong> <?= htmlspecialchars($book['author']) ?></p>

<?php if (!empty($book['photo'])): ?>
  <img
    src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>"
    alt="<?= htmlspecialchars($book['title']) ?>"
    style="max-width:400px; width:100%; height:auto;"
  >
<?php endif; ?>

<?php if (!empty($book['description'])): ?>
  <h3>Description</h3>
  <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
<?php endif; ?>

<hr>

<hr>

<p><strong>Propriétaire :</strong> <?= htmlspecialchars($book['owner_username'] ?? 'Utilisateur') ?></p>

<?php if (empty($_SESSION['user_id'])): ?>
  <p>
    <a href="/tomtroc/public/auth/login">Connectez-vous</a> pour envoyer un message.
  </p>

<?php else: ?>
  <?php if ((int)$book['user_id'] === (int)$_SESSION['user_id']): ?>
    <p><em>C’est votre livre, vous ne pouvez pas vous envoyer de message.</em></p>
  <?php else: ?>
    <a href="/tomtroc/public/messages/new/<?= (int)$book['user_id'] ?>">
      Envoyer un message
    </a>
  <?php endif; ?>
<?php endif; ?>
