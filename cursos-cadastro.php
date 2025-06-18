<?php 
include("login-validar.php");
include("conexao.php");


$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("
    select * from CURSOS where id='$id';
    ");

    $sql->execute();
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>INDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <?php include("app-header.php"); ?>

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
                        <form action="cursos-acao.php" method="post" class="row" enctype="multipart/form-data">
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
                                <input type="file" class="form-control" id="imagem" name="txtImagem" value="<?php echo $dados['imagem'] ?? ''; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="status" class="form-label">Locais:</label>
                                <select id="meuSelect" class="select2 form-control" multiple="multiple" name="txtLocais">
                                    <option value="0">Sem local</option>
                                    <?php
                                        $sqllocal = $conn->prepare("SELECT * FROM locais where status=1");
                                        $sqllocal->execute();
                                        while ($dadoslocal = $sqllocal->fetch()) { ?>
                                            <option value='<?php echo $dadoslocal["id"]; ?>'
                                                <?php if ($id && $dados["local_id"] == $dadoslocal["id"]) echo "selected"; ?>>
                                                <?php echo $dadoslocal["nome"]; ?>
                                            </option>
                                        <?php } ?>
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
                                <th>NOME:</th>
                                <th>DESCRICAO:</th>
                                <th>TIPO:</th>
                                <th>STATUS:</th>
                                <th>OPÇÕES:</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare(" SELECT * from CURSOS;");
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

                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFotos" data-album-id="<?php echo $dados['id']; ?>">
                                            <i class="fa-solid fa-image"></i>
                                        </a>

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <script>
        var modalFotos = document.getElementById('modalFotos');
        modalFotos.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let albumId = button.getAttribute('data-album-id');
            document.getElementById('iframeFotos').src = 'albuns-listar.php?id=' + albumId;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#meuSelect').select2({
                placeholder: "Selecione as opções",
                allowClear: true,
                theme: 'classic',
            });
        });
    </script>

</body>

</html>