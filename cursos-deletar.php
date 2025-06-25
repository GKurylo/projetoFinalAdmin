<?php 
include("login-validar.php");
include("conexao.php");


$id = $_GET['id'];

// Busca o nome do arquivo da imagem no banco (exemplo: "uploads/nome-da-imagem.png")
$sql = $conn->prepare("SELECT imagem FROM cursos WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$cursos = $sql->fetch(PDO::FETCH_ASSOC);

if ($cursos && !empty($cursos['imagem'])) {
    $caminhoImagem = __DIR__ . '/uploads/' . $cursos['imagem'];

    if (file_exists($caminhoImagem)) {
        unlink($caminhoImagem);
    } else {
        echo "Arquivo não encontrado: $caminhoImagem";
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
