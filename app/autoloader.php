<?php

// Mise en place de l'auto loader permettant de lancer n'importe quelle classe dynamiquemnt
// à condition quelle soit contenu dans le répertoire "class" 
spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . "/PersonalToolsSite/class/$class_name.php";
});
