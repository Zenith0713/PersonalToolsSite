<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// 
function showAllTasks(): string
{

    $oTask = new Task();

    $aAllTasks = $oTask->selectAll();

    $aAllTasks = array_reverse($aAllTasks);

    $sAllTasksArticles = "";

    for ($i = 0; $i < count($aAllTasks); $i++) {
        $sOptions = setOptions($aAllTasks[$i]["taskCategory"]);
        $sAllTasksArticles .= "<article>
            <form method='POST' name='taskName' action='#'>
                <h4>" . $aAllTasks[$i]["taskName"] . "</h4>
                <span class='deleteButton'>X</span>
                <div>
                    <label>Catégories</label>
                    <select>" . $sOptions  . "</select>
                </div>
                <ul>
                    <li><input name='addTask' type='checkbox' value='1'/><label>Ajouter un élément</label></li>
                </ul>
        
                <button type='button'>Ajouter un élément</button>
            </form>
        </article>";
    }

    return $sAllTasksArticles;
}

// 
function setOptions(Int $iTaskCategory): string
{
    $oTaskCategory = new TaskCategory();
    $aAllTaskCategories = $oTaskCategory->selectAll();

    $sOptions = "";

    for ($i = 0; $i < count($aAllTaskCategories); $i++) {
        $sOptionSelect = "";

        if ($iTaskCategory === intval($aAllTaskCategories[$i]["categoryId"])) {
            $sOptionSelect = "selected";
        }

        $sOptions .= "<option value='" . $aAllTaskCategories[$i]["categoryId"] . "' $sOptionSelect>" . $aAllTaskCategories[$i]["categoryName"] . "</option>";
    }

    return $sOptions;
}

// 
function setElements()
{
}

$sAllTasksArticles = showAllTasks();
