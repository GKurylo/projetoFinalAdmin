<?php
include('conexao.php');
include("login-validar.php");

$id = isset($_GET["id"]) ? $_GET["id"] : "";


$sql = $conn->prepare("
select * from horarios ;
");
$sql->execute();
$dados = $sql->fetch();

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

                    <h1>Edite o horário da secretaria e das aulas!</h1>

                    <div class="row mt-3 ">
                        <form action="horario-acao.php" method="post" class="row">
                            <div class="col-12 "><br>
                                    <label for="secretaria" >Secretaria:</label>
                                    <textarea placeholder="" type="textarea" class="form-control placeholder:text-sm" id="secretaria" name="txtSecretaria" rows="10" cols="33"><?php
                                                                                                                                    echo $dados["secretaria"];
                                                                                                                                 ?></textarea>
                            </div>

                            <div class="col-12 "><br>
                                    <label for="aulas" >Aulas:</label>
                                    <textarea placeholder="" type="textarea" class="form-control placeholder:text-sm" id="aulas" name="txtAulas" rows="10" cols="33"><?php 
                                                                                                                                    echo $dados["aulas"];
                                                                                                                                ?></textarea>
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


</body>


</html>