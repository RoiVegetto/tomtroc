<h1>Nos livres à l’échange</h1>

<?php if (empty($books)): ?>
    <p>Aucun livre disponible pour le moment.</p>
<?php else: ?>
    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:20px;">
        <?php foreach ($books as $book): ?>
            <div style="border:1px solid #eee; padding:12px; border-radius:10px;">
                <?php if (!empty($book['photo'])): ?>
                    <img
                        src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>"
                        alt="<?= htmlspecialchars($book['title']) ?>"
                        style="width:100%; height:200px; object-fit:cover; border-radius:10px;"
                    >
                <?php else: ?>
                    <div style="width:100%; height:200px; background:#f2f2f2; border-radius:10px;"></div>
                <?php endif; ?>

                <h3 style="margin:10px 0 5px;">
                    <?= htmlspecialchars($book['title']) ?>
                </h3>
                <p style="margin:0; color:#666;">
                    <?= htmlspecialchars($book['author']) ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
