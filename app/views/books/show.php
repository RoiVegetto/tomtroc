<div class="book-show-page">
    <div class="book-show-breadcrumb">
        <p>Nos livres > <?= htmlspecialchars($book['title']) ?></p>
    </div>

    <div class="book-show-container">
        <!-- Colonne gauche : Image (50%) -->
        <div class="book-show-image-section">
            <?php if (!empty($book['photo'])): ?>
                <img
                    src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>"
                    alt="<?= htmlspecialchars($book['title']) ?>"
                    class="book-show-image"
                >
            <?php else: ?>
                <div class="book-show-image-placeholder">
                    <i class="fa-solid fa-book"></i>
                </div>
            <?php endif; ?>
        </div>

        <!-- Colonne droite : Informations (50%) -->
        <div class="book-show-info-section">
            <div class="book-show-info-content">
                <div class="book-show-header">
                    <h1 class="book-show-title"><?= htmlspecialchars($book['title']) ?></h1>
                    <p class="book-show-author">par <?= htmlspecialchars($book['author']) ?></p>
                    <div class="book-show-divider"></div>
                </div>
                
                <div class="book-show-middle">
                    <div class="book-show-block">
                        <h3 class="book-show-subtitle">DESCRIPTION</h3>
                        <p class="book-show-text">
                            <?php if (!empty($book['description'])): ?>
                                <?= nl2br(htmlspecialchars($book['description'])) ?>
                            <?php else: ?>
                                Aucune description disponible.
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="book-show-block">
                        <h3 class="book-show-subtitle">PROPRIÉTAIRE</h3>
                        <div class="book-show-owner">
                            <div class="book-show-owner-avatar">
                                <?php if (!empty($book['owner_avatar'])): ?>
                                    <img src="/tomtroc/public/<?= htmlspecialchars($book['owner_avatar']) ?>" alt="Avatar de <?= htmlspecialchars($book['owner_username'] ?? 'Utilisateur') ?>">
                                <?php else: ?>
                                    <i class="fa-regular fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <span class="book-show-owner-name">
                                <?= htmlspecialchars($book['owner_username'] ?? 'Utilisateur') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="book-show-actions">
                    <?php if (empty($_SESSION['user_id'])): ?>
                        <a href="/tomtroc/public/auth/login" class="book-show-btn">Envoyer un message</a>
                        <p class="book-show-notice">Connectez-vous pour envoyer un message</p>
                    <?php else: ?>
                        <?php if ((int)$book['user_id'] === (int)$_SESSION['user_id']): ?>
                            <p class="book-show-notice-owner">C'est votre livre.</p>
                            <a href="/tomtroc/public/books/edit/<?= (int)$book['id'] ?>" class="book-show-btn">Modifier ce livre</a>
                        <?php else: ?>
                            <a href="/tomtroc/public/messages/new/<?= (int)$book['user_id'] ?>" class="book-show-btn">Envoyer un message</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
