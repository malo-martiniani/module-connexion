<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="assets/logo.png" alt="Logo">
        </div>
        <div class="nav-dropdown">
            <button class="nav-button">Menu ▼</button>
            <div class="dropdown-content">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="admin.php">Administration</a>
                    <?php endif; ?>
                    <a href="profil.php">Profil</a>
                    <a href="connexion.php?deconnexion=1">Déconnexion</a>
                <?php else: ?>
                    <a href="connexion.php">Connexion</a>
                    <a href="inscription.php">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
