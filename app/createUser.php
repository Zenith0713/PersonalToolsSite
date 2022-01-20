<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant de créer un utilisateur ou de le rediriger vers la page de création d'utilisateur
// si il y a une erreur
function createUser(String $psUsername, String $psPassword)
{
    $aUser = new User();

    $bUsernameAlreadyTake = $aUser->insert([$psUsername, $psPassword]);

    if ($bUsernameAlreadyTake) {
        session_start();
        $_SESSION["error"] = true;
        header("Location: ../createUser.php");
    } else {
        header("Location: ../login.php");
    }
}

createUser($_POST["username"], $_POST["password"]);
