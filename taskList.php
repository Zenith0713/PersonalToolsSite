<?php

include("includes/header.php");
include("app/showAllTasks.php");

?>

<main id="taskList">
    <a href="categoriesManagement.php">Gestion des catégories</a>

    <section>
        <h2>Ajouter une tâche</h2>

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

    <section>
        <h2>Liste des tâches</h2>
        <div>
            <h3 class="noTaskMessage hide">Aucune tâche</h3>
            <?php echo $sAllTasksArticles ?>

        </div>
    </section>
</main>

<!-- All Script -->
<script src="js/taskList.js"></script>
<?php include("includes/footer.php"); ?>