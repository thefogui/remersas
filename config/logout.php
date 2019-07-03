
<?php
session_start();

 $AgentID = $_GET['AgentID'];

  include('conexion_halbrand.php');
$sql = "UPDATE admin_users SET Loggejat = 0 WHERE ID ='$AgentID'";
$conn->query($sql);

unset($_SESSION['Nom']);
session_unset();
session_destroy();
setcookie("halbrand_user", $name, time() - 86400, "/"); 
$conn->close();

echo "<script language=Javascript> location.href=\"../index.php\"; </script>";
?>
