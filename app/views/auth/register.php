    <div class="auth-container">
        <div class="auth-form-section">
            <div class="auth-form-content">
                <h1 class="auth-title">Inscription</h1>

                <?php if (!empty($error)): ?>
                  <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                  <input type="text" name="username" placeholder="Pseudo" class="auth-input" required>
                  <input type="email" name="email" placeholder="Email" class="auth-input" required>
                  <input type="password" name="password" placeholder="Mot de passe" class="auth-input" required>
                  <button type="submit" class="auth-button">S'inscrire</button>
                </form>

                <p class="auth-link">Déjà inscrit ? <a href="/tomtroc/public/auth/login">Connectez-vous</a></p>
            </div>
        </div>
        <div class="auth-image-section">
            <img src="/tomtroc/public/images/bibliotheque.jpg" alt="Bibliothèque">
        </div>
    </div>
