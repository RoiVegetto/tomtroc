    <div class="container">
        <div class="books-header">
            <h1>Nos livres à l'échange</h1>
            <form method="GET" action="/tomtroc/public/books/exchange" class="search-bar">
                <svg class="search-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="6.5" cy="6.5" r="5" stroke="#292929" stroke-width="1.5"/>
                    <path d="M10 10L14 14" stroke="#292929" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" placeholder="Rechercher un livre..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </form>
        </div>

        <?php if (empty($books)): ?>
          <p>Aucun livre disponible pour le moment.</p>
        <?php else: ?>
          <div class="books-grid" id="booksGrid">
            <?php foreach ($books as $book): ?>
              <a class="book-card" href="/tomtroc/public/books/show/<?= (int)$book['id'] ?>">
                <div class="book-cover">
                  <?php if (!$book['is_available']): ?>
                    <span class="book-tag-unavailable">non dispo.</span>
                  <?php endif; ?>
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
    </div>
