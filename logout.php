<?php

session_start();

// Очистка сессии
session_unset();
session_destroy();

// Перенаправление на главную страницу
header('Location: index.php');

?>
