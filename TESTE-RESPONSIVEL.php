<?php include("conexao.php"); 
    // Função para limitar o número de caracteres
    function limitarTexto($texto, $limite = 10) {
        if (strlen($texto) > $limite) {
            return substr($texto, 0, $limite) . '...';
        }
        return $texto;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Agendamentos pesquisar</title>
    <?php include("app-header.php"); ?>

<style>
    /* Tamanho de fonte padrão (desktop) */
.table th, .table td {
    font-size: 1rem; /* Ajuste esse valor conforme necessário */
}

/* No modo celular, vamos truncar o texto com reticências */
@media (max-width: 100px) {
    .full-text {
        white-space: nowrap;         /* Impede a quebra de linha */
        overflow: hidden;            /* Esconde o texto que excede o limite */
        text-overflow: ellipsis;     /* Adiciona "..." no final */
        max-width: 150px;            /* Define a largura máxima da célula */
    }
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

                    <h1>Listagem de Agendamentos</h1>
                    <p>Verifique os Agandamentos</p>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <tr class="table-dark text-center">
                                <th>ID</th>
                                <th>LOCAL</th>
                                <th>INICIO</th>
                                <th>FINAL</th>
                                <th>OBSERVAÇÃO</th>
                                <th>OPÇÕES</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare("
                     select agendas.*, locais.nome as local
                     from agendas
                     LEFT JOIN locais ON locais.id = agendas.local_id
                            ");
                            $sql->execute();
                            while ($dados = $sql->fetch()) {
                            ?>

                                <tr class="text-center">
                                    <td><?php echo $dados['id']; ?></td>
                                    <td class="full-text"><?php echo htmlspecialchars(limitarTexto($dados['local'])); ?></td>
                                    <td><?php echo htmlspecialchars(limitarTexto($dados['data_inicio'])); ?></td>
                                    <td><?php echo htmlspecialchars(limitarTexto($dados['data_fim'])); ?></td>
                                    <td><?php echo htmlspecialchars(limitarTexto($dados['observacao'])); ?></td>
                                    <td class="text-center">
                                        <a href="agendas-cadastro.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="agendas-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>
                    </div>

                    <div class="row">
                        <div class="text-center">
                            <a href="agendas-cadastro.php" class="btn btn-success" style="width: 150px;"><i class="bi bi-plus-circle-fill fs-2"></i></a>
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