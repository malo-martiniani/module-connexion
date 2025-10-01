<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($login) || empty($prenom) || empty($nom) || empty($password) || empty($confirm_password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier si le login existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        
        if ($stmt->fetch()) {
            $error = 'Ce login est déjà utilisé.';
        } else {
            // Insérer l'utilisateur
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$login, $prenom, $nom, $password])) {
                $success = 'Inscription réussie ! Redirection vers la page de connexion...';
                header("refresh:2;url=connexion.php");
            } else {
                $error = 'Erreur lors de l\'inscription.';
            }
        }
    }
}
?>
<?php include 'assets/header.php'; ?>

<title>Inscription - Module de Connexion</title>

<div class="container">
    <h2>Créer un compte</h2>
    
    <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn">S'inscrire</button>
    </form>
    
    <div class="link">
        <a href="connexion.php">Déjà un compte ? Se connecter</a>
    </div>
</div>

</body>
</html>
