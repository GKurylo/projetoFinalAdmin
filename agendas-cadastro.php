<?php 
include("conexao.php");
include("login-validar.php");
$id = isset($_GET["id"]) ? $_GET["id"] : "";
if ($id) {
    $sql = $conn->prepare("SELECT * FROM agendas WHERE id = ?");
    $sql->execute([$id]);
    $dados = $sql->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Cadastro de Agendamentos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
		rel="stylesheet" />
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
                            <div class="row mt-3" style="min-height: 500px;">

                            <!-- COLUNA ESQUERDA: Local, Data, Observação -->
                            <div class="col-md-6 d-flex flex-column justify-content-start">

                                <div class="row">
                                    <!-- Local -->
                                    <div class="col-md-6">
                                        <label for="locais">Local:</label>
                                        <select name="txtLocal" id="locais" class="form-control">
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

                                    <!-- Data -->
                                    <div class="col-md-6">
                                        <label for="data">Data:</label>
                                        <input class="form-control" id="data" name="txtData" type="date" value="<?php if ($id) echo date('Y-m-d', strtotime($dados['data'])); ?>"> 
                                    </div>
                                </div>

                                <!-- Observação -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="obs">Observação:</label>
                                        <textarea placeholder="*Campo Não Obrigatório" class="form-control placeholder:text-sm" id="obs" name="txtObservacao" rows="8"><?php if ($id) echo $dados["observacao"]; ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <!-- COLUNA DIREITA: Horários ocupando toda a altura -->
                            <div class="col-md-6 d-flex flex-column justify-content-start" id="modalHorarios">
                                <label for="horariosSelect">Horários:</label>
                                <select class="form-control h-100" id="horariosSelect" name="txtHorario" multiple >   
                                </select>  
                            </div>

                        </div>

                        <div class="mt-3 col-12 text-center">
                            <input type="submit" class="btn btn-success" value="Gravar">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php include("app-footer.php"); ?>

    <?php include("app-script.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        function carregarHorarios() {
			let horarios = {
				"Matutino": ["07:30", "08:20", "09:10", "10:10", "11:00"],
				"Vespertino": ["13:00", "13:50", "14:40", "15:40", "16:30"],
				"Noturno": ["18:40", "19:30", "20:30", "21:20", "22:10"]
			};

			let select = document.getElementById('horariosSelect');
			select.innerHTML = "";

			for (let periodo in horarios) {
				let optgroup = document.createElement('optgroup');
				optgroup.label = periodo;
				horarios[periodo].forEach(function (hora) {
					let option = document.createElement('option');
					option.value = hora;
					option.text = hora;
					optgroup.appendChild(option);
				});
				select.appendChild(optgroup);
			}

			$('#horariosSelect').select2({
				placeholder: "Selecione os horários",
				width: '100%',
				theme: 'classic',
				dropdownParent: $('#modalHorarios')
			});
		}
        document.addEventListener('DOMContentLoaded', function() {
        carregarHorarios();
    });

    </script>

</body>


</html>