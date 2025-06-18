<?php
include('conexao.php');

$id = $_POST["txtId"];
$Nome = $_POST["txtNome"];
$Descricao = $_POST["txtDescricao"];
$Tipo = $_POST["txtTipo"];
$status = $_POST["txtStatus"];
$locais = $_POST["txtLocais"];

$imagem = null;  // Começa vazio

// Upload da imagem
if (isset($_FILES['txtImagem']) && $_FILES['txtImagem']['error'] == 0) {
    $pastaDestino = "uploads/";
    $nomeUnico = uniqid() . "-" . basename($_FILES['txtImagem']['name']);
    $caminhoCompleto = $pastaDestino . $nomeUnico;

    // Valida tipos de imagem permitidos
    $tiposPermitidos = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    if (in_array($_FILES['txtImagem']['type'], $tiposPermitidos)) {
        if (move_uploaded_file($_FILES['txtImagem']['tmp_name'], $caminhoCompleto)) {
            $imagem = $caminhoCompleto;
        } else {
            echo "<script>alert('Falha ao salvar a imagem.'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Tipo de arquivo não permitido. Envie apenas imagens PNG, JPG ou GIF.'); history.back();</script>";
        exit;
    }
}

// Validação de campos obrigatórios
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

if (!$id) {
    // INSERIR
    $sql = $conn->prepare("
        INSERT INTO cursos (Nome, Descricao, Tipo, imagem, status, locais_ids)
        VALUES (:Nome, :Descricao, :Tipo, :imagem, :status, :locais)
    ");
    $sql->bindParam(':Nome', $Nome);
    $sql->bindParam(':Descricao', $Descricao);
    $sql->bindParam(':Tipo', $Tipo);
    $sql->bindParam(':imagem', $imagem);
    $sql->bindParam(':status', $status);
    $sql->bindParam(':locais', $locais);
    $sql->execute();
} else {
    // ATUALIZAR
    if ($imagem) {
        // Atualiza tudo incluindo a imagem
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
        $sql->bindParam(':imagem', $imagem);
    } else {
        // Atualiza sem mexer na imagem
        $sql = $conn->prepare("
            UPDATE cursos SET 
                Nome = :Nome,
                Descricao = :Descricao,
                Tipo = :Tipo,
                status = :status,
                locais_ids = :locais
            WHERE id = :id
        ");
    }

    $sql->bindParam(':Nome', $Nome);
    $sql->bindParam(':Descricao', $Descricao);
    $sql->bindParam(':Tipo', $Tipo);
    $sql->bindParam(':status', $status);
    $sql->bindParam(':locais', $locais);
    $sql->bindParam(':id', $id);
    $sql->execute();
}

// Redireciona de volta para o formulário
header("Location: cursos-cadastro.php");
exit;
?>
