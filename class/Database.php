<?php

// Classe permettant 
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
        // $this->_miPort = 3306; // Default 
        $this->_miPort = 3307; // in work
        $this->_msDatabaseName = "mytools";
        $this->_msUsername = "root";
        $this->_msPassword = "";

        $this->connectionToDatabase();
    }

    // Méthode permettant de se connecter à la base de donnée et d'envoyer une erreur si la connexion échoue
    private function connectionToDatabase()
    {
        $sDsn = "mysql:host=" . $this->_msServerName . ";port=" . $this->_miPort . ";dbname=" . $this->_msDatabaseName;

        try {
            $this->_moPdo = new PDO(
                $sDsn,
                $this->_msUsername,
                $this->_msPassword,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            // Faire quelques chsoes d'autres de ce message
            var_dump($e->getMessage());
        }
    }

    // Méthode permettant 
    public function request(String $psSql, array $paArguments = [], Bool $pbReturn = true): array
    {
        try {
            $aArguments = $this->setUt8Arguments($paArguments);

            $oRequestPrepare = $this->_moPdo->prepare($psSql);
            $oRequestPrepare->execute($aArguments);
            $aDataRequest = [];

            if ($pbReturn) {
                $aDataRequest = $oRequestPrepare->fetchAll(PDO::FETCH_ASSOC);
                $aDataRequest = $this->contentFilter($aDataRequest);
            }

            return $aDataRequest;
        } catch (Exception $e) {
            // Faire quelques chsoes d'autres de ce message
            var_dump($e->getMessage());
        }
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
