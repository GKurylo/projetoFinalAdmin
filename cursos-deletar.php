<?php 
include("login-validar.php");
include("conexao.php");


$id = $_GET['id'];

// Busca o nome do arquivo da imagem no banco (exemplo: "uploads/nome-da-imagem.png")
$sql = $conn->prepare("SELECT imagem FROM cursos WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$curso = $sql->fetch(PDO::FETCH_ASSOC);

// Se tiver imagem cadastrada e o arquivo existir na pasta uploads, apaga o arquivo
if ($curso && !empty($curso['imagem'])) {
    $caminhoImagem = $curso['imagem'];

    // Confirma que o caminho começa com "uploads/" só por segurança
    if (file_exists($caminhoImagem) && strpos($caminhoImagem, 'uploads/') === 0) {
        unlink($caminhoImagem);
        //echo $caminhoImagem;
    }
}

// Agora deleta o registro do banco
$sql = $conn->prepare("DELETE FROM cursos WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();

// Redireciona
header('Location: cursos-cadastro.php');
exit;
?>
