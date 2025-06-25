<?php
include('conexao.php');



$id = $_POST["txtId"];
$Nome = $_POST["txtNome"];
$Descricao = $_POST["txtDescricao"];
$Tipo = $_POST["txtTipo"];
$status = $_POST["txtStatus"];
$locais = isset($_POST['txtLocais']) ? (array)$_POST['txtLocais'] : [];
$imagem_antiga = $_POST["imagem_antiga"] ?? "";
$imagem = null;

// Upload da imagem
$imagem = $imagem_antiga;

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

// Validação
if (!$Nome) {
    echo "<script>alert('Campo Nome Obrigatório!'); history.back();</script>";
    exit;
}
if (!$Descricao) {
    echo "<script>alert('Campo Descrição Obrigatório!'); history.back();</script>";
    exit;
}
if (!$locais) {
    echo "<script>alert('Campo Locais Obrigatório!'); history.back();</script>";
    exit;
}

// Se estiver editando e não enviou nova imagem, manter a atual
if ($id && !$imagem && isset($_POST['imagemAtual'])) {
    $imagem = $_POST['imagemAtual'];
}

// Se for cadastro novo e não tem imagem, erro
if (!$id && !$imagem) {
    echo "<script>alert('Campo Capa Obrigatório!'); history.back();</script>";
    exit;
}

if (!$id) {
    $locais_string = implode(',', $locais);
    $sql = $conn->prepare("
        INSERT INTO cursos (Nome, Descricao, Tipo, imagem, status, locais_ids)
        VALUES (:Nome, :Descricao, :Tipo, :imagem, :status, :locais)
    ");
    $sql->execute([
        ':Nome' => $Nome,
        ':Descricao' => $Descricao,
        ':Tipo' => $Tipo,
        ':imagem' => $imagem,
        ':status' => $status,
        ':locais' => $locais_string,
    ]);
} else {
    $locais_string = implode(',', $locais);
    $sql = $conn->prepare("
        UPDATE cursos SET 
            Nome = :Nome,
            Descricao = :Descricao,
            Tipo = :Tipo,
            imagem = :imagem,
            status = :status,
            locais_ids = :locais
        WHERE id = :id
    ");
    $sql->execute([
        ':Nome' => $Nome,
        ':Descricao' => $Descricao,
        ':Tipo' => $Tipo,
        ':imagem' => $imagem,
        ':status' => $status,
        ':locais' => $locais_string,
        ':id' => $id,
    ]);
}

// Redirecionar
header("Location: cursos-cadastro.php");
exit;
?>
