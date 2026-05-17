<?php
// Connexion à la base de données
$servername = "localhost"; // Nom de l'hôte de la base de données
$username = "root";        // Nom d'utilisateur de la base de données
$password = "";            // Mot de passe de la base de données
$dbname = "timer";    // Nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $mail = $_POST['mail'];
    $motdepasse = $_POST['motdepasse'];

    // Préparer et exécuter la requête pour récupérer l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE mail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mail); // "s" signifie que c'est une chaîne (string)
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Vérifier le mot de passe avec password_verify()
        if (password_verify($motdepasse, $user['motdepasse'])) {
            // Connexion réussie
            echo "Bienvenue, " . $user['prenom'] . "!";
            // Vous pouvez ici démarrer une session et rediriger l'utilisateur
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['mail'] = $user['mail'];

            // Redirection vers la page d'accueil ou autre page après connexion
            header("Location: accueil.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/projet-timer-js/assets/co.css">    <title>Connexion</title>
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
        <li class="nav-item">
          <a class="nav-link" href="../php/connexion.php" style="color: white;">Connexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>





<h2>Connexion</h2>
    <form action="" method="POST">
        <label for="mail">Email:</label><br>
        <input type="email" id="mail" name="mail" required><br><br>

        <label for="motdepasse">Mot de passe:</label><br>
        <input type="password" id="motdepasse" name="motdepasse" required><br><br>

        <input type="submit" value="Se connecter">
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>