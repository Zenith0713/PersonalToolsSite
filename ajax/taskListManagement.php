<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant de gérer différentes actions sur les différents éléments (tâches, éléments des tâches, catégories)
class TaskListManagement
{
    private Task $_moTask;
    private TaskCategory $_moTaskCategory;
    private String $_msAction;
    private array $_maPost;

    public function __construct(array $paPost, array $paGet)
    {
        $this->_moTask = new Task();
        $this->_moTaskCategory = new TaskCategory();
        $this->_maPost = $paPost;
        $this->_msAction = $this->_maPost["action"];

        switch ($this->_maPost["element"]) {
            case "task":
                $this->tasksManagement();
                break;
            case "taskElements":
                $this->taskElementsManagement();
                break;
            case "taskCategories":
                $this->categoriesManagement();
                break;
        }
    }

    // Méthode permettant de gérer les différents action concernant les tâches
    private function tasksManagement()
    {
        $sAjax = "";

        switch ($this->_msAction) {
            case "add":
                $bError = $this->_moTask->insert([$this->_maPost["taskName"]]);

                if ($bError) {
                    $sAjax = "Ce nom de tâche est déjà pris";
                }

                break;
            case "update":
                $this->_moTask->update([$this->_maPost["taskCategory"], $this->_maPost["taskName"]]);
                break;
            case "remove":
                $this->_moTask->delete($this->_maPost["taskName"]);
                break;
        }

        $this->sendDataToJs($sAjax);
    }

    // Méthode permettant de gérer les différents action concernant les éléments des tâches
    private function taskElementsManagement()
    {
        // switch ($this->_msAction) {
        //     case "add":
        //         $this->_moTask->addTask();
        //         break;
        //     case "update":
        //         $this->_moTask->addTask();
        //         break;
        //     case "remove":
        //         $this->_moTask->addTask();
        //         break;
        // }
    }

    // Méthode permettant de gérer les différents action concernant les catégories
    private function categoriesManagement()
    {
        $ajaxData = "";

        switch ($this->_msAction) {
            case "selectAll":
                $ajaxData = $this->_moTaskCategory->selectAll();
                break;
                //     case "add":
                //         $this->_moTask->addTask();
                //         break;
                //     case "update":
                //         $this->_moTask->addTask();
                //         break;
                //     case "remove":
                //         $this->_moTask->addTask();
                //         break;
        }

        $this->sendDataToJs($ajaxData);
    }

    // Méthode permettant d'envoyé le contenu de la variable "pmData" au fichier javascript
    private function sendDataToJs($pData)
    {
        header('Content-Type: application/json');
        echo json_encode($pData);
    }
}

try {
    $oTaskListManagement = new TaskListManagement($_POST, $_GET);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
