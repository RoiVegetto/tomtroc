<h1>Messagerie</h1>

<div class="messagerie-container">
  <div class="discussions">
    <h2>Discussions</h2>
    <?php if (empty($threads)): ?>
      <p>Aucun message reçu pour le moment.</p>
    <?php else: ?>
      <ul id="threads-list">
        <?php foreach ($threads as $t): ?>
          <li class="thread-item" data-conversation-id="<?= (int)$t['conversation_id'] ?>" style="margin-bottom:12px; cursor:pointer;">
            <strong><?= htmlspecialchars($t['other_username']) ?></strong>
            <?php if (!empty($t['last_body'])): ?>
              <div style="color:#666;">
                <?= htmlspecialchars(mb_strimwidth($t['last_body'], 0, 80, '...')) ?>
              </div>
            <?php endif; ?>
            <?php if ((int)$t['unread_count'] > 0): ?>
              <span>(<?= (int)$t['unread_count'] ?> non lu)</span>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <div class="conversation">
    <div id="conversation-content">
      <p>Sélectionnez une discussion pour voir les messages.</p>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const threads = document.querySelectorAll('.thread-item');
  const conversationContent = document.getElementById('conversation-content');
  const urlParams = new URLSearchParams(window.location.search);
  const convParam = urlParams.get('conv');

  // Charger la conversation du param ou la première
  let convToLoad = convParam;
  if (!convToLoad && threads.length > 0) {
    convToLoad = threads[0].dataset.conversationId;
  }

  if (convToLoad) {
    loadConversation(convToLoad);
  }

  threads.forEach(thread => {
    thread.addEventListener('click', function() {
      const convId = this.dataset.conversationId;
      loadConversation(convId);
      // Mettre à jour l'URL sans recharger
      history.pushState(null, '', `/tomtroc/public/messages?conv=${convId}`);
    });
  });

  function loadConversation(conversationId) {
    fetch(`/tomtroc/public/messages/getMessages/${conversationId}`)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          conversationContent.innerHTML = '<p>Erreur: ' + data.error + '</p>';
          return;
        }

        let html = `<h2>Discussion avec ${data.otherUser ? data.otherUser.username : 'Utilisateur'}</h2>`;

        if (data.messages.length === 0) {
          html += '<p>Aucun message.</p>';
        } else {
          html += '<div class="thread">';
          data.messages.forEach(m => {
            const isMe = m.sender_id == <?= json_encode($_SESSION['user_id']) ?>;
            html += `
              <div class="message ${isMe ? 'message--me' : 'message--other'}">
                <div class="message__meta">${m.created_at}</div>
                <div class="message__bubble">${m.body.replace(/\n/g, '<br>')}</div>
              </div>
            `;
          });
          html += '</div>';
        }

        html += `
          <hr>
          <form method="POST" action="/tomtroc/public/messages/thread/${conversationId}" class="message-form">
            <textarea name="body" rows="3" cols="60" placeholder="Tapez votre message ici..." required></textarea>
            <br><br>
            <button type="submit">Envoyer</button>
          </form>
        `;

        conversationContent.innerHTML = html;
      })
      .catch(error => {
        conversationContent.innerHTML = '<p>Erreur de chargement.</p>';
      });
  }
});
</script>

<style>
.messagerie-container {
  display: flex;
  gap: 20px;
}

.discussions {
  flex: 1;
  border-right: 1px solid #ccc;
  padding-right: 20px;
}

.conversation {
  flex: 2;
}

.thread-item:hover {
  background-color: #f0f0f0;
}

.thread {
  margin-bottom: 20px;
}

.message {
  margin-bottom: 10px;
}

.message--me {
  text-align: right;
}

.message--other {
  text-align: left;
}

.message__bubble {
  display: inline-block;
  padding: 10px;
  border-radius: 10px;
  max-width: 70%;
}

.message--me .message__bubble {
  background-color: #007bff;
  color: white;
}

.message--other .message__bubble {
  background-color: #f1f1f1;
}

.message__meta {
  font-size: 0.8em;
  color: #666;
  margin-bottom: 5px;
}
</style>
