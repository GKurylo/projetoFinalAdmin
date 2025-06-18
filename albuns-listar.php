<?php 
include('conexao.php');
include("login-validar.php");

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$listar = isset($_GET["listar"]) ? true : false;
$listar = true;

// Upload de imagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && $id > 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileTmp = $_FILES['file']['tmp_name'];
    $fileName = uniqid() . "_" . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $filePath)) {
        $sql = $conn->prepare("INSERT INTO albuns_imagens (album_id, nome_arquivo) VALUES (?, ?)");
        $sql->execute([$id, $filePath]);
        echo 'Upload realizado';
    } else {
        http_response_code(500);
        echo 'Erro ao mover o arquivo.';
    }
    exit;
}

// Exclusão
if (isset($_GET["delete"])) {
    $imgId = intval($_GET["delete"]);

    $sql = $conn->prepare("SELECT nome_arquivo FROM albuns_imagens WHERE id=?");
    $sql->execute([$imgId]);
    $img = $sql->fetch();

    if ($img && file_exists($img['nome_arquivo'])) {
        unlink($img['nome_arquivo']);
    }

    $sql = $conn->prepare("DELETE FROM albuns_imagens WHERE id=?");
    $sql->execute([$imgId]);

    header("Location: albuns-listar.php?id=$id&listar=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Imagens do Álbum</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .img-thumb {
            width: 150px;
            height: auto;
            margin: 10px;
            border: 1px solid #ccc;
        }

        .img-box {
            display: inline-block;
            position: relative;
            margin: 10px;
        }

        .delete-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            padding: 5px 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h3>Upload de Imagens para o Álbum #<?= $id ?></h3>

    <form action="albuns-listar.php?id=<?= $id ?>" class="dropzone" id="albumDropzone"></form>

    <script>
        Dropzone.autoDiscover = false;

        const dz = new Dropzone("#albumDropzone", {
            paramName: "file",
            maxFilesize: 10,
            acceptedFiles: "image/*",
            dictDefaultMessage: "Arraste os arquivos aqui ou clique para fazer upload",
            init: function() {
                this.on("queuecomplete", function() {
                    window.location.href = "albuns-listar.php?id=<?= $id ?>&listar=1";
                });
            }
        });
    </script>

    <?php if ($listar): ?>
        <hr>
        <h4>Imagens Enviadas</h4>
        <div>
            <?php
            $sql = $conn->prepare("SELECT * FROM albuns_imagens WHERE album_id=?");
            $sql->execute([$id]);
            while ($img = $sql->fetch()):
            ?>
                <div class="img-box">
                    <img src="<?= $img['nome_arquivo'] ?>" class="img-thumb" style="width:125px;height:125px">
                    <form method="get" onsubmit="return confirm('Deseja realmente excluir esta imagem?')">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="listar" value="1">
                        <input type="hidden" name="delete" value="<?= $img['id'] ?>">
                        <button class="delete-btn" title="Remover">&times;</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</body>

</html>