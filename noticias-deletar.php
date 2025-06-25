<?php include('conexao.php');
include("login-validar.php");

$id = $_GET['id'];

// Busca o nome do arquivo da imagem no banco (exemplo: "uploads/nome-da-imagem.png")
$sql = $conn->prepare("SELECT imagem FROM noticias WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();
$noticias = $sql->fetch(PDO::FETCH_ASSOC);

if ($noticias && !empty($noticias['imagem'])) {
    $caminhoImagem = __DIR__ . '/uploads/' . $noticias['imagem'];

    if (file_exists($caminhoImagem)) {
        unlink($caminhoImagem);
    } else {
        echo "Arquivo não encontrado: $caminhoImagem";
    }
}

// Agora deleta o registro do banco
$sql = $conn->prepare("DELETE FROM noticias WHERE id = :id");
$sql->bindParam(':id', $id);
$sql->execute();

// Redireciona
header('Location: noticias-cadastro.php');
exit;
?>
