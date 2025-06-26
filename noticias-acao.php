<?php
include('conexao.php');

// Dados do formulário
$id = $_POST["txtId"] ?? "";
$titulo = $_POST["txtTitulo"] ?? "";
$resumo = $_POST["txtResumo"] ?? "";
$texto = $_POST["txtTexto"] ?? "";
$status = $_POST["txtStatus"] ?? 0;
$imagem_antiga = $_POST["imagem_antiga"] ?? "";

// Upload da nova imagem (se houver)
$imagem = $imagem_antiga;

if (isset($_FILES["txtImagem"]) && $_FILES["txtImagem"]["error"] == 0) {
    $ext = strtolower(pathinfo($_FILES["txtImagem"]["name"], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'jfif',];

    if (in_array($ext, $permitidas)) {
        $novo_nome = uniqid() . "." . $ext;

        if (!is_dir("uploads/")) {
            mkdir("uploads/", 0755, true);
        }

        if (move_uploaded_file($_FILES["txtImagem"]["tmp_name"], "uploads/" . $novo_nome)) {
            $imagem = $novo_nome;
        } else {
            echo "<script>alert('Erro ao salvar a imagem!'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Formato de imagem inválido!'); history.back();</script>";
        exit;
    }
}

if (!$titulo) {
    echo "<script>alert('Campo Titulo Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$resumo) {
    echo "<script>alert('Campo Resumo Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$texto) {
    echo "<script>alert('Campo Texto Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$imagem) {
    echo "<script>alert('Campo Imagem Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}

// Inserir ou atualizar
if (empty($id)) {
    $sql = $conn->prepare("
        INSERT INTO noticias (titulo, resumo, texto, imagem, status)
        VALUES (:titulo, :resumo, :texto, :imagem, :status)
    ");
} else {
    $sql = $conn->prepare("
        UPDATE noticias SET
            titulo = :titulo,
            resumo = :resumo,
            texto = :texto,
            imagem = :imagem,
            status = :status
        WHERE id = :id
    ");
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
}

$sql->bindValue(":titulo", $titulo);
$sql->bindValue(":resumo", $resumo);
$sql->bindValue(":texto", $texto);
$sql->bindValue(":imagem", $imagem);
$sql->bindValue(":status", $status, PDO::PARAM_INT);

$sql->execute();

echo "<script>alert('Notícia salva com sucesso!'); window.location.href='noticias-cadastro.php';</script>";
?>
