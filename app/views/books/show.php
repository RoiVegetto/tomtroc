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

<p><strong>Statut :</strong> <?= ((int)$book['is_available'] === 1) ? 'Disponible à l’échange' : 'Indisponible' ?></p>

<hr>

<hr>

<p><strong>Propriétaire :</strong> <a href="/tomtroc/public/account/userProfile/<?= (int)$book['user_id'] ?>"><?= htmlspecialchars($book['owner_username'] ?? 'Utilisateur') ?></a></p>

<?php if (empty($_SESSION['user_id'])): ?>
  <p>
    <a href="/tomtroc/public/auth/login">Connectez-vous</a> pour envoyer un message.
  </p>

<?php else: ?>
  <?php if ((int)$book['user_id'] === (int)$_SESSION['user_id']): ?>
    <p><em>C’est votre livre.</em></p>
    <a href="/tomtroc/public/books/edit/<?= (int)$book['id'] ?>">Modifier ce livre</a>
  <?php else: ?>
    <a href="/tomtroc/public/messages/new/<?= (int)$book['user_id'] ?>">
      Envoyer un message
    </a>
  <?php endif; ?>
<?php endif; ?>
