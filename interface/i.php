<?php

// Interface permettant
interface i
{
    // Méthode permettant de séléctionner un élément de la base de donnée
    public function select(String $psKey): array;
    // Méthode permettant de séléctionner plusieurs éléments de la base de donnée
    public function selectAll(): array;
    // Méthode permettant d'ajouter un élément à la base de donnée
    public function add();
    // Méthode permettant de modifier les valeurs un élément de la base de donnée
    public function update(array $paValues);
    // Méthode permettant de supprimer un élément de la base de donnée
    public function remove(String $psKey);
}
