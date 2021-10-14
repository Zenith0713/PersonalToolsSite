<?php

require($_SERVER['DOCUMENT_ROOT'] . "/PersonalToolsSite/app/autoloader.php");

// Class permettant de gérer différentes action sur les différents éléments (tâches, éléments des tâches, catégories)
class TaskListManagement
{
    private Task $_moTask;
    private String $_msAction;
    private array $_maPost;

    public function __construct(array $paPost, array $paGet)
    {
        $this->_moTask = new Task();
        $this->_maPost = $paPost;
        $this->_msAction = $this->_maPost["action"];

        switch ($this->_maPost["element"]) {
            case "task":
                $this->taskManagement();
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
    private function taskManagement()
    {
        switch ($this->_msAction) {
            case "add":
                $bError = $this->_moTask->add($this->_maPost["taskName"]);
                $sAjax = "";

                if ($bError) {
                    $sAjax = "Ce nom de tâche est déjà pris";
                }

                $this->sendDataToJs($sAjax);

                break;
            case "update":
                // $this->_moTask->addTask();
                break;
            case "remove":
                // $this->_moTask->addTask();
                break;
        }
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
