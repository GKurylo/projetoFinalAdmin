<?php 
include("conexao.php");
include("login-validar.php");
$id = isset($_GET["id"]) ? $_GET["id"] : "";
if ($id) {
    $sql = $conn->prepare("SELECT * FROM agendas where id='$id'");
    $sql->execute();
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Cadastro de Agendamentos</title>
    <?php include("app-header.php"); ?>
</head>

<body>

    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Cadastro de Agendamentos</h1>
                    <p>Cadastre Seu Agendamento</p>
                    <div class="row mt-3">
                        <form action="agendas-acao.php" method="post">
                            <input type="hidden" name="txtid" value="<?php if ($id) {
                                                                            echo $dados["id"];
                                                                        } ?>">
                            <div class="row mt-3">


                                <div class="col-12 col-md-4  ">
                                    <label for="locais">Locais</label>
                                    <select name="txtlocais" id="locais" class="form-control">
                                        <option value="0" selected>SEM LOCAL</option>
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
                                
                                <div class="col-12 col-md-4 ">
                                    <label for="data">Data</label>
                                    <select class="form-control" id="data" name="txtData">
                                    </select>  
                                </div>
                                
                                <div class="col-12 "><br>
                                    <label for="obs" >Observação:</label>
                                    <textarea placeholder="*Campo Não Obrigatório" type="textarea" class="form-control placeholder:text-sm" id="obs" name="txtObs" rows="10" cols="33"><?php if ($id) {
                                                                                                                                    echo $dados["observacao"];
                                                                                                                                } ?></textarea>
                                </div>
                                <div class="mt-3 col-12 text-center">
                                    <input type="submit" class="btn btn-success" value="Gravar">
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("app-footer.php"); ?>

    <?php include("app-script.php"); ?>
    

</body>


</html>