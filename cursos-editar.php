<?php
include('conexao.php');

$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("
    select * from cursos where id='$id';
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
                        <form action="cursos-acao.php" method="post" class="row">
                            <input type="hidden" name="txtId" value="<?php if ($id) {
                                                                            echo $dados['id'];
                                                                        }; ?>">

                            <div class="offset-2 col-8">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="txtNome" value="<?php if ($id) {
                                                                                                                echo $dados['nome'];
                                                                                                            }; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="descricao" class="form-label">Descricao:</label>
                                <input type="text" class="form-control" id="descricao" name="txtDescricao" value="<?php if ($id) {
                                                                                                                echo $dados['descricao'];
                                                                                                            }; ?>">
                            </div>

                            <div class="offset-2 col-8">
                                <label for="tipo" class="form-label">Tipo:</label>
                                <select type="text" class="form-control" id="tipo" name="txtTipo">
                                    <option value="1" selected>Subsequente</option>
                                    <option value="0">Integrado</option>
                                </select>
                            </div>

                            <div class="offset-2 col-8">
                                <label for="status" class="form-label">Status:</label>
                                <select type="text" class="form-control" id="status" name="txtStatus">
                                    <option value="1" selected>Ativo</option>
                                    <option value="0">Bloqueado</option>
                                </select>
                            </div>


                            <div class="offset-2 col-8">
                                <label for="imagem" class="form-label">Imagem:</label>
                                <input type="text" class="form-control" id="imagem" name="txtImagem" value="<?php if ($id) {
                                                                                                                echo $dados['imagem'];
                                                                                                            }; ?>">
                            </div>

                            <div class="col-12 text-center">
                                <input value="Gravar" type="submit" class="btn btn-success mt-3">
                            </div> <br>
                        </form>
                    </div> <br>

                </div>
            </div>
        </div>
    </div>

    <?php include("app-footer.php"); ?>


    <?php include("app-script.php"); ?>
    
    <script>
        $("#tipo").val("<?php echo $dados["tipo"] ?>");
    </script>
    <script>
        $("#status").val("<?php echo $dados["status"] ?>");
    </script>

</body>


</html>