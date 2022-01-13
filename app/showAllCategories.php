<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Fonction permettant
function showAllCategories(): string
{
    $oTaskCategory = new TaskCategory();

    $aAllCategories = $oTaskCategory->selectAll();

    $sAllCategoriesLi = "";
    $sSpans = "<span class='updateCategory'> V</span><span class='deleteCategory'> X</span>";

    for ($i = 0; $i < count($aAllCategories); $i++) {
        $sForm =  "<form class='hide'><input value='" . $aAllCategories[$i]["categoryName"] . "'/></form>";
        $sAllCategoriesLi .= "<li data-categoryId='" . $aAllCategories[$i]["categoryId"] . "'><p>" . $aAllCategories[$i]["categoryName"] . "</p>" . $sForm . $sSpans . "</li>";
    }

    return $sAllCategoriesLi;
}

$sAllCategoriesLi = showAllCategories();
