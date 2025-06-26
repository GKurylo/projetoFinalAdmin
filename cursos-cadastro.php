<?php
include("login-validar.php");
include("conexao.php");

$id = isset($_GET["id"]) ? $_GET["id"] : "";

if ($id) {
    $sql = $conn->prepare("SELECT * FROM CURSOS WHERE id = ?");
    $sql->execute([$id]);
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>INDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <?php include("app-header.php"); ?>
</head>
<body>
<?php include("app-lateral.php"); ?>

<div class="content-body" style="min-height: 899px;">
    <div class="container-fluid">
        <div class="row">
            <div class="card p-2">
                <h1>Adicione Seu Curso!</h1>

                <div class="row mt-3">
                    <form action="cursos-acao.php" method="post" class="row" enctype="multipart/form-data">
                        <input type="hidden" name="txtId" value="<?php echo $dados['id'] ?? ''; ?>">
                        <input type="hidden" name="imagem_antiga" value="<?php echo $dados['imagem'] ?? ''; ?>">

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
                            <select class="form-control" id="tipo" name="txtTipo">
                                <option value="1" <?php if (($dados['tipo'] ?? '') == 1) echo 'selected'; ?>>Subsequente</option>
                                <option value="0" <?php if (($dados['tipo'] ?? '') == 0) echo 'selected'; ?>>Integrado</option>
                            </select>
                        </div>

                        <div class="offset-2 col-8">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-control" id="status" name="txtStatus">
                                <option value="1" <?php if (($dados['status'] ?? '') == 1) echo 'selected'; ?>>Ativo</option>
                                <option value="0" <?php if (($dados['status'] ?? '') == 0) echo 'selected'; ?>>Bloqueado</option>
                            </select>
                        </div>

                        <div class="offset-2 col-8">
                            <label for="imagem" class="form-label">Capa:</label>
                            <input type="file" class="form-control" id="imagem" name="txtImagem">
                            <?php if (!empty($dados['imagem'])): ?>
                                <div class="mt-2">
                                    <p>Imagem atual:</p>
                                    <img src="uploads/<?php echo $dados['imagem']; ?>" alt="Capa atual" style="max-height: 150px; border: 1px solid #ccc;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="offset-2 col-8">
                            <label for="meuSelect" class="form-label">Locais:</label>
                            <select id="meuSelect" class="select2 form-control" multiple="multiple" name="txtLocais[]">
                                <?php
                                $sqllocal = $conn->prepare("SELECT * FROM locais WHERE status = 1");
                                $sqllocal->execute();
                                $locaisSelecionados = explode(',', $dados['locais_ids'] ?? '');

                                while ($dadoslocal = $sqllocal->fetch()) {
                                    $selected = in_array($dadoslocal['id'], $locaisSelecionados) ? 'selected' : '';
                                    echo "<option value='{$dadoslocal['id']}' $selected>" . htmlspecialchars($dadoslocal['nome']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-12 text-center">
                            <input value="Gravar" type="submit" class="btn btn-success mt-3">
                        </div>
                    </form>
                </div><br>

                <!-- Tabela de cursos -->
                <div class="text-center">
                    <table class="table">
                        <tr class="table-dark">
                            <th>ID:</th>
                            <th>CAPA:</th>
                            <th>NOME:</th>
                            <th>DESCRICAO:</th>
                            <th>TIPO:</th>
                            <th>LOCAIS:</th>
                            <th>STATUS:</th>
                            <th>OPÇÕES:</th>
                        </tr>

                        <?php
$sql = $conn->prepare("SELECT * FROM cursos");
$sql->execute();
while ($dados = $sql->fetch()) {

    // Obter nomes dos locais
    $locaisNomes = [];
    if (!empty($dados['locais_ids'])) {
        $ids = explode(',', $dados['locais_ids']);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmtLocais = $conn->prepare("SELECT nome FROM locais WHERE id IN ($placeholders)");
        $stmtLocais->execute($ids);
        while ($rowLocal = $stmtLocais->fetch()) {
            $locaisNomes[] = $rowLocal['nome'];
        }
    }
?>
    <tr>
        <td><?php echo $dados['id']; ?></td>
        <td style="width: 150px;">
            <img src="uploads/<?php echo $dados['imagem']; ?>" class="imgBorda" height="120px">
        </td>
        <td><?php echo $dados['nome']; ?></td>
        <td><?php echo $dados['descricao']; ?></td>
        <td><?php echo $dados['tipo'] == 1 ? 'Subsequente' : 'Integrado'; ?></td>
        <td><?php echo implode(', ', $locaisNomes); ?></td>
        <td><?php echo $dados['status'] == 1 ? 'Ativo' : 'Desativo'; ?></td>
        <td class="text-center">
            <a href="cursos-cadastro.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="cursos-deletar.php?id=<?php echo $dados['id']; ?>" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </a>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#meuSelect').select2({
            placeholder: "Selecione as opções",
            allowClear: true,
            theme: 'classic',
        });
    });
</script>
</body>
</html>