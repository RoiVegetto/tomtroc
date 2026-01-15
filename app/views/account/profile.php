<h1>Vos informations personnelles</h1>

<?php if (!empty($error)): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="/tomtroc/public/account/profile" enctype="multipart/form-data">
  <label>Adresse email</label><br>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
  <br><br>

  <label>Mot de passe</label><br>
  <input type="password" name="password" placeholder="Laisser vide pour ne pas changer">
  <br><br>

  <label>Pseudo</label><br>
  <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
  <br><br>

  <label>Photo de profil</label><br>
  <?php if (!empty($user['avatar'])): ?>
    <img src="/tomtroc/public/<?= htmlspecialchars($user['avatar']) ?>" alt="avatar" width="60">
    <br>
  <?php endif; ?>
  <input type="file" name="avatar" accept="image/*">
  <br><br>

  <button type="submit">Enregistrer</button>
</form>

<hr class="separator">

<section class="library">
  <h2>Ma bibliothèque</h2>

<?php if (empty($books)): ?>
    <p class="empty-library">
        Vous n’avez aucun livre dans votre bibliothèque.
    </p>
        <?php else: ?>
            <div class="books-list">
                <?php foreach ($books as $book): ?>
                    <div class="book-item">
                        <?php if (!empty($book['photo'])): ?>
                            <img
                                src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>"
                                alt="<?= htmlspecialchars($book['title']) ?>"
                                class="book-image"
                            >
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p><?= htmlspecialchars($book['author']) ?></p>

                        <p>
                            <?= nl2br(htmlspecialchars($book['description'])) ?>
                        </p>

                        <p>
                            Statut :
                            <strong>
                                <?= ((int)$book['is_available'] === 1)
                                    ? 'Disponible à l’échange'
                                    : 'Indisponible'; ?>
                            </strong>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
</section>
