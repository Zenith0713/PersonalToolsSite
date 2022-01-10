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
  const tasksArticle = taskSection.querySelectorAll("article");

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

  for (let i = 0; i < tasksArticle.length; i++) {
    setTasksEventListener(tasksArticle[i]);
  }
}

// Fonction permettant de définir tous les événements concernant les tâches
function setTasksEventListener(tasksArticle) {
  const taskSelectCategories = tasksArticle.querySelector("select");
  const taskDeleteButton = tasksArticle.querySelector(".deleteButton");
  const addElementButton = tasksArticle.querySelector(".addElementButton");
  const taskElementDeleteButtons =
    tasksArticle.querySelectorAll(".deleteElement");
  const taskElementUpdateButtons =
    tasksArticle.querySelectorAll(".updateElement");
  const taskElementForms = tasksArticle.querySelectorAll("form");

  taskSelectCategories.addEventListener("change", function () {
    changeTaskCategory(tasksArticle, this);
  });

  taskDeleteButton.addEventListener("click", function () {
    console.log("Delete task !");
    deleteTask(tasksArticle);
  });

  addElementButton.addEventListener("click", function () {
    console.log("Add element !");

    addElementTask(tasksArticle);
  });

  for (let i = 0; i < taskElementDeleteButtons.length; i++) {
    taskElementDeleteButtons[i].addEventListener("click", function () {
      const elementId = this.getAttribute("data-element");
      console.log("Delete elementTask !");

      deleteElementTask(tasksArticle, elementId);
    });

    taskElementUpdateButtons[i].addEventListener("click", function () {
      const elementId = this.getAttribute("data-element");
      console.log("Update elementTask !");

      setInputChangeOnElementTask(tasksArticle, elementId);
    });

    taskElementForms[i].addEventListener("submit", function (event) {
      event.preventDefault();
      const taskElement = this.elements[0];

      updateElementTask(tasksArticle, taskElement.value, taskElement.name);
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
function deleteTask(tasksArticle) {
  console.log("Supprimer une tâche");
  const taskName = tasksArticle.querySelector("h4").textContent;
  let formData = new FormData();

  formData.append("action", "remove");
  formData.append("element", "task");
  formData.append("taskName", taskName);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      tasksArticle.classList.add("hide");
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

  setTasksEventListener(article);
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
function changeTaskCategory(tasksArticle, selectCategory) {
  const taskName = tasksArticle.querySelector("h4").textContent;
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
function addElementTask(tasksArticle) {
  const elementTaskInput = tasksArticle.querySelector(
    "input[name='addElementTask']"
  );
  const taskName = tasksArticle.querySelector("h4").textContent;
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
        console.log(data);
        showElementTask(
          tasksArticle,
          elementTaskInput.value,
          data[0]["LAST_INSERT_ID()"]
        );
        elementTaskInput.value = "";
      })
      .catch((error) => {
        return console.error(error);
      });
  }
}

// Fonction permettant d'afficher l'élément d'une tâche
function showElementTask(tasksArticle, elementName, elementId) {
  console.log("show element");
  const elementsTaskList = tasksArticle.querySelector("ul");
  const li = document.createElement("li");
  const elementTaskStartHtml = `<input name='taskCompleted' type='checkbox' value='1'/><label> ${elementName}</label>`;
  const elementTaskInputValueHtml = `<form class='hide'><input name='${elementId}' type='text' value='${elementName}'/></form>`;
  const elementTaskButtonsHtml = `<label class='updateElement' data-element='${elementId}'> V</label><label class='deleteElement' data-element='${elementId}'> X</label>`;

  li.innerHTML +=
    elementTaskStartHtml + elementTaskInputValueHtml + elementTaskButtonsHtml;
  elementsTaskList.prepend(li);

  setElementTaskEventListener(li, tasksArticle);
}

// Fonction permettant de supprimer l'élement d'une tâche
function deleteElementTask(tasksArticle, elementId) {
  const taskName = tasksArticle.querySelector("h4").textContent;
  const elementTaskButtons = tasksArticle.querySelectorAll(".deleteElement");
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

// Fonction permettant de changer le type de la balise contenant l'élément pour permettre )
// l'utilisateur de changer celui ci
function setInputChangeOnElementTask(tasksArticle, elementId) {
  const taskName = tasksArticle.querySelector("h4").textContent;
  const elementTaskButtons = tasksArticle.querySelectorAll(".updateElement");
  let li;

  for (let i = 0; i < elementTaskButtons.length; i++) {
    if (elementTaskButtons[i].getAttribute("data-element") === elementId) {
      li = elementTaskButtons[i].parentNode;
    }
  }

  const elementTextLabel = li.querySelector("label:first-of-type");
  const elementForm = li.querySelector("form");

  elementTextLabel.classList.add("hide");
  elementForm.classList.remove("hide");
}

// Fonction permettant de supprimer l'élement d'une tâche
function updateElementTask(tasksArticle, elementValue, elementId) {
  const elementTaskButtons = tasksArticle.querySelectorAll(".updateElement");
  let formData = new FormData();

  formData.append("action", "update");
  formData.append("element", "taskElement");
  formData.append("elementId", elementId);
  formData.append("elementValue", elementValue);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      for (let i = 0; i < elementTaskButtons.length; i++) {
        if (elementTaskButtons[i].getAttribute("data-element") === elementId) {
          const li = elementTaskButtons[i].parentNode;
          const elementTextLabel = li.querySelector("label:first-of-type");
          const elementForm = li.querySelector("form");

          elementTextLabel.textContent = " " + elementValue;
          elementTextLabel.classList.remove("hide");
          elementForm.classList.add("hide");
        }
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant de définir les événements d'un nouvel élément d'une tâche
function setElementTaskEventListener(li, tasksArticle) {
  const taskElementDeleteButton = li.querySelector(".deleteElement");
  const taskElementUpdateButton = li.querySelector(".updateElement");
  const taskElementForm = li.querySelector("form");

  taskElementDeleteButton.addEventListener("click", function () {
    const elementId = this.getAttribute("data-element");
    console.log("Delete elementTask !");

    deleteElementTask(tasksArticle, elementId);
  });

  taskElementUpdateButton.addEventListener("click", function () {
    const elementId = this.getAttribute("data-element");
    console.log("Update elementTask !");

    setInputChangeOnElementTask(tasksArticle, elementId);
  });

  taskElementForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const taskElement = this.elements[0];

    updateElementTask(tasksArticle, taskElement.value, taskElement.name);
  });
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
