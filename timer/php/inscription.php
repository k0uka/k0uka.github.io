<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root"; // Nom d'utilisateur de ta base de données
$password = ""; // Mot de passe de ta base de données
$dbname = "timer"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT); // Sécuriser le mot de passe

    // Requête d'insertion dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, mail, motdepasse) VALUES ('$nom', '$prenom', '$mail', '$motdepasse')";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    // Fermer la connexion
    $conn->close();

    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/projet-timer-js/assets/insc.css">
    <title>Formulaire d'inscription</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
          <img src="../assets/img/TyMoon__2_-removebg-preview.png" alt="Bootstrap" width="auto" height="100px">
        </a>
      </div>    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a href="../php/inscription.php" class="nav-link active" aria-current="page" style="color: white;">Inscription</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<h2>Formulaire d'inscription</h2>
    <form action="" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail" required><br><br>

        <label for="motdepasse">Mot de passe:</label>
        <input type="password" id="motdepasse" name="motdepasse" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
