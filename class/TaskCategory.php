<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant 
class TaskCategory
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    public function createFirstCategory(): array
    {
        $firstCategoryName = "Autres";

        $sSql = "
            INSERT INTO taskCategories (categoryId, categoryName)
            VALUES(1, ?)
        ";

        $this->_moDatabase->request($sSql, [$firstCategoryName], false);

        return [0 => ["categoryId" => 1, "categoryName" => $firstCategoryName]];
    }

    // Méthode permettant d'ajouter une catégorie si le nom de cette catégorie n'existe pas déjà
    public function insert(array $paValue): array
    {
        $aAllCategory = $this->selectAll();

        // Vérifie si le nom de la catégorie existe déjà
        for ($i = 0; $i < count($aAllCategory); $i++) {
            if ($paValue[0] === $aAllCategory[$i]["categoryName"]) {
                return [true];
            }
        }

        $sSql = "
            INSERT INTO taskCategories (categoryName)
            VALUES(?)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0]], false);

        $sSql = "
            SELECT LAST_INSERT_ID() 
            FROM taskCategories
        ";

        $aCategory = $this->_moDatabase->request($sSql);

        return $aCategory;
    }

    // Méthode permettant de séléctionner toutes les catégories et si il n'y a aucune catégorie, lance la fonction
    // pour en créer une
    public function selectAll(): array
    {
        $sSql = "
            SELECT categoryId, categoryName
            FROM taskCategories
            ORDER BY categoryId DESC
        ";

        $aAllCategory = $this->_moDatabase->request($sSql);

        if (empty($aAllCategory)) {
            return $this->createFirstCategory();
        }

        return $aAllCategory;
    }

    // Méthode permettant de modifier une catégorie
    public function update(array $paValue): bool
    {
        $sSql = "
            UPDATE taskCategories
            SET categoryName = ?
            WHERE categoryId = ?
        ";

        $this->_moDatabase->request($sSql, [$paValue[0], $paValue[1]], false);

        return false;
    }

    // Méthode permettant de supprimer une catégorie
    public function delete(String $psKey): string
    {
        if ($psKey === "1") {
            return "Error";
        }

        $sSql = "
            UPDATE tasks
            SET taskCategory = 1
            WHERE taskCategory = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);

        $sSql = "
            DELETE FROM taskCategories
            WHERE categoryId = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);

        return "";
    }
}
