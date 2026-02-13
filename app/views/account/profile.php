    <?php
    // Calcul de l'ancienneté (valeur par défaut si created_at n'existe pas)
    $memberSince = 'moins d\'un an';
    if (!empty($user['created_at'])) {
        $createdDate = new DateTime($user['created_at']);
        $now = new DateTime();
        $interval = $createdDate->diff($now);
        $years = $interval->y;
        if ($years > 0) {
            $memberSince = $years . ' an' . ($years > 1 ? 's' : '');
        }
    }
    $bookCount = count($books);
    ?>
    
    <div class="account-page">
        <div class="account-container">
            <h1 class="account-title">Mon compte</h1>

            <?php if (!empty($error)): ?>
              <p class="account-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="account-content">
                <!-- Section gauche : Info utilisateur -->
                <div class="account-sidebar">
                    <div class="profile-avatar-section">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="/tomtroc/public/<?= htmlspecialchars($user['avatar']) ?>" alt="Photo de profil" class="profile-avatar">
                        <?php else: ?>
                            <div class="profile-avatar-placeholder">
                                <i class="fa-regular fa-user"></i>
                            </div>
                        <?php endif; ?>
                        <button type="button" class="btn-modify-avatar" onclick="document.getElementById('avatar-input').click()">modifier</button>
                    </div>

                    <div class="profile-divider"></div>

                    <div class="profile-info">
                        <p class="profile-username"><?= htmlspecialchars($user['username']) ?></p>
                        <p class="profile-member-since">Membre depuis <?= $memberSince ?></p>
                        <p class="profile-library-title">BIBLIOTHÈQUE</p>
                        <p class="profile-book-count">
                            <img src="/tomtroc/public/images/books.svg" alt="Livres" class="profile-book-icon">
                            <span><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></span>
                        </p>
                    </div>
                </div>

                <!-- Section droite : Formulaire -->
                <div class="account-form-section">
                    <h2 class="form-section-title">Vos informations personnelles</h2>

                    <form method="POST" action="/tomtroc/public/account/profile" enctype="multipart/form-data" class="account-form">
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;" onchange="this.form.submit()">
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" placeholder="Laisser vide pour ne pas changer" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="username" class="form-label">Pseudo</label>
                            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="form-input" required>
                        </div>

                        <button type="submit" class="btn-save">Enregistrer</button>
                    </form>
                </div>
            </div>

            <!-- Section bas : Tableau des livres -->
            <div class="account-books-section">
                <?php if (!empty($books)): ?>
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>PHOTO</th>
                                <th>TITRE</th>
                                <th>AUTEUR</th>
                                <th>DESCRIPTION</th>
                                <th>DISPONIBILITÉ</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td class="book-photo-cell">
                                        <?php if (!empty($book['photo'])): ?>
                                            <img src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-thumbnail">
                                        <?php else: ?>
                                            <div class="book-thumbnail-placeholder"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="book-title-cell"><?= htmlspecialchars($book['title']) ?></td>
                                    <td class="book-author-cell"><?= htmlspecialchars($book['author']) ?></td>
                                    <td class="book-description-cell"><?= htmlspecialchars(mb_substr($book['description'], 0, 100)) ?><?= mb_strlen($book['description']) > 100 ? '...' : '' ?></td>
                                    <td class="book-availability-cell">
                                        <span class="availability-badge <?= (int)$book['is_available'] === 1 ? 'available' : 'unavailable' ?>">
                                            <?= (int)$book['is_available'] === 1 ? 'Disponible' : 'Non dispo' ?>
                                        </span>
                                    </td>
                                    <td class="book-actions-cell">
                                        <a href="/tomtroc/public/books/edit/<?= $book['id'] ?>" class="btn-action-edit">Éditer</a>
                                        <form method="POST" action="/tomtroc/public/books/delete/<?= $book['id'] ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                            <button type="submit" class="btn-action-delete">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-books-message">Vous n'avez aucun livre dans votre bibliothèque.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
