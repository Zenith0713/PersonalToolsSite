<?php

// Classe permettant de charger le fichier requis lors de la définition d'une classe
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function (String $psFullClassName): bool {
            $sFilePath = $_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/$psFullClassName.php";
            $bVerif = false;

            if (file_exists($sFilePath)) {
                require $sFilePath;
                $bVerif = true;
            }

            return $bVerif;
        });
    }
}

Autoloader::register();
