<h1 class="page-title">Vos informations personnelles</h1>

<?php if (!empty($error)): ?>
  <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="/tomtroc/public/account/profile" class="form form-profile">
  <div class="form-group">
    <label for="email">Adresse email</label>
    <input id="email" type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
  </div>

  <div class="form-group">
    <label for="password">Mot de passe</label>
    <input id="password" type="password" name="password" placeholder="Laisser vide pour ne pas changer">
  </div>

  <div class="form-group">
    <label for="username">Pseudo</label>
    <input id="username" type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
  </div>

  <button type="submit" class="btn btn-primary">Enregistrer</button>
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
