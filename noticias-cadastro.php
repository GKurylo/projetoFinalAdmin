<?php include('conexao.php');
include("login-validar.php");

$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("
    select * from NOTICIAS where id='$id';
    ");

    $sql->execute();
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Index</title>
    <?php include("app-header.php"); ?>   
</head>

<body>

    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Adicione Sua Notícia!</h1>

                    <div class="row mt-3 ">
                        <form action="noticias-acao.php" method="post" class="row">
                            <input type="hidden" name="txtId" value="<?php if ($id) {
                                                                            echo $dados['id'];
                                                                        }; ?>">

                            <div class="offset-2 col-8">
                                <label for="titulo" class="form-label">Titulo:</label>
                                <input type="text" class="form-control" id="titulo" name="txtTitulo" value="<?php echo $dados['titulo'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="resumo" class="form-label">Resumo:</label>
                                <input type="text" class="form-control" id="resumo" name="txtResumo" value="<?php echo $dados['resumo'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="texto" class="form-label">Texto:</label>
                                <input type="text" class="form-control" id="texto" name="txtTexto" value="<?php echo $dados['texto'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="imagem" class="form-label">Capa:</label>
                                <input type="file" class="form-control" id="imagem" name="txtImagem" value="<?php echo $dados['imagem'] ?? ''; ?>">
                            </div>
                            
                            <div class="offset-2 col-8">
                                <label for="status" class="form-label">Status:</label>
                                <select type="text" class="form-control" id="status" name="txtStatus">
                                    <option value="1" <?php if (($dados['status'] ?? '') == 1) echo 'selected'; ?>>Ativo</option>
                                    <option value="0" <?php if (($dados['status'] ?? '') == 0) echo 'selected'; ?>>Bloqueado</option>
                                </select>
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
                                <th>TITULO:</th>
                                <th>RESUMO:</th>
                                <th>STATUS:</th>
                                <th>OPÇÕES:</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare(" SELECT * from noticias;");
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
                                        <?php echo $dados['titulo'] ?>
                                    </td>
                                    <td>
                                        <?php echo $dados['resumo'] ?>
                                    </td>
                                    <td>
                                        <?php
                                           if ($dados['status'] == 1) {
                                               echo "Ativo";
                                           } else {
                                               echo "Bloqueado";
                                           };
                                        ?>

                                    </td>
                                    <td class="text-center">
                                        <a href="noticias-editar.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFotos" data-album-id="<?php echo $dados['id']; ?>">
                                            <i class="fa-solid fa-image"></i>
                                        </a>

                                        <a href="noticias-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


       <!-- Modal album -->
    <div class="modal fade" id="modalFotos" tabindex="-1" aria-labelledby="modalFotosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gerenciar Fotos do Álbum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe src="" id="iframeFotos" frameborder="0" style="width: 100%; height: 500px;"></iframe>
                </div>
            </div>
        </div>
    </div>

    
    <?php include("app-footer.php"); ?>

    <?php include("app-script.php"); ?>

    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        var modalFotos = document.getElementById('modalFotos');
        modalFotos.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let albumId = button.getAttribute('data-album-id');
            document.getElementById('iframeFotos').src = 'albuns-listar.php?id=' + albumId;
        });
    </script>

</body>

</html>
