<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// Récupérer tous les utilisateurs
$stmt = $pdo->query("SELECT * FROM utilisateurs ORDER BY id ASC");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'assets/header.php'; ?>

<title>Administration - Module de Connexion</title>

<div class="container-large">
    <h2>Panneau d'administration</h2>
    <p style="text-align: center; margin-bottom: 20px;">Liste de tous les utilisateurs inscrits</p>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mot de passe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
                    <td><?php echo htmlspecialchars($utilisateur['login']); ?></td>
                    <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                    <td><?php echo htmlspecialchars($utilisateur['password']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="link">
        <a href="index.php">Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
