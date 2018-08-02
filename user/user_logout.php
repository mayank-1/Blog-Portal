<?php
session_start();
session_destroy();
header("location: ../index.php");
exit();//Only exit if there is no $_SESSION["manager"] variable set. But if the variable exist then execute below
?>