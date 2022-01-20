<?php

include("includes/header.php");
include("app/showAllCategories.php");

?>

<main id="categoriesManagement">
    <div class="errorMessage hide">
        <p>Erreur, il est impossible de supprimer la première catégorie.</p>
    </div>
    <a href="tasklist.php">Liste de tâches</a>

    <article>
        <h2>Ajouter un catégorie</h2>

        <form name="addCategory">
            <div>
                <div id="emptyError" class="hide inputError">Veuillez remplir le champ</div>
                <div id="alreadyTakeError" class="hide inputError">Ce nom est déjà utilisé !</div>
                <label for="newCategory">Nom de la catégorie :</label>
                <input id="newCategory" name="newCategory" type="text" placeholder="Nouvelle catégorie" />
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </article>

    <article>
        <h2>Gestion des catégories</h2>

        <ul>
            <?php echo $sAllCategoriesLi ?>
        </ul>
    </article>
</main>

<!-- All Script -->
<script src="js/categoriesManagement.js"></script>
<?php include("includes/footer.php"); ?>