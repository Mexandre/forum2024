<?php
session_start();
session_unset();
// Supprimer le cookie de connexion persistante
setcookie('forum_user_token', '', time() - 3600, '/');

header('location:index.php');
?>