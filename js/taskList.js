// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskNameEmptyError = document.getElementById("emptyError");
const taskNamealreadyTakeError = document.getElementById("alreadyTakeError");
const taskSection = document.querySelector("main section:nth-of-type(2) div");
const taskSelectCategory = taskSection.querySelectorAll("article select");

// Fonction permettant de définir tous les événements de la page
function setAllEventListener() {
  const tasksForms = taskSection.querySelectorAll("form");

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

  for (let i = 0; i < tasksForms.length; i++) {
    setTasksEventListener(tasksForms[i]);
  }
}

// Fonction permettant de définir tous les événements concernant les tâches
function setTasksEventListener(taskForm) {
  const taskSelectCategories = taskForm.querySelector("select");
  const taskDeleteButton = taskForm.querySelector(".deleteButton");
  const addElementButton = taskForm.querySelector(".addElementButton");
  const taskElementDeleteButtons =
    taskSection.querySelectorAll(".deleteElement");

  taskSelectCategories.addEventListener("change", function () {
    changeTaskCategory(taskForm, this);
  });

  taskDeleteButton.addEventListener("click", function () {
    console.log("Delete task !");
    deleteTask(taskForm);
  });

  addElementButton.addEventListener("click", function () {
    console.log("Add element !");

    addElementTask(taskForm);
  });

  for (let i = 0; i < taskElementDeleteButtons.length; i++) {
    taskElementDeleteButtons[i].addEventListener("click", function () {
      const elementId = this.getAttribute("data-element");
      console.log("Delete elementTask !");

      deleteElementTask(taskForm, elementId);
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

// Fonction permettant de supprimer une tâche
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
  const taskStartHtml = `<form method='POST' name='${taskName}Form' action='#'><h4>${taskName}</h4><span class='deleteButton'>X</span>`;
  const taskCategoryHtml = `<div><label>Catégories </label><select>${options}</select></div>`;
  const taskAddTaskHtml =
    "<ul></ul><div><input name='addElementTask' type='text' /><button class='addElementButton' type='button'>Ajouter un élément</button></div>";
  const taskEndHtml = "</form>";

  article.innerHTML +=
    taskStartHtml + taskCategoryHtml + taskAddTaskHtml + taskEndHtml;
  taskSection.prepend(article);

  const taskForm = article.querySelector("form");
  setTasksEventListener(taskForm);
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

// Fonction permettant de changer la catégorie d'une tâche
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

// Fonction permettant d'ajouter le nouvel élément d'une tâche
function addElementTask(taskForm) {
  const elementTaskInput = taskForm.querySelector(
    "input[name='addElementTask']"
  );
  const taskName = taskForm.querySelector("h4").textContent;
  let formData = new FormData();

  if (elementTaskInput.value !== "") {
    formData.append("action", "add");
    formData.append("element", "taskElement");
    formData.append("elementName", elementTaskInput.value);
    formData.append("elementTask", taskName);

    console.log("test");
    fetch("ajax/taskListManagement.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        showElementTask(taskForm, data[0]);
        elementTaskInput.value = "";
      })
      .catch((error) => {
        return console.error(error);
      });
  }
}

// Fonction permettant d'afficher l'élément d'une tâche
function showElementTask(taskForm, elementValues) {
  console.log("show element");
  const elementsTaskList = taskForm.querySelector("ul");
  const li = document.createElement("li");
  const elementTaskStartHtml = `<input name='taskCompleted' type='checkbox' value='1'/><label> ${elementValues.elementName}</label>`;
  const elementTaskEndHtml = `<input name='element1' type='text' class='hide' value='${elementValues.elementName}'/><label class='hide'>V</label>`;
  const elementTaskDeleteButtonHtml = `<label class='deleteElement' data-element='${elementValues.elementId}'> X</label>`;

  li.innerHTML +=
    elementTaskStartHtml + elementTaskEndHtml + elementTaskDeleteButtonHtml;
  elementsTaskList.prepend(li);

  const taskElementDeleteButton = li.querySelector(".deleteElement");

  taskElementDeleteButton.addEventListener("click", function () {
    const elementId = this.getAttribute("data-element");
    console.log("Delete elementTask !");

    deleteElementTask(taskForm, elementId);
  });
}

// Fonction permettant de supprimer l'élement d'une tâche
function deleteElementTask(taskForm, elementId) {
  const taskName = taskForm.querySelector("h4").textContent;
  const elementTaskButtons = taskForm.querySelectorAll(".deleteElement");
  let formData = new FormData();

  formData.append("action", "remove");
  formData.append("element", "taskElement");
  formData.append("elementTask", taskName);
  formData.append("elementId", elementId);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      for (let i = 0; i < elementTaskButtons.length; i++) {
        if (elementTaskButtons[i].getAttribute("data-element") === elementId) {
          elementTaskButtons[i].parentNode.classList.add("hide");
        }
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
