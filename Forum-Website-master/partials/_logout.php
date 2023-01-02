<?php
session_start();
echo "Loggin You Out......";
session_destroy();
header("Location:/forum/");

?>