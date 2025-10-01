<?php
session_start();
?>
<?php include 'assets/header.php'; ?>

<title>Accueil - Module de Connexion</title>

<div class="container">
    <h1>Bienvenue sur notre site !</h1>
    <div class="welcome">
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Bonjour <strong><?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></strong> !</p>
            <p>Vous êtes connecté(e) avec succès.</p>
            <p>Vous pouvez consulter votre profil ou naviguer sur le site.</p>
        <?php else: ?>
            <p>Bienvenue sur notre plateforme de gestion d'utilisateurs.</p>
            <p>Ce site vous permet de créer un compte, vous connecter et gérer vos informations personnelles.</p>
            <p>Pour commencer, veuillez vous inscrire ou vous connecter.</p>
        <?php endif; ?>
    </div>
    <div class="link">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="inscription.php">Créer un compte</a> | 
            <a href="connexion.php">Se connecter</a>
        <?php else: ?>
            <a href="profil.php">Voir mon profil</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
