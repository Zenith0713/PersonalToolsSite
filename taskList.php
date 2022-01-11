<?php

include("includes/header.php");
include("app/showAllTasks.php");

?>

<main id="taskList">
    <!-- Tâches effectués ou non -->
    <!-- Ajouter/modifier/supprimer une tâche, attribuer un nom à cette tâche -->
    <!-- Ajouter/modifier/supprimer une catégorie, faire une catégorie neutre/aucune -->
    <!-- Ajouter/modifier/supprimer un élément -->
    <!-- Trier par  -->


    <!-- tâches avec nom, nom catégorie, couleur catégorie, liste d'éléments -->
    <!-- Dans cette tâche : changer de nom (ou non), possibilité de changer de catégorie, ajouter/modifier/supprimer
    un élément, supprimer la tâche (popup confirmation) -->


    <!-- Rendu dynamique -->
    <!-- Design simple et intuitif -->

    <a href="categoriesManagement.php">Gestion des catégories</a>

    <section>
        <!-- Choisir nom du groupe et catégories -->
        <h2>Ajouter une tâche</h2>

        <!-- <article>
            <h4>Recherche</h4>
            <p>Fonction de trie par catégories, recherches de nom de tâches, etc...</p>
        </article> -->

        <form name="addTask">
            <div>
                <div id="emptyError" class="hide inputError">Veuillez remplir le champ</div>
                <div id="alreadyTakeError" class="hide inputError">Ce nom est déjà utilisé !</div>
                <label for="newTask">Nom de la tâche :</label>
                <input id="newTask" name="newTask" type="text" placeholder="Nouvelle tâche" />
            </div>

            <button type="submit">Ajouter</button>
        </form>

    </section>

    <!-- Ici on peut retrouver toutes les tâches -->
    <section>
        <h2>Liste des tâches</h2>
        <!-- Un groupe de tâche -->
        <div>
            <?php echo $sAllTasksArticles ?>

            <!-- <article>
                <form method="POST" name="taskName" action="#">
                    <h4>Nom de la tâche</h4>

                    -- Permettant de supprimer la tâche --
                    <span>X</span>

                    <div>
                        <label>Catégories</label>
                        <select>
                            Couleur catégorie en fond
                            <option value="">Aucune</option>
                            <option value="">Maison</option>
                        </select>
                    </div>

                    -- Liste des éléments --
                    <ul>
                        <li><input name="task1" type="checkbox" value="1" /><label>Mon premier élément</label></li> -- Ne pas mettre label -> contenu modifiable --
                        <li><input name="task2" type="checkbox" value="1" /><label>Mon deuxième élément</label></li> -- Icon permettant de supprimer --
                        <li><input name="task3" type="checkbox" value="1" /><label>Mon troisième élément</label></li>
                        <li><input name="addTask" type="checkbox" value="1" /><label>Ajouter un élément</label></li> -- Choisir cette méthode ou cette du bouton pour add --
                    </ul>

                    <button type="button">Ajouter un élément</button>

                    -- boutons permettant de mettre la tâche en complété ou non --
                    <button type="button">Complété</button>
                </form>
            </article> -->
        </div>
    </section>
</main>

<!-- All Script -->
<script src="js/taskList.js"></script>
<?php include("includes/footer.php"); ?>