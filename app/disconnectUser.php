<?php

// Fonction permettant de déconnecter l'utilisateur et de le rediriger vers la page
// de connexion
function disconnectUser()
{
    session_start();

    unset($_SESSION["username"]);

    header("Location: ../login.php");
}

disconnectUser();
