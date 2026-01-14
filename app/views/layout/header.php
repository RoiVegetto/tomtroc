<?php
use App\Models\Message;

// Sécurité : initialisation par défaut
$unreadCount = 0;

// Si utilisateur connecté → on calcule les messages non lus
if (!empty($_SESSION['user_id'])) {
    $unreadCount = Message::countUnread((int)$_SESSION['user_id']);
}
?>

<nav>
  <a href="/tomtroc/public/">Accueil</a>

  <?php if (!empty($_SESSION['user_id'])): ?>
    <span>Bonjour <?= htmlspecialchars($_SESSION['username']) ?></span>

    <a href="/tomtroc/public/books/exchange">Nos livres à l’échange</a>

    <a href="/tomtroc/public/messages">
      Messagerie
      <?php if ($unreadCount > 0): ?>
        <span class="badge"><?= (int)$unreadCount ?></span>
      <?php endif; ?>
    </a>

    <a href="/tomtroc/public/account/profile">Mon compte</a>
    <a href="/tomtroc/public/auth/logout">Déconnexion</a>
  <?php else: ?>
    <a href="/tomtroc/public/auth/login">Connexion</a>
    <a href="/tomtroc/public/auth/register">Inscription</a>
  <?php endif; ?>
</nav>
