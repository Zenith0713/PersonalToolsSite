<?php

// Classe permettant de définir plusieurs méthodes pour la connexion à la base
// de données et pour faire des requêtes
class Database
{
    private String $_msServerName;
    private Int $_miPort;
    private String $_msDatabaseName;
    private String $_msUsername;
    private String $_msPassword;
    private Pdo $_moPdo;

    public function __construct()
    {
        $this->_msServerName = "localhost";
        $this->_miPort = 3306; // Default 
        $this->_msDatabaseName = "mytools";
        $this->_msUsername = "root";
        $this->_msPassword = "";

        $this->connectionToDatabase();
    }

    // Méthode permettant de se connecter à la base de données
    private function connectionToDatabase()
    {
        $sDsn = "mysql:host=" . $this->_msServerName . ";port=" . $this->_miPort . ";dbname=" . $this->_msDatabaseName;

        $this->_moPdo = new PDO(
            $sDsn,
            $this->_msUsername,
            $this->_msPassword,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    // Méthode permettant d'envoyer une requête à la base de données 
    public function request(String $psSql, array $paArguments = [], Bool $pbReturn = true): array
    {
        $aArguments = $this->setUt8Arguments($paArguments);

        $oRequestPrepare = $this->_moPdo->prepare($psSql);
        $oRequestPrepare->execute($aArguments);
        $aDataRequest = [];

        if ($pbReturn) {
            $aDataRequest = $oRequestPrepare->fetchAll(PDO::FETCH_ASSOC);
            $aDataRequest = $this->contentFilter($aDataRequest);
        }

        return $aDataRequest;
    }

    // Méthode permettant de convertir chaque argument d'un jeu de caractères (UTF-8) à un autre (CP1252)
    // pour n'avoir aucun problème de compatibilité
    private function setUt8Arguments(array $paArguments): array
    {
        if (empty($paArguments)) {
            return $paArguments;
        } else {
            $aNewArguments = [];

            for ($i = 0; $i < count($paArguments); $i++) {
                $aNewArguments[] = iconv("UTF-8", "CP1252", $paArguments[$i]);
            }

            return $aNewArguments;
        }
    }

    // Méthode permettant de filtrer les injections SQL et les caractères spéciaux pour que le données renvoyées 
    // soient corrects
    private function contentFilter(array $paContent): array
    {
        $aRequest = [];

        foreach ($paContent as $key => $value) {
            $aRequest[$key] = $value;

            foreach ($aRequest[$key] as $key2 => $value2) {
                $newValue = htmlentities($value2, ENT_COMPAT, 'ISO-8859-1', true);

                $aRequest[$key][$key2] = mb_convert_encoding($newValue, "UTF-8", "Windows-1252");
            }
        }

        return $aRequest;
    }
}

$oDatabase = new Database();
