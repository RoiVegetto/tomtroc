    <div class="container">
        <h1>Profil de <?= htmlspecialchars($user['username'] ?? 'Utilisateur') ?></h1>

        <?php if (!empty($error)): ?>
          <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="user-info">
          <label>Adresse email</label><br>
          <p><?= htmlspecialchars($user['email'] ?? '') ?></p>
          <br>

          <label>Pseudo</label><br>
          <p><?= htmlspecialchars($user['username'] ?? '') ?></p>
          <br>

          <?php if (!empty($user['avatar'])): ?>
            <label>Photo de profil</label><br>
            <img src="/tomtroc/public/<?= htmlspecialchars($user['avatar']) ?>" alt="avatar" width="100">
            <br><br>
          <?php endif; ?>
        </div>

        <hr class="separator">

        <section class="library">
          <h2>Bibliothèque de <?= htmlspecialchars($user['username'] ?? 'Utilisateur') ?></h2>

        <?php if (empty($books)): ?>
            <p class="empty-library">
                Cet utilisateur n'a aucun livre dans sa bibliothèque.
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
                        <p>Auteur: <?= htmlspecialchars($book['author']) ?></p>
                        <p>Description: <?= htmlspecialchars($book['description']) ?></p>
                        <p>
                            Statut :
                            <strong>
                                <?= ((int)$book['is_available'] === 1)
                                    ? "Disponible à l'échange"
                                    : 'Indisponible'; ?>
                            </strong>
                        </p>
                        <a href="/tomtroc/public/books/show/<?= $book['id'] ?>" class="btn">Voir le livre</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </section>
    </div>