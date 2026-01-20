    <div class="container">
        <h1>Modifier le livre</h1>

        <?php if (!empty($error)): ?>
          <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="/tomtroc/public/books/edit/<?= (int)$book['id'] ?>" enctype="multipart/form-data">
          <label>Titre</label><br>
          <input type="text" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" required>
          <br><br>

          <label>Auteur</label><br>
          <input type="text" name="author" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required>
          <br><br>

          <label>Description</label><br>
          <textarea name="description" rows="5"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
          <br><br>

          <label>Statut</label><br>
          <select name="is_available">
            <option value="1" <?= ((int)($book['is_available'] ?? 0)) === 1 ? 'selected' : '' ?>>Disponible à l'échange</option>
            <option value="0" <?= ((int)($book['is_available'] ?? 0)) === 0 ? 'selected' : '' ?>>Indisponible</option>
          </select>
          <br><br>

          <label>Photo</label><br>
          <?php if (!empty($book['photo'])): ?>
            <img src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>" alt="photo actuelle" width="100">
            <br>
          <?php endif; ?>
          <input type="file" name="photo" accept="image/*">
          <br><br>

          <button type="submit">Enregistrer les modifications</button>
        </form>

        <a href="/tomtroc/public/books/show/<?= (int)$book['id'] ?>">Annuler</a>
    </div>