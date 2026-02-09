    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-form-content">
                <h1 class="auth-title">Connexion</h1>

                <?php if (!empty($error)): ?>
                  <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form method="POST" action="/tomtroc/public/auth/login" class="auth-form">
                  <input type="email" name="email" placeholder="Adresse mail" class="auth-input" required>
                  <input type="password" name="password" placeholder="Mot de passe" class="auth-input" required>
                  <button type="submit" class="auth-button">Se connecter</button>
                </form>

                <p class="auth-link">Pas de compte ? <a href="/tomtroc/public/auth/register">Inscrivez-vous</a></p>
            </div>
        </div>
        <div class="auth-image-section">
            <img src="/tomtroc/public/images/bibliotheque.jpg" alt="Bibliothèque">
        </div>
    </div>
