<?php include("conexao.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Listegem de Locais</title>
    <?php include("app-header.php"); ?>

</head>

<body>

    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Listagem de Locais</h1>
                    <p>Verifique todos os Locais</p>
                    
                    <div class="table-responsive mt-3">
                        <table class="table">
                            <tr class="table-dark text-center">
                                <th>ID</th>
                                <th>NOME</th>
                                <th >STATUS</th>
                                <th>OPÇÕES</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare("SELECT * from locais; ");
                            $sql->execute();
                            while ($dados = $sql->fetch()) {
                            ?>

                                <tr class="text-center">
                                    <td><?php echo $dados['id']; ?></td>
                                    <td><?php echo $dados['nome']; ?></td>
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
                                        <a href="locais-cadastro.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="locais-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>
                    </div>

                    <div class="row">
                        <div class="text-center">
                            <a href="locais-cadastro.php" class="btn btn-success" style="width: 150px;"><i class="bi bi-plus-circle-fill fs-2"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <?php include("app-footer.php"); ?>

    <?php include("app-script.php"); ?>

</body>


</html>