<?php

// Fonction permettant de vérifier si l'utilisateur est connecté, sinon le redirige vers
// la page de connexion
function verifyUserConnection()
{
    session_start();

    if (empty($_SESSION["username"])) {
        header("Location: login.php");
    }
}

verifyUserConnection();
