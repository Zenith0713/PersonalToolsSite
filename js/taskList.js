// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
// const addTaskButton = document.getElementById("addTask");
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskNameEmptyError = document.getElementById("emptyError");
const taskNamealreadyTakeError = document.getElementById("alreadyTakeError");
const taskSection = document.querySelector("main section:nth-of-type(2)");

// Fonction permettant de définir tout les événements de la page
function setAllEventListener() {
  addTaskForm.addEventListener("submit", (event) => {
    event.preventDefault();
    if (taskNameInput.value === "") {
      taskNameEmptyError.classList.remove("hidden");
    } else {
      taskNameEmptyError.classList.add("hidden");
      addTask();
    }
  });

  addTaskForm.addEventListener("keyup", () => {
    taskNamealreadyTakeError.classList.add("hidden");
    taskNameEmptyError.classList.add("hidden");
  });
}

// Fonction permettant d'ajouter une nouvelle tâche (dans la base de donnée)
function addTask() {
  console.log("Ajouter une tâche");
  var formData = new FormData();
  formData.append("action", "add");
  formData.append("element", "task");
  formData.append("taskName", taskNameInput.value);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data !== "") {
        taskNamealreadyTakeError.classList.remove("hidden");
      }
    })
    .catch((error) => {
      console.error(error);
    });
}

// * qui permet de lancer la fonction lorsque toute la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
