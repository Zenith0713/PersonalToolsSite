<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// 
function showAllTasks(): string
{

    $oTask = new Task();

    $aAllTasks = $oTask->selectAll();

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
                    <li>
                        <input name='taskCompleted' type='checkbox' value='1'/>
                        <label>Ajouter un élément</label>
                        <input name='element1' type='text' class='hide' value='Ajouter un élément'/>
                        <label class='hide'>V</label>
                        <label>X</label>
                    </li>
                </ul>
        
                <div>
                <input name='addElementTask' type='text' />
                <button class='addElementButton' type='button'>Ajouter un élément</button>
                </div>
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
