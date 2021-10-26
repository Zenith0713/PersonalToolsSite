<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");


function showAllTasks(): string
{

    $oTask = new Task();

    $aAllTasks = $oTask->selectAll();

    $sAllTasksArticles = "";

    for ($i = 0; $i < count($aAllTasks); $i++) {
        $sAllTasksArticles .= "<article>
            <form method='POST' name='taskName' action='#'>
                <h4>" . $aAllTasks[$i]["taskName"] . "</h4>
                <span>X</span>
                <div>
                    <label>Catégories</label>
                    <select>
                        <option value=''>Aucune</option>
                        <option value=''>Maison</option>
                    </select>
                </div>
                <ul>
                    <li><input name='addTask' type='checkbox' value='1'/><label>Ajouter un élément</label></li>
                </ul>
        
                <button type='button'>Ajouter un élément</button>
                <button type='button'>Complété</button>
            </form>
        </article>";
    }

    return $sAllTasksArticles;
}

$sAllTasksArticles = showAllTasks();
