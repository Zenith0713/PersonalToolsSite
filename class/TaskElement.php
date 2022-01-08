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

    // Méthode permettant
    public function insert(array $paValue): array
    {
        $sSql = "
            INSERT INTO taskelements (elementName, elementTask)
            VALUES(?, ?)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0], $paValue[1]], false);

        $sSql = "
            SELECT LAST_INSERT_ID() 
            FROM taskelements
        ";

        $aElement = $this->_moDatabase->request($sSql);

        return $aElement;
    }

    // Méthode permettant de séléctionner tous les éléments d'une tâche
    public function selectFromTask(String $psTaskName): array
    {
        $sSql = "
            SELECT elementId, elementName, elementTask
            FROM taskelements
            WHERE elementTask = ?
        ";

        $aAllTaskElements = $this->_moDatabase->request($sSql, [$psTaskName]);

        return $aAllTaskElements;
    }

    // Méthode permettant de séléctionner tous les éléments
    public function update(array $paValue): bool
    {
        $sSql = "
            UPDATE taskelements
            SET elementName = ?
            WHERE elementId = ?
        ";

        $this->_moDatabase->request($sSql, [$paValue[0], $paValue[1]], false);

        return false;
    }

    // Méthode permettant de supprimer un élémént d'une tâche
    public function delete(String $psKey)
    {
        $sSql = "
            DELETE FROM taskElements
            WHERE elementId = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);
    }
}
