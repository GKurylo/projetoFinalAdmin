<?php include('conexao.php');

$id=$_GET['id']; 

$sql=$conn->prepare("
delete from cursos where id='$id';
");

$sql->execute();
header('location:cursos-cadastro.php');

?>