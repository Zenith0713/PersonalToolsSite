// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const divInputError = document.querySelector(".inputError");
const form = document.querySelector("form");
const inputsForm = document.querySelectorAll("form input");
const passwordInput = document.querySelector("form input[name='password']");
const confirmPasswordInput = document.querySelector(
  "form input[name='confirmPassword']"
);

// Fonction permettant de définir tous les événements de la page
function setAllEventListener() {
  form.addEventListener("submit", verifyPassword);
}

// Fonction permettant de vérifier si les deux mots de passe sont identiques. Si ce n'est pas le cas,
// affiche un message d'erreur
function verifyPassword(event) {
  if (passwordInput.value !== confirmPasswordInput.value) {
    event.preventDefault();
    divInputError.classList.remove("hide");
  }
}

// Initialisation de la fonction setAllEventListener et ajout de l'eventListener qui permet de lancer la fonction lorsque toute
// la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setAllEventListener();
});
