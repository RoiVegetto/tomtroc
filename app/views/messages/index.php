<div class="messagerie-page">
    <div class="messagerie-container">
        <h1 class="messagerie-title">Messagerie</h1>

        <div class="messagerie-content">
            <!-- Colonne gauche : Liste des discussions -->
            <div class="messagerie-sidebar">
                <h2 class="messagerie-sidebar-title">Messagerie</h2>
                <?php if (empty($threads)): ?>
                    <p class="messagerie-empty">Aucun message reçu pour le moment.</p>
                <?php else: ?>
                    <ul class="messagerie-threads-list">
                        <?php foreach ($threads as $t): ?>
                            <?php 
                            $isActive = !empty($_GET['conv']) && (int)$_GET['conv'] === (int)$t['conversation_id'];
                            ?>
                            <li class="thread-item <?= $isActive ? 'thread-item--active' : '' ?>">
                                <a href="/tomtroc/public/messages?conv=<?= (int)$t['conversation_id'] ?>" class="thread-item-link">
                                    <div class="thread-item-content">
                                        <div class="thread-item-avatar">
                                            <?php if (!empty($t['other_user_avatar'])): ?>
                                                <img src="/tomtroc/public/<?= htmlspecialchars($t['other_user_avatar']) ?>" alt="Avatar">
                                            <?php else: ?>
                                                <i class="fa-regular fa-user"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="thread-item-info">
                                            <div class="thread-item-header">
                                                <strong class="thread-item-username"><?= htmlspecialchars($t['other_username']) ?></strong>
                                                <span class="thread-item-time"><?= !empty($t['last_created_at']) ? date('H:i', strtotime($t['last_created_at'])) : '' ?></span>
                                                <?php if ((int)$t['unread_count'] > 0): ?>
                                                    <span class="thread-unread-badge"><?= (int)$t['unread_count'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($t['last_body'])): ?>
                                                <div class="thread-item-preview">
                                                    <?= htmlspecialchars(mb_strimwidth($t['last_body'], 0, 60, '...')) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Colonne droite : Conversation -->
            <div class="messagerie-conversation">
                <div class="conversation-content">
                    <?php if (!empty($selectedConversation) && !empty($messages)): ?>
                        <div class="conversation-header">
                            <h2 class="conversation-header-title"><?= htmlspecialchars($selectedConversation['other_username'] ?? 'Utilisateur') ?></h2>
                        </div>

                        <div class="conversation-messages">
                            <?php foreach ($messages as $msg): ?>
                                <?php $isMe = (int)$msg['sender_id'] === (int)$_SESSION['user_id']; ?>
                                <div class="message <?= $isMe ? 'message--me' : 'message--other' ?>">
                                    <div class="message__meta"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></div>
                                    <div class="message__bubble"><?= nl2br(htmlspecialchars($msg['body'])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="conversation-form">
                            <form method="POST" action="/tomtroc/public/messages/thread/<?= (int)$selectedConversation['conversation_id'] ?>">
                                <textarea name="body" class="conversation-textarea" rows="3" placeholder="Tapez votre message ici..." required></textarea>
                                <button type="submit" class="conversation-submit-btn">Envoyer</button>
                            </form>
                        </div>
                    <?php elseif (!empty($_GET['conv'])): ?>
                        <div class="conversation-placeholder">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <p>Conversation introuvable</p>
                        </div>
                    <?php else: ?>
                        <div class="conversation-placeholder">
                            <i class="fa-regular fa-comment"></i>
                            <p>Sélectionnez une discussion pour voir les messages</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
