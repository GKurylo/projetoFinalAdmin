<?php
include('conexao.php');

// Dados do formulário
$id = $_POST["txtId"];
$titulo = $_POST["txtTitulo"];
$resumo = $_POST["txtResumo"];
$texto = $_POST["txtTexto"];
$status = $_POST["txtStatus"];
$imagem_antiga = $_POST["imagem_antiga"] ?? "";

// Validação básica
if (!$titulo || !$resumo || !$texto) {
    echo "<script>alert('Preencha todos os campos obrigatórios!'); history.back();</script>";
    exit;
}

// Upload da imagem
$imagem_nome = $imagem_antiga;

if (isset($_FILES["txtImagem"]) && $_FILES["txtImagem"]["error"] == 0) {
    $ext = strtolower(pathinfo($_FILES["txtImagem"]["name"], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $permitidas)) {
        $novo_nome = uniqid() . "." . $ext;

        // Garante que a pasta existe
        if (!is_dir("uploads/")) {
            mkdir("uploads/", 0755, true);
        }

        // Move o arquivo e define o nome
        if (move_uploaded_file($_FILES["txtImagem"]["tmp_name"], "uploads/" . $novo_nome)) {
            $imagem_nome = $novo_nome;
        } else {
            echo "<script>alert('Erro ao salvar a imagem!'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Formato de imagem inválido!'); history.back();</script>";
        exit;
    }
}

// Inserção ou atualização
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
    $sql->bindValue(":id", $id);
}

// Bind dos valores
$sql->bindValue(":titulo", $titulo);
$sql->bindValue(":resumo", $resumo);
$sql->bindValue(":texto", $texto);
$sql->bindValue(":imagem", $imagem_nome);
$sql->bindValue(":status", $status);

// Executa a query
$sql->execute();

echo "<script>alert('Notícia salva com sucesso!'); window.location.href='noticias-cadastro.php';</script>";
?>
