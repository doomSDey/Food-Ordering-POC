<?php

session_start();
unset($_SESSION['email']);
unset($_SESSION['type']);
unset($_SESSION['index']);


header('Location:../index.php?msg=' . urlencode(base64_encode("You have been successfully logged out!")));
