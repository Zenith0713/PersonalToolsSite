// Script entier en mode strict
"use strict";

const hamburgerIcon = document.getElementById("hamburger-icon");
const navMenu = document.querySelector("header > nav");

function setHamburgerIcon() {
  hamburgerIcon.addEventListener("click", () => {
    navMenu.classList.toggle("open");
  });
}

setHamburgerIcon();
