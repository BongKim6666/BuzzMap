<?php

session_start();

unset($_SESSION['user']);
setcookie('userId', '', -1, '/');

header('Location: ../index.php');
