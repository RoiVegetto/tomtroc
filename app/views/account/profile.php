<h1>Vos informations personnelles</h1>

<?php if (!empty($error)): ?>
  <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="/tomtroc/public/account/profile">
  <label>Adresse email</label><br>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
  <br><br>

  <label>Mot de passe</label><br>
  <input type="password" name="password" placeholder="Laisser vide pour ne pas changer">
  <br><br>

  <label>Pseudo</label><br>
  <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
  <br><br>

  <button type="submit">Enregistrer</button>
</form>
