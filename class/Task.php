<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");
// require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Database.php");

// Classe permettant 
class Task
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    // Méthode permettant d'ajouter une tâche si le nom de cette tâche n'existe pas déjà
    public function insert(array $paValue): bool
    {
        $aAllTask = $this->selectAll();

        // Vérifie si le nom de la tâche existe déjà
        for ($i = 0; $i < count($aAllTask); $i++) {
            if ($paValue[0] === $aAllTask[$i]["taskName"]) {
                return true;
            }
        }

        $sSql = "
            INSERT INTO tasks (taskName, taskCategory)
            VALUES(?, 1)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0]], false);

        return false;
    }

    // Méthode permettant de modifier une tâche
    public function update(array $paValues)
    {
        $sSql = "
            UPDATE tasks
            SET taskCategory = ?
            WHERE taskName = ?
        ";

        $this->_moDatabase->request($sSql, [$paValues[0], $paValues[1]], false);
    }

    // Méthode permettant de séléctionner toutes les tâches
    public function selectAll(): array
    {
        $sSql = "
            SELECT taskName, taskCategory
            FROM tasks
            ORDER BY creationDate DESC
        ";

        $aAllTask = $this->_moDatabase->request($sSql);

        return $aAllTask;
    }

    // Méthode permettant de supprimer une tâche
    public function delete(String $psKey)
    {
        $sSql = "
            DELETE FROM taskElements
            WHERE elementTask = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);

        $sSql = "
            DELETE FROM tasks
            WHERE taskName = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);
    }
}
