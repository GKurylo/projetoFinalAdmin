<?php include('conexao.php');

$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("
    select * from Cursos where id='$id';
    ");

    $sql->execute();
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>INDEX</title>
    <?php include("app-header.php"); ?>

    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <style>
        .dropzone {
            border: 2px dashed #007bff;
            padding: 20px;
            background: #f9f9f9;
        }
    </style>
</head>

<body>

    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Adicione Seu Curso!</h1>

                    <div class="row mt-3 ">
                        <form action="cursos-acao.php" method="post" class="row">
                            <input type="hidden" name="txtId" value="<?php if ($id) {
                                                                            echo $dados['id'];
                                                                        }; ?>">

                            <div class="offset-2 col-8">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="txtNome" value="<?php echo $dados['nome'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="descricao" class="form-label">Descricao:</label>
                                <input type="text" class="form-control" id="descricao" name="txtDescricao" value="<?php echo $dados['descricao'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="tipo" class="form-label">Tipo:</label>
                                <select type="text" class="form-control" id="tipo" name="txtTipo">
                                    <option value="1" <?php if (($dados['tipo'] ?? '') == 1) echo 'selected'; ?>>Subsequente</option>
                                    <option value="0" <?php if (($dados['tipo'] ?? '') == 0) echo 'selected'; ?>>Integrado</option>
                                </select>
                            </div>

                            <div class="offset-2 col-8">
                                <label for="status" class="form-label">Status:</label>
                                <select type="text" class="form-control" id="status" name="txtStatus">
                                    <option value="1" <?php if (($dados['status'] ?? '') == 1) echo 'selected'; ?>>Ativo</option>
                                    <option value="0" <?php if (($dados['status'] ?? '') == 0) echo 'selected'; ?>>Bloqueado</option>
                                </select>
                            </div>
                            
                            <div class="offset-2 col-8">
                                <label for="imagem" class="form-label">Capa:</label>
                                <input type="text" class="form-control" id="imagem" name="txtImagem" value="<?php echo $dados['imagem'] ?? ''; ?>">
                            </div>

                            <!-- NOVO CAMPO DROPZONE IMAGEM ALBUM -->
                            <div class="offset-2 col-8">
                                <label for="imagemAlbum" class="form-label">Imagem Album:</label>

                                <div id="dropzoneImagemAlbum" class="dropzone"></div>

                                <input type="hidden" id="imagemAlbumHidden" name="txtImagemAlbum" value="<?php echo $dados['imagemAlbum'] ?? ''; ?>">
                            </div>

                            <div class="col-12 text-center">
                                <input value="Gravar" type="submit" class="btn btn-success mt-3">
                            </div> <br>
                        </form>
                    </div> <br>

                    <div class="text-center">
                        <table class="table ">
                            <tr class="table-dark">
                                <th>ID:</th>
                                <th>CAPA:</th>
                                <th>NOME:</th>
                                <th>DESCRICAO:</th>
                                <th>TIPO:</th>
                                <th>STATUS:</th>
                                <th>OPÇÕES:</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare(" SELECT * from Cursos;");
                            $sql->execute();
                            while ($dados = $sql->fetch()) {
                            ?>

                                <tr>
                                    <td>
                                        <?php echo $dados['id'] ?>
                                    </td>
                                    <td style="width: 150px;">
                                        <?php echo '<img src="' . ($dados['imagem'] ?? '') . '" class="imgBorda" height="120px">'; ?>
                                    </td>
                                    <td>
                                        <?php echo $dados['nome'] ?>
                                    </td>
                                    <td>
                                        <?php echo $dados['descricao'] ?>
                                    </td>
                                    <td>
                                        <?php
                                           if ($dados['tipo'] == 1) {
                                               echo "Subsequente";
                                           } else {
                                               echo "Integrado";
                                           };
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                           if ($dados['status'] == 1) {
                                               echo "Ativo";
                                           } else {
                                               echo "Desativo";
                                           };
                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <a href="cursos-editar.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="cursos-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("app-footer.php"); ?>


    <?php include("app-script.php"); ?>

    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        // Dropzone para Imagem Album
        const dzImagemAlbum = new Dropzone("#dropzoneImagemAlbum", {
            url: "upload.php",       // ajuste para seu arquivo de upload
            paramName: "file",
            maxFiles: 1,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            init: function() {
                this.on("success", function(file, response) {
                    let json = JSON.parse(response);
                    document.getElementById("imagemAlbumHidden").value = json.nomeArquivo;
                });
                this.on("removedfile", function(file) {
                    document.getElementById("imagemAlbumHidden").value = "";
                });

                <?php if (!empty($dados['imagemAlbum'])): ?>
                let mockFile = { name: "Imagem Album Atual", size: 12345 };
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "<?php echo $dados['imagemAlbum']; ?>");
                this.emit("complete", mockFile);
                document.getElementById("imagemAlbumHidden").value = "<?php echo $dados['imagemAlbum']; ?>";
                <?php endif; ?>
            }
        });
    </script>

</body>

</html>
