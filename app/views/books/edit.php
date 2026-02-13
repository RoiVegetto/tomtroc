    <div class="book-edit-page">
      <div class="book-edit-container">
        <a href="/tomtroc/public/books/show/<?= (int)$book['id'] ?>" class="book-edit-back">
          <i class="fa-solid fa-arrow-left"></i>
          <span>Retour</span>
        </a>

        <h1 class="book-edit-title">Modifier les informations</h1>

        <?php if (!empty($error)): ?>
          <p class="book-edit-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <div class="book-edit-card">
          <form class="book-edit-form" method="POST" action="/tomtroc/public/books/edit/<?= (int)$book['id'] ?>" enctype="multipart/form-data">
            <div class="book-edit-columns">
              <div class="book-edit-photo">
                <h2 class="book-edit-section-title">Photo</h2>
                <?php if (!empty($book['photo'])): ?>
                  <img src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>" alt="Photo du livre" class="book-edit-photo-image">
                <?php else: ?>
                  <div class="book-edit-photo-placeholder">
                    <i class="fa-solid fa-book"></i>
                  </div>
                <?php endif; ?>
                <input type="file" name="photo" id="book-photo-input" accept="image/*" class="book-edit-photo-input">
                <label for="book-photo-input" class="book-edit-photo-action">Modifier la photo</label>
              </div>

              <div class="book-edit-fields">
                <div class="book-edit-field">
                  <label for="title" class="book-edit-label">Titre</label>
                  <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" required class="book-edit-input">
                </div>

                <div class="book-edit-field">
                  <label for="author" class="book-edit-label">Auteur</label>
                  <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required class="book-edit-input">
                </div>

                <div class="book-edit-field">
                  <label for="description" class="book-edit-label">Commentaire</label>
                  <textarea id="description" name="description" rows="5" class="book-edit-textarea"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
                </div>

                <div class="book-edit-field">
                  <label for="is_available" class="book-edit-label">Disponibilite</label>
                  <select id="is_available" name="is_available" class="book-edit-select">
                    <option value="1" <?= ((int)($book['is_available'] ?? 0)) === 1 ? 'selected' : '' ?>>Disponible a l'echange</option>
                    <option value="0" <?= ((int)($book['is_available'] ?? 0)) === 0 ? 'selected' : '' ?>>Indisponible</option>
                  </select>
                </div>

                <button type="submit" class="book-edit-submit">Valider</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>