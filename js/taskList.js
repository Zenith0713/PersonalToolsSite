// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
// const addTaskButton = document.getElementById("addTask");
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskSection = document.querySelector("main section:nth-of-type(2)");

// Fonction permettant de définir tout les événements de la page
function setAllEventListener() {
  addTaskForm.addEventListener("submit", (event) => {
    event.preventDefault();
    addTask();
  });
}

// Fonction permettant d'ajouter une nouvelle tâche (dans la base de donnée)
function addTask() {
  console.log("Ajouter une tâche");
  // Vérifier si le nom de tâche n'existe pas déjà
  console.log(taskNameInput.value);
}

// Fonction permettant de vérifier si le nom de la tâche est déjà utilisé
function verifyTaskName() {}

// * qui permet de lancer la fonction lorsque toute la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
