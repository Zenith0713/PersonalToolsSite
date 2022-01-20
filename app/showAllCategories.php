<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant d'afficher toutes les catégories avec les boutons permettant de 
// modifier et supprimer la catégorie voulu
function showAllCategories(): string
{
    $oTaskCategory = new TaskCategory();

    $aAllCategories = $oTaskCategory->selectAll();

    $sAllCategoriesLi = "";
    $sSpans = "<span class='updateCategory'><i class='fas fa-edit'></i></span><span class='deleteCategory'><i class='fas fa-trash'></i></span>";

    for ($i = 0; $i < count($aAllCategories); $i++) {
        $sForm =  "<form class='hide'><input value='" . $aAllCategories[$i]["categoryName"] . "' type='text'/></form>";
        $sAllCategoriesLi .= "<li data-categoryId='" . $aAllCategories[$i]["categoryId"] . "'><p>" . $aAllCategories[$i]["categoryName"] . "</p>" . $sForm . $sSpans . "</li>";
    }

    return $sAllCategoriesLi;
}

$sAllCategoriesLi = showAllCategories();
