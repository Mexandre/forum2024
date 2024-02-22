<?php
session_start();
session_unset();
// Supprimer le cookie de connexion persistante
setcookie('remember_forum_user', '', time() - 3600, '/');
setcookie('remember_forum_key', '', time() - 3600, '/');

header('location:index.php');