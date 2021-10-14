<?php

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
        // $this->_miPort = 3307; // in work
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
            $oRequestPrepare = $this->_moPdo->prepare($psSql);
            $oRequestPrepare->execute($paArguments);
            $aDataRequest = [];

            if ($pbReturn) {
                $aDataRequest = $oRequestPrepare->fetchAll(PDO::FETCH_ASSOC);
            }

            return $aDataRequest;
        } catch (Exception $e) {
            // Faire quelques chsoes d'autres de ce message
            var_dump($e->getMessage());
        }
    }
}

$oDatabase = new Database();
