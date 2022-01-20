<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant de définir plusieurs méthodes utilitaires sur les utilisateurs
// comme ajouter ou sélectionner un utilisateur
class User
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    // Méthode permettant d'ajouter un utilisateur si le nom de cette tâche n'existe pas déjà
    public function insert(array $paValue): bool
    {
        $aAllUser = $this->selectAll();

        // Vérifie si le nom de l'utilisateur existe déjà
        for ($i = 0; $i < count($aAllUser); $i++) {
            if ($paValue[0] === $aAllUser[$i]["username"]) {
                return true;
            }
        }

        $sSql = "
            INSERT INTO users (username, password)
            VALUES(?, ?)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0], password_hash($paValue[1], PASSWORD_DEFAULT)], false);

        return false;
    }

    // Méthode permettant de sélectionner tous les utilisateurs
    public function selectAll(): array
    {
        $sSql = "
            SELECT username
            FROM users
        ";

        $aAllUser = $this->_moDatabase->request($sSql);

        return $aAllUser;
    }

    // Méthode permettant de sélectionner un utilisateur spécifique
    public function selectOne(String $psUsername): array
    {
        $sSql = "
            SELECT username, password
            FROM users
            WHERE username = ?
        ";

        $aUser = $this->_moDatabase->request($sSql,  [$psUsername]);

        return $aUser;
    }

    // Méthode permettant de vérfier la connexion d'un utilisateur
    public function verifyConnection(String $psUsername, String $psPassword): bool
    {
        $aUser = $this->selectOne($psUsername);

        if (!empty($aUser) && password_verify($psPassword, $aUser[0]["password"])) {
            return true;
        } else {
            return false;
        }
    }
}
