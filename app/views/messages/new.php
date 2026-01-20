    <div class="container">
        <h1>Nouveau message</h1>

        <p>À : <strong><?= htmlspecialchars($receiver['username']) ?></strong></p>

        <?php if (!empty($error)): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="/tomtroc/public/messages/new/<?= (int)$receiver['id'] ?>">
          <textarea name="body" rows="6" cols="60" placeholder="Votre message..." required></textarea>
          <br><br>
          <button type="submit">Envoyer</button>
        </form>

        <p><a href="/tomtroc/public/messages">Retour messagerie</a></p>
    </div>
