// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskNameEmptyError = document.getElementById("emptyError");
const taskNamealreadyTakeError = document.getElementById("alreadyTakeError");
const taskSection = document.querySelector("main section:nth-of-type(2) div");

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

// Fonction permettant d'ajouter une nouvelle tâche dans la base de donnée
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
      } else {
        showNewTask(taskNameInput.value);
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant d'afficher la nouvelle tâche qui a été ajouté
function showNewTask(taskName) {
  const article = document.createElement("article");
  const taskStartHtml =
    "<form method='POST' name='taskName' action='#'><h4>" +
    taskName +
    "</h4><span>X</span>";
  const taskCategoryHtml =
    "<div><label>Catégories</label><select><option value=''>Aucune</option><option value=''>Maison</option></select></div>";
  const taskAddTaskHtml =
    "<ul><li><input name='addTask' type='checkbox' value='1'/><label>Ajouter un élément</label></li></ul><button type='button'>Ajouter un élément</button>";
  const taskEndHtml = "<button type='button'>Complété</button></form>";

  article.innerHTML +=
    taskStartHtml + taskCategoryHtml + taskAddTaskHtml + taskEndHtml;
  taskSection.prepend(article);
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
