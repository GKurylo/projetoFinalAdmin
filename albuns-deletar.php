<?php 
include('conexao.php');
include("login-validar.php");

$id=$_GET['id']; 

$sql=$conn->prepare("
delete from albuns where id='$id';
");

$sql->execute();
header('location:albuns-cadastro.php');

?>