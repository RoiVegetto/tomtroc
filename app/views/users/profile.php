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

<div class="user-profile-page">
    <div class="user-profile-container">
        <div class="user-profile-content">
            <!-- Section gauche : Info utilisateur -->
            <div class="user-profile-sidebar">
                <div class="user-avatar-section">
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="/tomtroc/public/<?= htmlspecialchars($user['avatar']) ?>" alt="Photo de profil" class="user-avatar">
                    <?php else: ?>
                        <div class="user-avatar-placeholder">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="user-divider"></div>

                <div class="user-info">
                    <p class="user-username"><?= htmlspecialchars($user['username']) ?></p>
                    <p class="user-member-since">Membre depuis <?= $memberSince ?></p>
                    <p class="user-library-title">BIBLIOTHÈQUE</p>
                    <p class="user-book-count"><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></p>
                </div>

                <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] != $user['id']): ?>
                    <a href="/tomtroc/public/messages/new?user_id=<?= $user['id'] ?>" class="btn-send-message">Écrire un message</a>
                <?php endif; ?>
            </div>

            <!-- Section droite : Tableau des livres -->
            <div class="user-books-section">
                <?php if (!empty($books)): ?>
                    <table class="user-books-table">
                        <thead>
                            <tr>
                                <th>PHOTO</th>
                                <th>TITRE</th>
                                <th>AUTEUR</th>
                                <th>DESCRIPTION</th>
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
                                    <td class="book-description-cell"><?= htmlspecialchars($book['description']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-books-message">Cet utilisateur n'a aucun livre dans sa bibliothèque.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
