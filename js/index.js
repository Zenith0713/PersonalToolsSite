// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
const hamburgerIcon = document.getElementById("hamburger-icon");
const navMenu = document.querySelector("header > nav");

// Fonction permettant d'afficher ou de cacher le menu de naviguation lors d'un clic sur l'icône "hamburger" (icône avec trois traits horizontaux superposés)
function setHamburgerIcon() {
  hamburgerIcon.addEventListener("click", () => {
    navMenu.classList.toggle("open");
  });
}

// * qui permet de lancer la fonction lorsque toute la page est bien chargée
window.addEventListener("DOMContentLoaded", function () {
  setHamburgerIcon();
});
