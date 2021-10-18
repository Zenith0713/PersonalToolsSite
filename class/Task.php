<?php

require($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant 
class Task
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    // Méthode permettant d'ajouter une tâche
    public function insert(String $psTaskName): bool
    {
        $aAllTask = $this->selectAll();

        // Vérifie si le nom de la tâche existe déjà
        for ($i = 0; $i < count($aAllTask); $i++) {
            if ($psTaskName === $aAllTask[$i]["taskName"]) {
                return true;
            }
        }

        $sSql = "
            INSERT INTO task (taskName, taskCategory, taskCompleted)
            VALUES(?, 1, 0)
        ";

        var_dump("hello");

        // $this->_moDatabase->request($sSql, [$psTaskName], false);

        return false;
    }

    // Méthode permettant de séléctionner toutes les tâches
    public function selectAll(): array
    {
        $sSql = "
            SELECT taskId, taskName, taskCategory, taskCompleted
            FROM task
        ";

        $aAllTask = $this->_moDatabase->request($sSql);

        return $aAllTask;
    }
}
