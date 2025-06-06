<?php include('conexao.php');

$id=$_GET['id']; 

$sql=$conn->prepare("
delete from noticias where id='$id';
");

$sql->execute();
header('location:noticias-cadastro.php');

?>