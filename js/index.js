// Script entier en mode strict
"use strict";

const hamburgerIcon = document.getElementById("hamburger-icon");
const navMenu = document.getElementById("menu");

function setHamburgerIcon() {
  hamburgerIcon.addEventListener("click", () => {
    hamburgerIcon.classList.toggle("open");
    navMenu.classList.toggle("open");
  });
}

setHamburgerIcon();
