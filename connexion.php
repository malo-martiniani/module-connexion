<?php
session_start();
require_once 'db.php';

// Gestion de la déconnexion
if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: connexion.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Rechercher l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $stmt->execute([$login, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['is_admin'] = ($user['login'] === 'admin');
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Login ou mot de passe incorrect.';
        }
    }
}
?>
<?php include 'assets/header.php'; ?>

<title>Connexion - Module de Connexion</title>

<div class="container">
    <h2>Se connecter</h2>
    
    <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Se connecter</button>
    </form>
    
    <div class="link">
        <a href="inscription.php">Pas encore de compte ? S'inscrire</a>
    </div>
</div>

</body>
</html>
