<?php require("conexao.php"); 
$id=$_GET['id'];
$sql = $conn->prepare("DELETE from usuarios WHERE id='$id'  ");
$sql->execute();
header("location:usuarios-pesquisar.php");
?>