<?php include("conexao.php");
$id = isset($_GET["id"]) ? $_GET["id"] : "";
if ($id) {
    $sql = $conn->prepare("SELECT * FROM usuarios where id='$id'");
    $sql->execute();
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Usuarios Pesquisar</title>
    <?php include("app-header.php"); ?>

</head>

<body>



    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Cadastro de Usuários</h1>
                    <p>Cadastre Usuários</p>

                    <div class="row mt-3">
                        <form action="usuarios-acao.php" method="post" class="row">
                            <input type="hidden" name="txtid" value="<?php if ($id) {
                                                                            echo $dados["id"];
                                                                        } ?>">
                            <div class="col-12 col-md-4 mt-3">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="txtNome" value="<?php if ($id) {
                                                                                                            echo $dados["nome"];
                                                                                                        } ?>">
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="txtSenha" value="<?php if ($id) {
                                                                                                                    echo $dados["senha"];
                                                                                                                } ?>">
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="usuario">Email</label>
                                <input type="email" class="form-control" id="usuario" name="txtUsuario" value="<?php if ($id) {
                                                                                                                    echo $dados["usuario"];
                                                                                                                } ?>">
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="status">Status</label>
                                <select name="txtStatus" id="status" class="form-control">
                                    <option value="1" selected>ativo</option>
                                    <option value="0">bloqueado</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="cargo">Cargo</label>
                                <select name="txtCargo" id="cargo" class="form-control">
                                    <option value="1" selected>Administração</option>
                                    <option value="0">Professor</option>
                                </select>
                            </div>

                            <div class="mt-3 col-12 text-center">
                                <input type="submit" class="btn btn-success" value="Gravar">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("app-footer.php"); ?>

    <?php include("app-script.php"); ?>
    <script>
        $("#status").val("<?php echo $dados["status"] ?>");
        $("#cargo").val("<?php echo $dados["cargo"] ?>");
    </script>
</body>


</html>