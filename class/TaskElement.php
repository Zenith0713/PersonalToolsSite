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
    public function insert(array $paValue): bool
    {
        $sSql = "
            INSERT INTO taskelements (elementName, elementTask)
            VALUES(?, ?)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0], $paValue[1]], false);

        return false;
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
    public function selectAll(): array
    {
        $sSql = "
            SELECT elementId, elementName, elementTask
            FROM taskelements
        ";

        $aAllElements = $this->_moDatabase->request($sSql);

        return $aAllElements;
    }
}
