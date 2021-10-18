<?php

// Classe permettant
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function (String $psFullClassName): bool {
            $sFilePath = $_SERVER["DOCUMENT_ROOT"] . "/class/$psFullClassName.php";
            $bVerif = false;

            if (file_exists($sFilePath)) {
                $bVerif = true;
            }

            return $bVerif;
        });
    }
}

Autoloader::register();
