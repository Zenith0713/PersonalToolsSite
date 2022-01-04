<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant de gérer différentes actions sur les différents éléments (tâches, éléments des tâches, catégories)
class TaskListManagement
{
    private Task $_moTask;
    private TaskElement $_moTaskElement;
    private TaskCategory $_moTaskCategory;
    private array $_maPost;
    private String $_msAction;
    private $_mAjax;

    public function __construct(array $paPost, array $paGet)
    {
        $this->_moTask = new Task();
        $this->_moTaskCategory = new TaskCategory();
        $this->_moTaskElement = new TaskElement();
        $this->_maPost = $paPost;
        $this->_msAction = $this->_maPost["action"];
        $this->_mAjax = "";

        switch ($this->_maPost["element"]) {
            case "task":
                $this->tasksManagement();
                break;
            case "taskElement":
                $this->taskElementsManagement();
                break;
            case "taskCategory":
                $this->categoriesManagement();
                break;
        }

        $this->sendDataToJs($this->_mAjax);
    }

    // Méthode permettant de gérer les différents action concernant les tâches
    private function tasksManagement()
    {
        switch ($this->_msAction) {
            case "add":
                $bError = $this->_moTask->insert([$this->_maPost["taskName"]]);

                if ($bError) {
                    $this->_mAjax = "Ce nom de tâche est déjà pris";
                }

                break;
            case "update":
                $this->_moTask->update([$this->_maPost["taskCategory"], $this->_maPost["taskName"]]);
                break;
            case "remove":
                $this->_moTask->delete($this->_maPost["taskName"]);
                break;
        }
    }

    // Méthode permettant de gérer les différents action concernant les éléments des tâches
    private function taskElementsManagement()
    {
        switch ($this->_msAction) {
            case "add":
                $this->_moTaskElement->insert([$this->_maPost["elementName"], $this->_maPost["elementTask"]]);
                break;
                // case "update":
                //     $this->_moTask->addTask();
                //     break;
                // case "remove":
                //     $this->_moTask->addTask();
                //     break;
        }
    }

    // Méthode permettant de gérer les différents action concernant les catégories
    private function categoriesManagement()
    {
        switch ($this->_msAction) {
            case "selectAll":
                $this->_mAjax = $this->_moTaskCategory->selectAll();
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
