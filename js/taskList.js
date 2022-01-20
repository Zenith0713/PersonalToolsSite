// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const addTaskForm = document.querySelector("form[name='addTask']");
const taskNameInput = addTaskForm.querySelector("input");
const taskNameEmptyError = document.getElementById("emptyError");
const taskNameAlreadyTakeError = document.getElementById("alreadyTakeError");
const taskSection = document.querySelector("main section:nth-of-type(2) div");
const noTaskMessage = taskSection.querySelector(".noTaskMessage");
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
    taskNameAlreadyTakeError.classList.add("hide");
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
    deleteTask(tasksArticle);
  });

  addElementButton.addEventListener("click", function () {
    addElementTask(tasksArticle);
  });

  for (let i = 0; i < taskElementDeleteButtons.length; i++) {
    taskElementDeleteButtons[i].addEventListener("click", function () {
      const elementId = this.getAttribute("data-element");
      deleteElementTask(tasksArticle, elementId);
    });

    taskElementUpdateButtons[i].addEventListener("click", function () {
      const elementId = this.getAttribute("data-element");
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
      if (data) {
        taskNameAlreadyTakeError.classList.remove("hide");
      } else {
        noTaskMessage.classList.add("hide");
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
      const deleteTask = true;
      tasksArticle.classList.add("hide");
      verifyTaskListContent(deleteTask);
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant d'afficher la nouvelle tâche qui a été ajouté
async function showNewTask(taskName) {
  const article = document.createElement("article");
  const div = document.createElement("div");
  const h4 = document.createElement("h4");
  const options = await setTaskCategoriesOptions();
  const taskDeleteHtml =
    "<span class='deleteButton'><i class='fas fa-trash'></i></span>";
  const taskCategoryHtml = `<div><label>Catégories : </label><select>${options}</select></div>`;
  const taskAddTaskHtml =
    "<ul></ul><div><input name='addElementTask' type='text' placeholder='Nouvel élément'/> <button class='addElementButton' type='button'>Ajouter</button></div>";

  h4.textContent = taskName;
  div.prepend(h4);
  div.innerHTML += taskDeleteHtml;
  article.prepend(div);
  article.innerHTML += taskCategoryHtml + taskAddTaskHtml;
  taskSection.prepend(article);

  setTasksEventListener(article);
}

// Fonction permettant définir la valeur de résolution de la promesse qui correspond
// aux catégories existantes dans des balises "<option>"
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
        let selected;

        for (let i = 0; i < data.length; i++) {
          selected = "";

          if (data[i]["categoryId"] === "1") {
            selected = "selected";
          }

          options += `<option value='${data[i]["categoryId"]}' ${selected}>${data[i]["categoryName"]}</option>`;
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

// Fonction permettant d'ajouter un nouvel élément à une tâche spécifique
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

    fetch("ajax/taskListManagement.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
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

// Fonction permettant d'afficher l'élément créé
function showElementTask(tasksArticle, elementName, elementId) {
  const elementsTaskList = tasksArticle.querySelector("ul");
  const li = document.createElement("li");
  const p = document.createElement("p");
  const elementTaskInputValueHtml = `<form class='hide'><input name='${elementId}' type='text' value='${elementName}'/></form>`;
  const elementTaskButtonsHtml = `<span class='updateElement' data-element='${elementId}'><i class='fas fa-edit'></i></span><span class='deleteElement' data-element='${elementId}'><i class='fas fa-trash'></i></span>`;

  p.textContent = elementName;
  li.append(p);
  li.innerHTML += elementTaskInputValueHtml + elementTaskButtonsHtml;

  elementsTaskList.prepend(li);

  setElementTaskEventListener(li, tasksArticle);
}

// Fonction permettant de supprimer un élément d'une tâche
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

// Fonction permettant de changer le type de la balise contenant l'élément pour permettre
// l'utilisateur de changer celui-ci
function setInputChangeOnElementTask(tasksArticle, elementId) {
  const elementTaskButtons = tasksArticle.querySelectorAll(".updateElement");
  let li;

  for (let i = 0; i < elementTaskButtons.length; i++) {
    if (elementTaskButtons[i].getAttribute("data-element") === elementId) {
      li = elementTaskButtons[i].parentNode;
    }
  }

  const elementTextp = li.querySelector("p:first-of-type");
  const elementForm = li.querySelector("form");
  const elementInput = elementForm.querySelector("input");

  elementTextp.classList.add("hide");
  elementForm.classList.remove("hide");

  elementInput.focus();
}

// Fonction permettant de modifier un élément d'une tâche
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
          const elementTextp = li.querySelector("p:first-of-type");
          const elementForm = li.querySelector("form");

          elementTextp.textContent = " " + elementValue;
          elementTextp.classList.remove("hide");
          elementForm.classList.add("hide");
        }
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant de définir les événements d'un nouvel élément
function setElementTaskEventListener(li, tasksArticle) {
  const taskElementDeleteButton = li.querySelector(".deleteElement");
  const taskElementUpdateButton = li.querySelector(".updateElement");
  const taskElementForm = li.querySelector("form");

  taskElementDeleteButton.addEventListener("click", function () {
    const elementId = this.getAttribute("data-element");

    deleteElementTask(tasksArticle, elementId);
  });

  taskElementUpdateButton.addEventListener("click", function () {
    const elementId = this.getAttribute("data-element");

    setInputChangeOnElementTask(tasksArticle, elementId);
  });

  taskElementForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const taskElement = this.elements[0];

    updateElementTask(tasksArticle, taskElement.value, taskElement.name);
  });
}

// Fonction permettant de vérifier les tâches existantes et d'afficher un message
// si il n'y a aucune tâche
function verifyTaskListContent(deleteTask = false) {
  const allTasks = taskSection.querySelectorAll("article");
  const allTasksHide = taskSection.querySelectorAll("article.hide");

  if (
    allTasks.length === 0 ||
    (allTasks.length === allTasksHide.length && deleteTask)
  ) {
    noTaskMessage.classList.remove("hide");
  } else {
    noTaskMessage.classList.add("hide");
  }
}

// Initialisation des fonctions verifyTaskListContent et setAllEventListener ainsi que l'ajout de l'eventListener qui
// permet de lancer la fonction lorsque toute la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  // Changement du titre de la page
  document.title = "To-Do list";
  verifyTaskListContent();
  setAllEventListener();
});
