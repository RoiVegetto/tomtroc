    <div class="container">
        <h1>Inscription</h1>

        <?php if (!empty($error)): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
          <input name="username" placeholder="Pseudo" required><br><br>
          <input name="email" type="email" placeholder="Email" required><br><br>
          <input name="password" type="password" placeholder="Mot de passe" required><br><br>
          <button type="submit">S'inscrire</button>
        </form>

        <p><a href="/tomtroc/public/auth/login">Déjà inscrit ? Connexion</a></p>
    </div>
