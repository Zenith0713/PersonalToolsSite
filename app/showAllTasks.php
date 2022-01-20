<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant d'afficher toutes les tâches avec la selection de catégories,
// leurs éléments, etc...
function showAllTasks(): string
{
    $oTask = new Task();

    $aAllTasks = $oTask->selectAll();

    $sAllTasksArticles = "";

    for ($i = 0; $i < count($aAllTasks); $i++) {
        $sCategoriesOptions = setsCategoriesOptions($aAllTasks[$i]["taskCategory"]);
        $sElementsList = setElements(html_entity_decode($aAllTasks[$i]["taskName"]));

        $sAllTasksArticles .= "<article>
            <div><h4>" . $aAllTasks[$i]["taskName"] . "</h4>
            <span class='deleteButton'><i class='fas fa-trash'></i></span></div>
            <div>
                <label>Catégories :</label>
                <select>" . $sCategoriesOptions  . "</select>
            </div>
            <ul>" . $sElementsList . "</ul>
            <div>
                <input name='addElementTask' type='text' placeholder='Nouvel élément' />
                <button class='addElementButton' type='button'>Ajouter</button>
            </div>
        </article>";
    }

    return $sAllTasksArticles;
}

// Fonction retournant les différents catégories dans des balises "<option>"
function setsCategoriesOptions(Int $piTaskCategory): string
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

// Fonction retournant les différents éléments d'une catégorie spécifique
function setElements(String $psTaskName): string
{
    $oTaskElement = new TaskElement();
    $aAllTaskElements = $oTaskElement->selectFromTask($psTaskName);
    $aAllTaskElements = array_reverse($aAllTaskElements);
    $sTaskElementsList = "";

    for ($i = 0; $i < count($aAllTaskElements); $i++) {
        $sTaskElementsList .= "<li>
            <p>" . $aAllTaskElements[$i]["elementName"] . "</p>
            <form class='hide'>
                <input name='" . $aAllTaskElements[$i]["elementId"] . "' type='text' value='" . $aAllTaskElements[$i]["elementName"] . "'/>
            </form>
            <span class='updateElement' data-element='" . $aAllTaskElements[$i]["elementId"] . "'><i class='fas fa-edit'></i></span>
            <span class='deleteElement' data-element='" . $aAllTaskElements[$i]["elementId"] . "'><i class='fas fa-trash'></i></span>
        </li>";
    }

    return $sTaskElementsList;
}

$sAllTasksArticles = showAllTasks();
