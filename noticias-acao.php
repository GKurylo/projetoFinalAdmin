<?php include('conexao.php');

$id = $_POST["txtId"];
$titulo = $_POST["txtTitulo"]; 
$resumo = $_POST["txtResumo"];
$texto = $_POST["txtTexto"];
$imagem = $_POST["txtImagem"];
$status = $_POST["txtStatus"];

if (!$titulo) {
    echo "<script>alert('Campo Titulo Obrigatório!'); history.back();</script>";
    exit;
}else {
    if (!$resumo) {
    echo "<script>alert('Campo Resumo Obrigatório!'); history.back();</script>";
    exit;
}else {
    if (!$texto) {
    echo "<script>alert('Campo Texto Obrigatório!'); history.back();</script>";
    exit;
}else {
    if (!$imagem) {
    echo "<script>alert('Campo Imagem Obrigatório!'); history.back();</script>";
    exit;
}else {

if(!$id){   
    //inserir
    $sql=$conn->prepare("
    insert into noticias set titulo='$titulo',
                             resumo='$resumo',
                             texto='$texto',
                             imagem='$imagem',
                             status='$status'           
    ");
    $sql->execute();
}else{
    //atualizar
    $sql=$conn->prepare("
    update noticias set titulo='$titulo',
                        resumo='$resumo',
                        texto='$texto',
                        imagem='$imagem',
                        status='$status' where id='$id'
    ");
    $sql->execute();
}
}}}}
header("location: noticias-cadastro.php");

?>