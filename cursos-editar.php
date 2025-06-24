<?php
include('conexao.php');
include("login-validar.php");

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

                    <h1>Edite Seu Curso! - <?php echo $dados['nome']; ?></h1>

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
                                <label for="imagem" class="form-label">Capa:</label>

                                <?php if ($id && !empty($dados['imagem'])): ?>
                                    <input type="hidden" name="imagemAtual" value="<?php echo $dados['imagem']; ?>">
                                    <div class="mb-2">
                                        <img src="<?php echo $dados['imagem']; ?>" alt="Imagem atual" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>

                                <input type="file" class="form-control" id="imagem" name="txtImagem">
                            </div>
                            <div class="offset-2 col-8">
                                <label for="status" class="form-label">Locais:</label>
                                <select id="meuSelect" class="select2 form-control" multiple="multiple" name="txtLocais[]">
                                    <option value="0">Sem local</option>
                                    <?php
                                    $sqllocal = $conn->prepare("SELECT * FROM locais WHERE status=1");
                                    $sqllocal->execute();
                                    $locaisSelecionados = [];
                                    if ($id && !empty($dados['locais_ids'])) {
                                        $locaisSelecionados = explode(",", $dados['locais_ids']);
                                    }

                                    while ($dadoslocal = $sqllocal->fetch()) { ?>
                                        <option value='<?php echo $dadoslocal["id"]; ?>'
                                            <?php if (in_array($dadoslocal["id"], $locaisSelecionados)) echo "selected"; ?>>
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