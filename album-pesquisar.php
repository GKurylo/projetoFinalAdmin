<?php include("conexao.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Listegem de Albuns</title>
    <?php include("app-header.php"); ?>

</head>

<body>

    <?php include("app-lateral.php"); ?>

    <!-- Conteudo -->
    <div class="content-body" style="min-height: 899px;">
        <div class="container-fluid">
            <div class="row">
                <div class="card p-2">

                    <h1>Listagem de Albuns</h1>
                    <p>Verifique todos os Albuns</p>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <tr class="table-dark text-center">
                                <th>ID</th>
                                <th>NOME</th>
                                <th>STATUS</th>
                                <th>OPÇÕES</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare("select albuns.*, imagens.imagem as img
                     from albuns
                     LEFT JOIN imagens ON imagens.album_id = albuns.id");
                            $sql->execute();
                            while ($dados = $sql->fetch()) {
                            ?>

                                <tr class="text-center">
                                    <td><?php echo $dados['id']; ?></td>
                                    <td><?php echo $dados['titulo']; ?></td>
                                    <td><?php $data = new DateTime($dados['data']);
                                        echo $data->format('d/m/Y H:i:s'); ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm"
                                            onclick="mostrarObs('<?php echo htmlspecialchars(addslashes($dados['observacao'])); ?>')">
                                            Ver imagens
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="albuns-cadastro.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="albuns-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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