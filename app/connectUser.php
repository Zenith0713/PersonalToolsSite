<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant de connecter l'utilisateur ou de le rediriger vers la page de connexion
// si les identifiants sont incorrects
function connectUser(String $psUsername, String $psPassword)
{
    $aUser = new User();

    $bConnected = $aUser->verifyConnection($psUsername, $psPassword);

    session_start();

    if ($bConnected) {
        $_SESSION["username"] = $psUsername;
        header("Location: ../index.php");
    } else {
        $_SESSION["error"] = true;
        header("Location: ../login.php");
    }
}

connectUser($_POST["username"], $_POST["password"]);
