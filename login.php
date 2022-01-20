<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion utilisateur</title>

    <!-- Lien CSS -->
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
</head>

<main id="login">
    <h1>Bienvenue</h1>

    <section>
        <h2>Se connecter</h2>

        <form action="app/connectUser.php" method="POST">
            <?php session_start();
            if (isset($_SESSION["error"])) : ?>
                <div class="errorMessage">
                    <p>Erreur d'identifiants, veuillez réessayer.</p>
                </div>
            <?php unset($_SESSION["error"]);
            endif ?>

            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input name="username" type="text" minlength="4" maxlength="12" required />
            </div>

            <div>
                <label for="password">Mot de passe :</label>
                <input name="password" type="password" minlength="4" minlength="12" required />
            </div>

            <button type="submit">Se connecter</button>
        </form>
        <a href="createUser.php">Créer un compte</a>
    </section>

    <p class="versionning">PersonnaToolsSite v1.0</p>
</main>

<!-- All Script -->
<script src="https://kit.fontawesome.com/5bd0b90a1c.js" crossorigin="anonymous"></script>
</body>

</html>