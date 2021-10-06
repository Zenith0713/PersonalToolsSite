<?php include("includes/header.php"); ?>

<main id="taskList">
    <h2>Liste de tâches</h2>

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

    <section>
        <!-- Choisir nom du groupe et catégories -->
        <button>Ajouter une tâche</button>

        <!-- Fonction de trie par catégories, recherches de nom de tâches, etc... -->
    </section>

    <!-- Ici on peut retrouver toutes les tâches -->
    <section>
        <!-- Un groupe de tâche -->
        <article>
            <form method="POST" action="#">
                <h4>Nom de la tâche</h4>

                <!-- Permettant de supprimer la tâche -->
                <span>X</span>

                <div>
                    <label>Catégories</label>
                    <select>
                        <!-- Couleur catégorie en fond -->
                        <option value="">Aucune</option>
                        <option value="">Maison</option>
                    </select>
                </div>

                <!-- Liste des éléments -->
                <ul>
                    <li><input name="task1" type="checkbox" value="1" /><label>Mon premier élément</label></li> <!-- Ne pas mettre label -> contenu modifiable -->
                    <li><input name="task2" type="checkbox" value="1" /><label>Mon deuxième élément</label></li> <!-- Icon permettant de supprimer -->
                    <li><input name="task3" type="checkbox" value="1" /><label>Mon troisième élément</label></li>
                    <li><input name="addTask" type="checkbox" value="1" /><label>Ajouter un élément</label></li> <!-- Choisir cette méthode ou cette du bouton pour add -->
                </ul>

                <button type="button">Ajouter un élément</button>

                <!-- boutons permettant de mettre la tâche en complété ou non  -->
                <button type="button">Complété</button>
            </form>
        </article>
    </section>


</main>

<!-- All Script -->
<script src="js/index.js"></script>
<?php include("includes/footer.php"); ?>