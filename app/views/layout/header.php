<nav>
  <a href="/tomtroc/public/">Accueil</a>

  <?php if (!empty($_SESSION['user_id'])): ?>
    <span>Bonjour <?= htmlspecialchars($_SESSION['username']) ?></span>
    <a href="/tomtroc/public/account/profile">Mon compte</a>
    <a href="/tomtroc/public/auth/logout">Logout</a>
  <?php else: ?>
    <a href="/tomtroc/public/auth/login">Connexion</a>
    <a href="/tomtroc/public/auth/register">Inscription</a>
  <?php endif; ?>
</nav>
