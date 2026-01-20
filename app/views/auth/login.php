    <div class="container">
        <h1>Connexion</h1>

        <?php if (!empty($error)): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="/tomtroc/public/auth/login">
          <input name="username" placeholder="Pseudo" required><br><br>
          <input name="password" type="password" placeholder="Mot de passe" required><br><br>
          <button type="submit">Se connecter</button>
        </form>

        <p><a href="/tomtroc/public/auth/register">Créer un compte</a></p>
    </div>
