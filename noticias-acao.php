<?php
include('conexao.php');

// Dados do formulário
$id = $_POST["txtId"];
$titulo = $_POST["txtTitulo"]; 
$resumo = $_POST["txtResumo"];
$texto = $_POST["txtTexto"];
$status = $_POST["txtStatus"];

// Upload da imagem
$imagem = "";
if (isset($_FILES["txtImagem"]) && $_FILES["txtImagem"]["error"] == 0) {
    $nomeArquivo = $_FILES["txtImagem"]["name"];
    $caminhoTemporario = $_FILES["txtImagem"]["tmp_name"];

    $pastaDestino = "imagens/";
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true); // Cria a pasta se não existir
    }

    $caminhoFinal = $pastaDestino . time() . "_" . $nomeArquivo;

    if (move_uploaded_file($caminhoTemporario, $caminhoFinal)) {
        $imagem = $caminhoFinal;
    } else {
        echo "<script>alert('Erro ao salvar a imagem!'); history.back();</script>";
        exit;
    }
}

// Validação
if (!$titulo || !$resumo || !$texto) {
    echo "<script>alert('Preencha todos os campos obrigatórios!'); history.back();</script>";
    exit;
}

// Inserção ou atualização
if (!$id) {
    $sql = $conn->prepare("
        INSERT INTO noticias (titulo, resumo, texto, imagem, status)
        VALUES (:titulo, :resumo, :texto, :imagem, :status)
    ");
} else {
    if ($imagem) {
        $sql = $conn->prepare("
            UPDATE noticias SET
                titulo = :titulo,
                resumo = :resumo,
                texto = :texto,
                imagem = :imagem,
                status = :status
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id);
    } else {
        $sql = $conn->prepare("
            UPDATE noticias SET
                titulo = :titulo,
                resumo = :resumo,
                texto = :texto,
                status = :status
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id);
    }
}

// Bind dos valores
$sql->bindValue(":titulo", $titulo);
$sql->bindValue(":resumo", $resumo);
$sql->bindValue(":texto", $texto);
if ($imagem) {
    $sql->bindValue(":imagem", $imagem);
}
$sql->bindValue(":status", $status);

$sql->execute();

// Redireciona
header("Location: noticias-cadastro.php");
exit;
?>
