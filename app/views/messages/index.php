<div class="messagerie-page">
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
                            $lastCreatedAt = !empty($t['last_at']) ? strtotime($t['last_at']) : null;
                            $lastLabel = '';
                            if (!empty($lastCreatedAt)) {
                                $isToday = date('Y-m-d', $lastCreatedAt) === date('Y-m-d');
                                $lastLabel = $isToday ? date('H:i', $lastCreatedAt) : date('d.m', $lastCreatedAt);
                            }
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
                                                <span class="thread-item-time"><?= $lastLabel ?></span>
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
                    <?php if (!empty($selectedConversation)): ?>
                        <div class="conversation-header">
                            <div class="conversation-header-user">
                                <div class="conversation-header-avatar">
                                    <?php if (!empty($selectedConversation['other_user_avatar'])): ?>
                                        <img src="/tomtroc/public/<?= htmlspecialchars($selectedConversation['other_user_avatar']) ?>" alt="Avatar">
                                    <?php else: ?>
                                        <i class="fa-regular fa-user"></i>
                                    <?php endif; ?>
                                </div>
                                <h2 class="conversation-header-title"><?= htmlspecialchars($selectedConversation['other_username'] ?? 'Utilisateur') ?></h2>
                            </div>
                        </div>

                        <div class="conversation-messages">
                            <?php if (!empty($messages)): ?>
                                <?php foreach ($messages as $msg): ?>
                                    <?php $isMe = (int)$msg['sender_id'] === (int)$_SESSION['user_id']; ?>
                                    <div class="message <?= $isMe ? 'message--me' : 'message--other' ?>">
                                        <div class="message__meta">
                                            <?php if (!$isMe): ?>
                                                <span class="message__avatar">
                                                    <?php if (!empty($selectedConversation['other_user_avatar'])): ?>
                                                        <img src="/tomtroc/public/<?= htmlspecialchars($selectedConversation['other_user_avatar']) ?>" alt="Avatar">
                                                    <?php else: ?>
                                                        <i class="fa-regular fa-user"></i>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                            <span class="message__time"><?= date('d.m H:i', strtotime($msg['created_at'])) ?></span>
                                        </div>
                                        <div class="message__bubble"><?= nl2br(htmlspecialchars($msg['body'])) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="conversation-empty">
                                    <p>Dites bonjour pour démarrer la conversation.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="conversation-form">
                            <form method="POST" action="/tomtroc/public/messages/thread/<?= (int)$selectedConversation['conversation_id'] ?>">
                                <textarea name="body" class="conversation-textarea" rows="1" placeholder="Tapez votre message ici" required></textarea>
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
