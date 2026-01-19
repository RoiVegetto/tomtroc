<h1>Nos livres à l’échange</h1>

<?php if (empty($books)): ?>
  <p>Aucun livre disponible pour le moment.</p>
<?php else: ?>
  <div class="books-grid">
    <?php foreach ($books as $book): ?>
      <a class="book-card" href="/tomtroc/public/books/show/<?= (int)$book['id'] ?>">
        <div class="book-cover">
          <?php if (!empty($book['photo'])): ?>
            <img
              src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>"
              alt="<?= htmlspecialchars($book['title']) ?>"
              loading="lazy"
            >
          <?php else: ?>
            <div class="book-cover-placeholder"></div>
          <?php endif; ?>
        </div>

        <div class="book-info">
          <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
          <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
          <p class="book-seller">Vendu par : <?= htmlspecialchars($book['owner_username']) ?></p>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
