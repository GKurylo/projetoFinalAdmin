<?php include('conexao.php');

$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("
    select * from Cursos where id='$id';
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

                    <h1>Adicione Seu Curso!</h1>

                    <div class="row mt-3 ">
                        <form action="cursos-acao.php" method="post" class="row">
                            <input type="hidden" name="txtId" value="<?php if ($id) {
                                                                            echo $dados['id'];
                                                                        }; ?>">

                            <div class="offset-2 col-8">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="txtNome" >
                            </div>

                            <div class="offset-2 col-8">
                                <label for="descricao" class="form-label">Descricao:</label>
                                <input type="text" class="form-control" id="descricao" name="txtDescricao">
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
                                <input type="text" class="form-control" id="imagem" name="txtImagem">
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
                                <th>IMAGEM:</th>
                                <th>NOME:</th>
                                <th>DESCRICAO:</th>
                                 <th>TIPO:</th>
                                <th>STATUS:</th>
                                <th>OPÇÕES:</th>
                            </tr>

                            <?php
                            $sql = $conn->prepare(" SELECT * from Cursos;");
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

    <?php include("app-footer.php"); ?>


    <?php include("app-script.php"); ?>

</body>


</html>