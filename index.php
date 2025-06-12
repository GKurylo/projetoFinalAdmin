<?php include("login-validar.php");
include("conexao.php");
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
					<div class="row text-center">
						<h3>SISTEMA DE ANGENDAMENTOS</h3>
					</div>
					<div class="row text-center">
						<div class="col-12 col-md-9 mb-3 mb-md-0">
							<div id="calendar" style="width: 100%; max-width: 100%; max-height: 700px; overflow-x: auto;"></div>
						</div>
						<div class="col-12 col-md-3">

							<div class="row">
								<!-- Botão 1 -->
								<div class="col-12 text-center d-flex flex-column justify-content-center align-items-center mb-3" style="height: 38vh;">
									<a href="noticias-cadastro.php" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
										<div class="w-100">
											<i class="fas fa-plus-circle mr-2"></i>
											Adicionar Notícias
										</div>
									</a>
								</div>

								<!-- Botão 2 -->
								<div class="col-12 text-center d-flex flex-column justify-content-center align-items-center" style="height: 38vh;">
									<a href="cursos-cadastro.php" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
										<i class="fas fa-check-circle mr-2"></i>
										Adicionar Cursos
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include("app-footer.php"); ?>



	<?php include("app-script.php"); ?>

	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

	<!-- Idioma Português (Brasil) para o FullCalendar -->
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/dist/locale/pt-br.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				locale: 'pt-br',
				height: 'auto',
				events: [
					<?php
					$sql = $conn->prepare("SELECT agendas.*, locais.nome as local
                     from agendas
                     LEFT JOIN locais ON locais.id = agendas.local_id
                            ");
					$sql->execute();
					while ($dados = $sql->fetch()) {
					?> {
							title: '<?php echo $dados['local']; ?>',
							start: '<?php echo $dados['data_inicio']; ?>',
							end: '<?php echo $dados['data_fim']; ?>'
						},
					<?php } ?>
				]
			});
			calendar.render();
		});
	</script>

</body>


</html>