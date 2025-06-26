<?php
include('conexao.php');

$id = $_POST["txtId"];
$nome = $_POST["txtNome"];
$descricao = $_POST["txtDescricao"];
$tipo = $_POST["txtTipo"];
$status = $_POST["txtStatus"];
$locais = isset($_POST['txtLocais']) ? (array)$_POST['txtLocais'] : [];
$imagem_antiga = $_POST["imagem_antiga"] ?? "";
$imagem = $imagem_antiga; // por padrão, mantém a imagem antiga



// Verifica se foi enviado uma nova imagem
if (isset($_FILES["txtImagem"]) && $_FILES["txtImagem"]["error"] == 0) {
    $ext = strtolower(pathinfo($_FILES["txtImagem"]["name"], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $permitidas)) {
        $novo_nome = uniqid() . "." . $ext;

        // Cria pasta uploads se não existir
        if (!is_dir("uploads/")) {
            mkdir("uploads/", 0755, true);
        }

        // Move o arquivo para uploads
        if (move_uploaded_file($_FILES["txtImagem"]["tmp_name"], "uploads/" . $novo_nome)) {
            $imagem = $novo_nome;
        } else {
            echo "<script>alert('Erro ao enviar a imagem!'); window.location = 'cursos-cadastro.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Formato de imagem não permitido!'); window.location = 'cursos-cadastro.php';</script>";
        exit;
    }
}

if (!$nome) {
    echo "<script>alert('Campo Nome Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$descricao) {
    echo "<script>alert('Campo Descrição Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$imagem) {
    echo "<script>alert('Campo Capa Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}
if (!$locais) {
    echo "<script>alert('Campo Locais Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
}

// Converte array de locais para string separada por vírgula
$locais_string = implode(',', $locais);

if ($id) {
    // Atualiza curso existente
    $sql = $conn->prepare("UPDATE cursos SET nome = ?, descricao = ?, tipo = ?, status = ?, locais_ids = ?, imagem = ? WHERE id = ?");
    $resultado = $sql->execute([$nome, $descricao, $tipo, $status, $locais_string, $imagem, $id]);
} else {
    // Insere novo curso
    $sql = $conn->prepare("INSERT INTO cursos (nome, descricao, tipo, status, locais_ids, imagem) VALUES (?, ?, ?, ?, ?, ?)");
    $resultado = $sql->execute([$nome, $descricao, $tipo, $status, $locais_string, $imagem]);
}

if ($resultado) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location = 'cursos-cadastro.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar!'); window.location = 'cursos-cadastro.php';</script>";
}
