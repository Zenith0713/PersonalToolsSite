// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskNameEmptyError = document.getElementById("emptyError");
const taskNamealreadyTakeError = document.getElementById("alreadyTakeError");
const taskSection = document.querySelector("main section:nth-of-type(2) div");
let taskSelectCategory = taskSection.querySelectorAll("article select");

// Fonction permettant de définir tous les événements de la page
function setAllEventListener() {
  setTasksEventListener();

  addTaskForm.addEventListener("submit", (event) => {
    event.preventDefault();
    if (taskNameInput.value === "") {
      taskNameEmptyError.classList.remove("hide");
    } else {
      taskNameEmptyError.classList.add("hide");
      addTask();
    }
  });

  addTaskForm.addEventListener("keyup", () => {
    taskNamealreadyTakeError.classList.add("hide");
    taskNameEmptyError.classList.add("hide");
  });
}

// Fonction permettant de définir tous les événements concernant les tâches
function setTasksEventListener() {
  let tasksForms = taskSection.querySelectorAll("form");
  let tasksSelectCategories = taskSection.querySelectorAll("article select");
  let tasksDeleteButtons = taskSection.querySelectorAll(
    "article .deleteButton"
  );
  let addElementButtons = taskSection.querySelectorAll(
    "article .addElementButton"
  );

  for (let i = 0; i < tasksSelectCategories.length; i++) {
    tasksSelectCategories[i].addEventListener("change", function () {
      changeTaskCategory(tasksForms[i], this);
    });

    tasksDeleteButtons[i].addEventListener("click", function () {
      console.log("Delete task !");
      deleteTask(tasksForms[i]);
    });

    addElementButtons[i].addEventListener("click", function () {
      console.log("Add element !");

      addElementTask(tasksForms[i]);
    });
  }
}

// Fonction permettant d'ajouter une nouvelle tâche dans la base de données
function addTask() {
  console.log("Ajouter une tâche");

  let formData = new FormData();
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
        taskNamealreadyTakeError.classList.remove("hide");
      } else {
        showNewTask(taskNameInput.value);
        taskNameInput.value = "";
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

function deleteTask(taskForm) {
  console.log("Supprimer une tâche");
  const taskName = taskForm.querySelector("h4").textContent;
  let formData = new FormData();

  formData.append("action", "remove");
  formData.append("element", "task");
  formData.append("taskName", taskName);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      taskForm.classList.add("hide");
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant d'afficher la nouvelle tâche qui a été ajouté
async function showNewTask(taskName) {
  const article = document.createElement("article");
  const options = await setTaskCategoriesOptions();
  const taskStartHtml = `<form method='POST' name='taskName' action='#'><h4>"${taskName}</h4><span class='deleteButton'>X</span>`;
  const taskCategoryHtml = `<div><label>Catégories </label><select>${options}</select></div>`;
  const taskAddTaskHtml =
    "<ul><li><input name='addTask' type='checkbox' value='1'/><label>Ajouter un élément</label></li></ul><button type='button'>Ajouter un élément</button>";
  const taskEndHtml = "</form>";

  article.innerHTML +=
    taskStartHtml + taskCategoryHtml + taskAddTaskHtml + taskEndHtml;
  taskSection.prepend(article);
  setTasksEventListener();
}

// Fonction permettant
function setTaskCategoriesOptions() {
  let formData = new FormData();

  formData.append("action", "selectAll");
  formData.append("element", "taskCategory");
  return new Promise((resolve) => {
    fetch("ajax/taskListManagement.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        let options = "";

        for (let i = 0; i < data.length; i++) {
          options += `<option value='${data[i]["categoryId"]}'>${data[i]["categoryName"]}</option>`;
        }

        resolve(options);
      })
      .catch((error) => {
        return console.error(error);
      });
  });
}

// Fonction permettant
function changeTaskCategory(taskForm, selectCategory) {
  const taskName = taskForm.querySelector("h4").textContent;
  const selectValue = selectCategory.value;
  let formData = new FormData();

  formData.append("action", "update");
  formData.append("element", "task");
  formData.append("taskName", taskName);
  formData.append("taskCategory", selectValue);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  }).catch((error) => {
    return console.error(error);
  });
}

// Fonction permettant
function addElementTask(taskForm) {
  const elementTaskInput = taskForm.querySelector(
    "input[name='addElementTask']"
  );
  const taskName = taskForm.querySelector("h4").textContent;
  let formData = new FormData();

  formData.append("action", "add");
  formData.append("element", "taskElement");
  formData.append("elementName", elementTaskInput.value);
  formData.append("elementTask", taskName);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      showElementTask(taskForm, elementTaskInput.value);
      elementTaskInput.value = "";
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant
function showElementTask(taskForm, elementName) {
  const elementsTaskList = taskForm.querySelector("ul");
  const li = document.createElement("li");

  const elementTaskStartHtml = `<input name='taskCompleted' type='checkbox' value='1'/><label>${elementName}</label>`;
  const elementTaskEndHtml = `<input name='element1' type='text' class='hide' value='${elementName}'/><label class='hide'>V</label><label>X</label>`;

  li.innerHTML += elementTaskStartHtml + elementTaskEndHtml;
  elementsTaskList.prepend(li);
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
