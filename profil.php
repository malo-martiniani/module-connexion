<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$error = '';
$success = '';

// Récupérer les informations actuelles de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($login) || empty($prenom) || empty($nom)) {
        $error = 'Le login, prénom et nom sont obligatoires.';
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérifier si le login existe déjà (pour un autre utilisateur)
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE login = ? AND id != ?");
        $stmt->execute([$login, $_SESSION['user_id']]);
        
        if ($stmt->fetch()) {
            $error = 'Ce login est déjà utilisé par un autre utilisateur.';
        } else {
            // Mettre à jour l'utilisateur
            if (!empty($password)) {
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ?, password = ? WHERE id = ?");
                $result = $stmt->execute([$login, $prenom, $nom, $password, $_SESSION['user_id']]);
            } else {
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ? WHERE id = ?");
                $result = $stmt->execute([$login, $prenom, $nom, $_SESSION['user_id']]);
            }
            
            if ($result) {
                $success = 'Profil mis à jour avec succès !';
                $_SESSION['login'] = $login;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['nom'] = $nom;
                
                // Recharger les informations
                $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = 'Erreur lors de la mise à jour.';
            }
        }
    }
}
?>
<?php include 'assets/header.php'; ?>

<title>Profil - Module de Connexion</title>

<div class="container">
    <h2>Mon profil</h2>
    
    <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($user['login']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
            <input type="password" id="password" name="password">
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        
        <button type="submit" class="btn">Mettre à jour</button>
    </form>
    
    <div class="link">
        <a href="index.php">Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
