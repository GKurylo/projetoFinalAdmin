<?php include('conexao.php');

$id = $_POST["txtId"];
$Nome = $_POST["txtNome"]; 
$Descricao = $_POST["txtDescricao"];
$Tipo = $_POST["txtTipo"];
$imagem = $_POST["txtImagem"];
$status = $_POST["txtStatus"];

if (!$Nome) {
    echo "<script>alert('Campo Nome Obrigatório!'); history.back();</script>";
    exit;
}else {
    if (!$Descricao) {
    echo "<script>alert('Campo Descricao Obrigatório!'); history.back();</script>";
    exit;
}else {
    if (!$imagem) {
    echo "<script>alert('Campo Imagem Obrigatório!'); history.back();</script>";
    exit;
}else {
    if(!$id){   
    //inserir
    $sql=$conn->prepare("
    insert into cursos set Nome='$Nome',
                             Descricao='$Descricao',
                             Tipo='$Tipo',
                             imagem='$imagem',
                             status='$status'           
    ");
    $sql->execute();
}else{
    //atualizar
    $sql=$conn->prepare("
    update cursos set Nome='$Nome',
                        Descricao='$Descricao',
                        Tipo='$Tipo',
                        imagem='$imagem',
                        status='$status' where id='$id'
    ");
    $sql->execute();
}
}}}
header("location: cursos-cadastro.php");

?>