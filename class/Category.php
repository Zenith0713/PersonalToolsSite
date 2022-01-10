<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/PersonalToolsSite/class/Autoloader.php");

// Classe permettant 
class Category
{
    private Database $_moDatabase;

    public function __construct()
    {
        $this->_moDatabase = new Database();
    }

    // Méthode permettant d'ajouter une catégorie si le nom de cette catégorie n'existe pas déjà
    public function insert(array $paValue): bool
    {
        $aAllCategory = $this->selectAll();

        // Vérifie si le nom de la catégorie existe déjà
        for ($i = 0; $i < count($aAllCategory); $i++) {
            if ($paValue[0] === $aAllCategory[$i]["categoryName"]) {
                return true;
            }
        }

        $sSql = "
            INSERT INTO taskCategories (categoryName)
            VALUES(?)
        ";

        $this->_moDatabase->request($sSql, [$paValue[0]], false);

        return false;
    }

    // Méthode permettant de séléctionner toutes les catégories
    public function selectAll(): array
    {
        $sSql = "
            SELECT categoryId, categoryName
            FROM taskCategories
            ORDER BY categoryId DESC
        ";

        $aAllCategory = $this->_moDatabase->request($sSql);

        return $aAllCategory;
    }

    // Méthode permettant de supprimer une catégorie
    public function delete(String $psKey)
    {
        $sSql = "
            DELETE FROM taskCategories
            WHERE categoryId = ?
        ";

        $this->_moDatabase->request($sSql, [$psKey], false);
    }
}
