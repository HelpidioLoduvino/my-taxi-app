<?php

session_start();

// Limpar todos os dados de sessão
$_SESSION = array();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login
header('Location: ../view/LoginView.php');
exit;

