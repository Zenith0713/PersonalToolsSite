<?php

// Interface permettant
interface i
{
    // Méthode permettant de séléctionner un élément de la base de données
    public function getValue(String $psFieldName): string;
    // Méthode permettant de séléctionner plusieurs éléments de la base de données
    public function selectAll(): array;
    // Méthode permettant d'ajouter un élément à la base de données
    public function insert(array $paValues);
    // Méthode permettant de modifier les valeurs un élément de la base de données
    public function update(array $paValues);
    // Méthode permettant de supprimer un élément de la base de données
    public function delete(String $psKey);
}
