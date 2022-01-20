// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const addCategoryForm = document.querySelector("form[name='addCategory']");
const categoryNameInput = addCategoryForm.querySelector("input");
const categoryNameEmptyError = document.getElementById("emptyError");
const categoryNameAlreadyTakeError =
  document.getElementById("alreadyTakeError");
const categoryList = document.querySelector("main ul");
const addErrorMessage = document.querySelector("main > .errorMessage");
const deleteErrorMessage = document.querySelector("main > .errorMessage");

// Fonction permettant de définir tous les événements de la page
function setAllEventListener() {
  const categoriesLi = categoryList.querySelectorAll("li");

  addCategoryForm.addEventListener("submit", (event) => {
    event.preventDefault();
    if (categoryNameInput.value === "") {
      categoryNameEmptyError.classList.remove("hide");
    } else {
      categoryNameEmptyError.classList.add("hide");
      addCategory();
    }
  });

  addCategoryForm.addEventListener("keyup", () => {
    deleteErrorMessage.classList.add("hide");
    categoryNameAlreadyTakeError.classList.add("hide");
    categoryNameEmptyError.classList.add("hide");
  });

  for (let i = 0; i < categoriesLi.length; i++) {
    setCategoriesEventListener(categoriesLi[i]);
  }
}

// Fonction permettant d'ajouter une nouvelle catégorie dans la base de données
function addCategory() {
  let formData = new FormData();
  formData.append("action", "add");
  formData.append("element", "taskCategory");
  formData.append("categoryName", categoryNameInput.value);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data[0]);
      if (data[0] === true) {
        categoryNameAlreadyTakeError.classList.remove("hide");
      } else {
        showNewCategory(data[0]["LAST_INSERT_ID()"], categoryNameInput.value);
        categoryNameInput.value = "";
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant d'afficher la nouvelle catégorie qui a été ajouté
function showNewCategory(categoryId, categoryName) {
  const li = document.createElement("li");
  const p = document.createElement("p");
  const category = `<form class='hide'><input value='${categoryName}' type='text' /></form>`;
  const buttons =
    "<span class='updateCategory'><i class='fas fa-edit'></i></span><span class='deleteCategory'><i class='fas fa-trash'></i></span>";

  p.textContent = categoryName;
  li.append(p);
  li.setAttribute("data-categoryId", categoryId);
  li.innerHTML += category + buttons;

  categoryList.prepend(li);
  setCategoriesEventListener(li);
}

// Fonction permettant de supprimer une catégorie
function deleteCategory(categoryLi, categoryId) {
  let formData = new FormData();

  formData.append("action", "remove");
  formData.append("element", "taskCategory");
  formData.append("categoryId", categoryId);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data === "Error") {
        deleteErrorMessage.classList.remove("hide");
      } else {
        categoryLi.classList.add("hide");
      }
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant de modifier une catégorie
function updateCategory(formCategory, pCategory, categoryId) {
  const categoryName = formCategory.querySelector("input").value;
  let formData = new FormData();

  formData.append("action", "update");
  formData.append("element", "taskCategory");
  formData.append("categoryId", categoryId);
  formData.append("categoryName", categoryName);

  fetch("ajax/taskListManagement.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      pCategory.textContent = " " + categoryName;
      pCategory.classList.remove("hide");
      formCategory.classList.add("hide");
    })
    .catch((error) => {
      return console.error(error);
    });
}

// Fonction permettant de définir tous les événements concernant les catégories
function setCategoriesEventListener(categoryLi) {
  const categoryDeleteButton = categoryLi.querySelector(".deleteCategory");
  const categoryUpdateButton = categoryLi.querySelector(".updateCategory");
  const categoryId = categoryLi.getAttribute("data-categoryId");
  const formCategory = categoryLi.querySelector("form");
  const pCategory = categoryLi.querySelector("p");

  categoryDeleteButton.addEventListener("click", function () {
    deleteErrorMessage.classList.add("hide");
    deleteCategory(categoryLi, categoryId);
  });

  categoryUpdateButton.addEventListener("click", function () {
    deleteErrorMessage.classList.add("hide");
    formCategory.classList.remove("hide");
    pCategory.classList.add("hide");
  });

  formCategory.addEventListener("submit", function (event) {
    event.preventDefault();
    updateCategory(formCategory, pCategory, categoryId);
  });
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  // Changement du titre de la page
  document.title = "Gestion des catégories";
  setAllEventListener();
});
