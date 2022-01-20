<?php
require($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/app/session.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>

    <!-- Lien CSS -->
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div id="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a title="Page d'accueil" href="index.php">Accueil</a>

            <ul id="menu">
                <li><a title="Page de listes de tâches" href="taskList.php">To-Do</a></li>
                <li><a title="Page sur la musculation" href="#">Musculation</a></li>
                <li><a title="Page sur les jeux vidéos" href="#">Jeux vidéos</a></li>
                <li><a title="Page sur les animes/manga/weebtoon" href="#">Animes</a></li>
                <li><a title="Page sur l'argent" href="#">Finances</a></li>
                <li><a title="Autre page" href="#">Autres</a></li>
                <li><a title="Autre page" href="app/disconnectUser.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>