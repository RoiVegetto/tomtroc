    <!-- Section 1: Introduction -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Rejoignez nos lecteurs passionnés</h1>
                    <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
                    <a href="/tomtroc/public/books/exchange" class="btn-discover">Découvrir</a>
                </div>
                <div class="hero-image">
                    <img src="/tomtroc/public/images/homme_lisant.jpg" alt="Homme lisant" class="reading-image">
                    <p class="image-caption">Hamza</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Derniers livres ajoutés -->
    <section class="latest-books-section">
        <div class="container">
            <h2 class="section-title">Les derniers livres ajoutés</h2>
            <div class="latest-books-grid">
                <?php if (!empty($latestBooks)): ?>
                    <?php foreach ($latestBooks as $book): ?>
                        <a class="book-card-large" href="/tomtroc/public/books/show/<?= (int)$book['id'] ?>">
                            <div class="book-cover">
                                <?php if (!empty($book['photo'])): ?>
                                    <img src="/tomtroc/public/<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="book-cover-placeholder"></div>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
                                <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
                                <p class="book-seller">Vendu par : <?= htmlspecialchars($book['owner_username']) ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun livre disponible pour le moment.</p>
                <?php endif; ?>
            </div>
            <div class="see-all-link">
                <a href="/tomtroc/public/books/exchange" class="btn-see-all">Voir tous les livres</a>
            </div>
        </div>
    </section>

    <!-- Section 3: Comment ça marche -->
    <section class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">Comment ça marche ?</h2>
            <p class="section-subtitle">Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :</p>
            <div class="steps-grid">
                <div class="step">
                    <p>Inscrivez-vous gratuitement sur notre plateforme.</p>
                </div>
                <div class="step">
                    <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
                </div>
                <div class="step">
                    <p>Parcourez les livres disponibles chez d'autres membres.</p>
                </div>
                <div class="step">
                    <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
                </div>
            </div>
            <div class="see-all-link">
                <a href="/tomtroc/public/books/exchange" class="btn-see-all">Voir tous les livres</a>
            </div>
        </div>
    </section>

    <!-- Section 4: Nos valeurs -->
    <section class="values-section">
        <div class="full-width-image">
            <img src="/tomtroc/public/images/femme_biblio.jpg" alt="Équipe Tom Troc" class="team-image">
        </div>
        <div class="container">
            <h2 class="section-title">Nos valeurs</h2>
            <p class="values-text">
                Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
            </p>
            <p class="values-text">
                Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
            </p>
            <p class="values-text">
                Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
            </p>
            <p class="team-signature">L'équipe Tom Troc</p>
        </div>
    </section>