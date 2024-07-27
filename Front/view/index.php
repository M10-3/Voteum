<?php
session_start();

//require_once '../view/functions.php';
//is_connect();
include_once "../config.php";

if (!isset($_SESSION['auth'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['auth'];
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Strongly Typed by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="homepage is-preload">
    <div id="page-wrapper">

        <!-- Header -->
        <section id="header">
            <div class="container">
                <div class="header-logo">
                    <div class="vote">
                        <a href="index.php">
                            <img src="images/logo.png" alt="Voteum Logo" />
                        </a>
                    </div>
                    <a href="http://localhost/gestion_vote/Front/controller/profilController.php" class="profile-button">
                        <?php
                        // Assuming $user is an array with 'full_name' key
                        $initials = strtoupper(substr($user['full_name'], 0, 1)) . strtoupper(substr($user['full_name'], strpos($user['full_name'], ' ') + 1, 1));
                        echo htmlspecialchars($initials);
                        ?>
                    </a>
                    <!-- Logo -->
                    <h1 id="logo">Bienvenue, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
                    <p>Rejoignez une communauté engagée et faites entendre votre voix pour un avenir meilleur.</p>

                    <!-- Nav -->
                    <nav id="nav">
                        <ul>
                            <li><a class="icon solid fa-home" href="index.php"><span>Introduction</span></a></li>
                            <li>
                                <a href="page_vote.php" class="icon fa-chart-bar"><span>Vote</span></a>
                                <ul>
                                    <li><a href="#">Lorem ipsum dolor</a></li>
                                    <li><a href="#">Magna phasellus</a></li>
                                    <li><a href="#">Etiam dolore nisl</a></li>
                                    <li>
                                        <a href="#">Phasellus consequat</a>
                                        <ul>
                                            <li><a href="#">Magna phasellus</a></li>
                                            <li><a href="#">Etiam dolore nisl</a></li>
                                            <li><a href="#">Phasellus consequat</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Veroeros feugiat</a></li>
                                </ul>
                            </li>
                            <li><a class="icon solid fa-cog" href="left-sidebar.html"><span>Left Sidebar</span></a></li>
                            <li><a class="icon solid fa-retweet" href="right-sidebar.html"><span>Right
                                        Sidebar</span></a></li>
                            <li><a class="icon solid fa-sitemap" href="no-sidebar.html"><span>No Sidebar</span></a></li>
                        </ul>
                    </nav>

                </div>
        </section>

        <!-- Features -->
        <section id="features">
            <div class="container">
                <div class="row aln-center">
                    <div class="col-4 col-6-medium col-12-small">

                        <!-- Feature -->
                        <section>
                            <a href="#" class="image featured"><img src="images/1.jpg" alt=""
                                    class="featured-img" /></a>
                            <header>
                                <h3>Tunisie : Grâce présidentielle pour les crimes liés à des publications sur les
                                    réseaux sociaux</h3>
                            </header>
                            <p>Le président de la République, Kaïs Saïed, a signé, mercredi 24 juillet 2024, un décret
                                relatif à une grâce présidentielle spéciale, en vertu des dispositions de l'article 99
                                de la Constitution. Ce décret prévoit l'annulation des peines pour plusieurs condamnés
                                ayant commis des infractions liées à la publication de posts sur les réseaux sociaux.
                                <a
                                    href="https://www.webdo.tn/fr/actualite/national/tunisie-grace-presidentielle-pour-les-crimes-lies-a-des-publications-sur-les-reseaux-sociaux/215467">En
                                    savoir plus</a>
                            </p>
                        </section>

                    </div>
                    <div class="col-4 col-6-medium col-12-small">

                        <!-- Feature -->
                        <section>
                            <a href="#" class="image featured"><img src="images/4.jpg" alt=""
                                    class="featured-img" /></a>
                            <header>
                                <h3>Prochaine élection présidentielle : La carte Assimi est-elle jouable ?</h3>
                            </header>
                            <p>Au moment où le Médiateur de la CEDEAO, le président Patrice Talon du Bénin, s’apprête à
                                venir à Bamako pour tâter le pouls de la Transition malienne, les rumeurs se font encore
                                plus persistantes sur la probable candidature du Col Assimi Goïta. <a
                                    href="https://www.maliweb.net/nation/prochaine-election-presidentielle-la-carte-assimi-est-elle-jouable-3029750.html">En
                                    savoir plus</a></p>
                        </section>

                    </div>
                    <div class="col-4 col-6-medium col-12-small">

                        <!-- Feature -->
                        <section>
                            <a href="#" class="image featured"><img src="images/3.jpg" alt=""
                                    class="featured-img" /></a>
                            <header>
                                <h3>Dans la ville de Gaza, des dizaines de corps retrouvés après des attaques
                                    israéliennes </h3>
                            </header>
                            <p>Des membres de la défense civile ont découvert vendredi des corps ensevelis dans les
                                décombres de bâtiments effondrés.<a
                                    href="https://fr.euronews.com/2024/07/13/dans-la-ville-de-gaza-des-dizaines-de-corps-retrouves-apres-des-attaques-israeliennes">En
                                    savoir plus</a></p>
                        </section>

                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><a href="#" class="button icon solid fa-file">Tell Me More</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <section id="footer">
            <div class="container">
                <header>
                    <h2>Questions or comments? <strong>Get in touch:</strong></h2>
                </header>
                <div class="row">
                    <div class="col-6 col-12-medium">
                        <section>
                            <form method="post" action="#">
                                <div class="row gtr-50">
                                    <div class="col-6 col-12-small">
                                        <input name="name" placeholder="Name" type="text" />
                                    </div>
                                    <div class="col-6 col-12-small">
                                        <input name="email" placeholder="Email" type="text" />
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <a href="#" class="form-button-submit button icon solid fa-envelope">Send
                                            Message</a>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                    <div class="col-6 col-12-medium">
                        <section>
                            <p>Erat lorem ipsum veroeros consequat magna tempus lorem ipsum consequat Phaselamet
                                mollis tortor congue. Sed quis mauris sit amet magna accumsan tristique. Curabitur
                                leo nibh, rutrum eu malesuada.</p>
                            <div class="row">
                                <div class="col-6 col-12-small">
                                    <ul class="icons">
                                        <li class="icon solid fa-home">
                                            1234 Somewhere Road<br />
                                            Nashville, TN 00000<br />
                                            USA
                                        </li>
                                        <li class="icon solid fa-phone">
                                            (000) 000-0000
                                        </li>
                                        <li class="icon solid fa-envelope">
                                            <a href="#">info@untitled.tld</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-6 col-12-small">
                                    <ul class="icons">
                                        <li class="icon brands fa-twitter">
                                            <a href="#">@untitled</a>
                                        </li>
                                        <li class="icon brands fa-instagram">
                                            <a href="#">instagram.com/untitled</a>
                                        </li>
                                        <li class="icon brands fa-dribbble">
                                            <a href="#">dribbble.com/untitled</a>
                                        </li>
                                        <li class="icon brands fa-facebook-f">
                                            <a href="#">facebook.com/untitled</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div id="copyright" class="container">
                <ul class="links">
                    <li>&copy; Untitled. All rights reserved.</li>
                    <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                </ul>
            </div>
        </section>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>