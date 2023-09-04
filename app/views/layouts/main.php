<?php
use app\core\Application;
/** @var \$this app\core\View */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Game Zone - <?php echo $this->title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if(Application::$app->getSession()->getFlash('success')): ?>
        <div>
            <p><?php echo Application::$app->getSession()->getFlash('success'); ?></p>
        </div>
    <?php endif; ?>
    <div class="container">
        <!-- Header start -->
        <header>
            <div class="header-container">
                <div>
                    <button class="hamburger">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <a href="/">
                        <h1 class="logo">The Game Zone</h1>
                    </a>
                </div>
                <div class="menu">
                    <input id="search" type="search" name="search" placeholder="rechercher" />
                    <nav>
                        <ul class="main-navigation flex">
                            <li><a href="/">Accueil</a></li>
                            <li>
                                <a class="dropdown">
                                    Genre
                                    <ul class="dropdown-content flex">
                                        <li><a href="/search?genre=action">Action</a></li>
                                        <li><a href="/search?genre=aventure">Aventure</a></li>
                                        <li><a href="/search?genre=tir">Tir</a></li>
                                        <li><a href="/search?genre=horreur">Horreur</a></li>
                                        <li><a href="/search?genre=rpg">RPG</a></li>
                                        <li><a href="/search?genre=roguelike">Roguelike</a></li>
                                        <li><a href="/search?genre=sport">Sport</a></li>
                                        <li><a href="/search?genre=combat">Combat</a></li>
                                    </ul>
                                </a>
                            </li>
                            <li><a href="/support">Support</a></li>
                            <li><a href="/about">&Agrave; propos</a></li>
                            <?php if(!Application::isConnected()) : ?>
                                <li><a href="/login">Se connecter</a></li>
                                <li><a href="/register">Créer un compte</a></li>
                            <?php else : ?>
                                <li><span><?php echo Application::$app->getUser()->getName(); ?></span></li>
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/logout">Se déconnecter</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="hero-image">
            <div class="hero-text">
                <h2>Lorem ipsum dolor sit amet.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error iste nobis ut dolor delectus repellendus minima illo. Maxime, deleniti a. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, ea?</p>
            </div>                            
        </div>
        {{content}}
        <footer>
            <div class="footer-container">
                <a href="/">The Game Zone</a>
                <p>©2023 Tous droit réservés.</p>
            </div>
    </footer>
    </div>
    <script src="js/script.js"></script>
</body>
</html>