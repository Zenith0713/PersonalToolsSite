<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant 
class TaskElement
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    public function insert(): bool
    {
        $sSql = "
            INSERT INTO taskelements (elementId, elementName, elementTask)
            VALUES(?, ?)
        ";

        $this->_moDatabase->request($sSql, [], false);

        return false;
    }

    // Méthode permettant de séléctionner toutes les catégories
    public function selectAll(): array
    {
        $sSql = "
            SELECT categoryId, categoryName
            FROM taskcategories
        ";

        $aAllTask = $this->_moDatabase->request($sSql);

        return $aAllTask;
    }
}
