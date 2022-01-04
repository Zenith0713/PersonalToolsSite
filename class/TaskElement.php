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

        $aElement = $this->selectValue($paValue);

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
    public function selectValue(array $paValue): array
    {
        $sSql = "
            SELECT elementId, elementName, elementTask
            FROM taskelements
            WHERE elementName = ? AND elementTask = ?
        ";

        $aElement = $this->_moDatabase->request($sSql, [$paValue[0], $paValue[1]]);

        return $aElement;
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
