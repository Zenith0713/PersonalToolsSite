// Script entier en mode strict
"use strict";

// Définition des constantes et des variables
class AnimeList {
  constructor(userName) {
    this.userName = userName;
  }

  showAnimeView() {
    fetch(`https://api.jikan.moe/v3/user/${this.userName}/animelist`)
      .then(function (response) {
        return response.json();
      })
      .then(function (content) {
        for (var i = 0; i < content["anime"].length; i++) {
          if (content["anime"][i]["watching_status"] === 6) {
            console.log(content["anime"][i]["title"]);
          }
        }
        console.log(content["anime"]);
      })
      .catch(function (error) {
        return console.error(error);
      });
  }
}

let animeList = new AnimeList("Zenith0713");
animeList.showAnimeView();

// Base = https://api.jikan.moe/v3/

// User :
// user/[username]/animelist/ plantowatch, watching, completed, all
// watching_statut : 6(planToWatch), 1(watching), 2(completed)
