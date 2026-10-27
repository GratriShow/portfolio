<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($uri, '/admin')) {
    $filename = basename($uri) ?: 'index.php';
    if (pathinfo($filename, PATHINFO_EXTENSION) === 'php') {
        $adminFile = __DIR__ . '/admin/' . $filename;
        if (is_file($adminFile)) {
            require $adminFile;
            exit;
        }
    }
}
require_once 'model.php';

$skills      = all('skills');
$experiences = all('experiences');
$formations  = all('formations');

require_once 'head.php';
require_once 'header.php';
?>

<main>
    <section id="apropos">
        <header class="section-header">
            <h2>À propos de moi</h2>
        </header>
        <article class="section-content">
            <p>Je m’appelle Lucas Noel, j’ai 18 ans et je suis actuellement étudiant en première année de DEUST
                Webmaster et Métiers de l’Internet à l’Université du Littoral Côte d’Opale à Calais.</p>
            <p>Passionné par l’entrepreneuriat, le développement web et la programmation Java, j’aime concevoir des
                projets numériques alliant créativité et technicité. Mon objectif est de développer mes compétences
                en conception web, en gestion de projet et en développement d’applications, afin de bâtir des
                solutions innovantes et professionnelles.</p>
            <address class="infos">
                <p>Localisation : Wirwignes, France</p>
                <p>Site : xynoweb.fr</p>
                <p>Email : lucas.noel000@univ-littoral.fr</p>
            </address>
        </article>
    </section>

    <section id="competences">
        <header class="section-header">
            <h2>Compétences</h2>
        </header>
        <ul class="skills">
            <?php foreach ($skills as $skill): ?>
            <li class="skill">
                <span><?= $skill['nom'] ?></span>
                <div class="bar">
                    <div class="progress <?= $skill['classe'] ?>"></div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    
    <section id="experiences">
        <header class="section-header">
            <h2>Expériences</h2>
        </header>
        <ul class="experience-list">
            <?php foreach ($experiences as $experience): ?>
            <li class="experience-card">
                <?php if (!empty($experience['image'])): ?>
                <img class="experience-img" src="<?= htmlspecialchars($experience['image']) ?>" alt="<?= htmlspecialchars($experience['titre']) ?>">
                <?php endif; ?>
                <article class="experience-card-body">
                    <h3><?= $experience['titre'] ?></h3>
                    <p class="location"><?= $experience['lieu'] ?></p>
                    <p class="type"><?= $experience['type'] ?></p>
                    <p class="date"><?= $experience['date'] ?></p>
                </article>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section id="formations">
        <header class="section-header">
            <h2>Formations</h2>
        </header>
        <ul class="formation-list">
            <?php foreach ($formations as $formation): ?>
            <li class="formation-card">
                <p><?= $formation['ecole'] ?> - <span class="highlight"><?= $formation['diplome'] ?></span></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>

<?php require_once 'footer.php'; ?>