<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant
function showAllTasks(): string
{

    $oTask = new Task();

    $aAllTasks = $oTask->selectAll();

    $sAllTasksArticles = "";

    for ($i = 0; $i < count($aAllTasks); $i++) {
        $sOptions = setOptions($aAllTasks[$i]["taskCategory"]);
        $sElementsList = setElements($aAllTasks[$i]["taskName"]);

        $sAllTasksArticles .= "<article>
            <form method='POST' name='taskName' action='#'>
                <h4>" . $aAllTasks[$i]["taskName"] . "</h4>
                <span class='deleteButton'>X</span>
                <div>
                    <label>Catégories</label>
                    <select>" . $sOptions  . "</select>
                </div>
                <ul>" . $sElementsList . "</ul>
                <div>
                    <input name='addElementTask' type='text' />
                    <button class='addElementButton' type='button'>Ajouter un élément</button>
                </div>
            </form>
        </article>";
    }

    return $sAllTasksArticles;
}

// Fonction permettant
function setOptions(Int $piTaskCategory): string
{
    $oTaskCategory = new TaskCategory();
    $aAllTaskCategories = $oTaskCategory->selectAll();

    $sOptions = "";

    for ($i = 0; $i < count($aAllTaskCategories); $i++) {
        $sOptionSelect = "";

        if ($piTaskCategory === intval($aAllTaskCategories[$i]["categoryId"])) {
            $sOptionSelect = "selected";
        }

        $sOptions .= "<option value='" . $aAllTaskCategories[$i]["categoryId"] . "' $sOptionSelect>" . $aAllTaskCategories[$i]["categoryName"] . "</option>";
    }

    return $sOptions;
}

// Fonction permettant
function setElements(String $psTaskName): string
{
    $oTaskElement = new TaskElement();
    $aAllTaskElements = $oTaskElement->selectFromTask($psTaskName);

    $sTaskElementsList = "";

    for ($i = 0; $i < count($aAllTaskElements); $i++) {
        $sTaskElementsList .= "<li>
            <input name='taskCompleted' type='checkbox' value='1'/>
            <label>" . $aAllTaskElements[$i]["elementName"] . "</label>
            <input name='element" . $i . "' type='text' class='hide' value='" . $aAllTaskElements[$i]["elementName"] . "'/>
            <label class='hide'>V</label>
            <label>X</label>
        </li>";
    }

    return $sTaskElementsList;
}

$sAllTasksArticles = showAllTasks();
