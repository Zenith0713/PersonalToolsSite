<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création utilisateur</title>

    <!-- Lien CSS -->
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
</head>

<main id="createUser">
    <section>
        <h2>Création d'un utilisateur</h2>

        <?php session_start();
        if (isset($_SESSION["error"])) : ?>
            <div class="errorMessage">
                <p>Ce nom d'utilisateur est déjà pris, veuillez réessayer.</p>
            </div>
        <?php unset($_SESSION["error"]);
        endif ?>

        <form action="app/createUser.php" method="POST">

            <p class="inputError hide">Les mots de passe ne sont pas identiques, veuillez réessayer.</p>

            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input name="username" type="text" minlength="4" minlength="12" required />
            </div>

            <div>
                <label for="password">Mot de passe :</label>
                <input name="password" type="password" minlength="4" minlength="12" required />
            </div>

            <div>
                <label for="confirmPassword">Confirmer le mot de passe :</label>
                <input name="confirmPassword" type="password" minlength="4" minlength="12" required />
            </div>

            <div>
                <button type="reset">Annuler</button>
                <button type="submit">Se connecter</button>
            </div>
        </form>

        <a href="login.php">Retour</a>
    </section>
</main>

<!-- All Script -->
<script src="js/createUser.js"></script>
<script src="https://kit.fontawesome.com/5bd0b90a1c.js" crossorigin="anonymous"></script>
</body>

</html>