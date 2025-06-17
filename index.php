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
						<div>
							<div id="calendar"
								style="width: 100%; max-width: 100%; max-height: 700px; overflow-x: auto;"></div>
						</div>
					</div>
					<!-- Modal de Locais -->
					<div class="modal fade" id="modalLocais" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Escolha o Local para <span id="dataSelecionada"></span></h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								<div class="modal-body">
									<?php
									// Exemplo de locais fixos ou vindo do banco
									$sqlLocais = $conn->query("SELECT id, nome FROM locais");
									while ($local = $sqlLocais->fetch()) {
										?>
										<button class="btn btn-outline-primary w-100 my-1 local-btn"
											data-id="<?php echo $local['id']; ?>" data-nome="<?php echo $local['nome']; ?>">
											<?php echo $local['nome']; ?>
										</button>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal de Horários -->
					<div class="modal fade" id="modalHorarios" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog">
							<form method="POST" class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Escolha um horário para <span id="localSelecionado"></span>
										- <span id="dataSelecionada2"></span></h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								<div class="modal-body">
									<input type="hidden" name="data" id="inputData">
									<input type="hidden" name="local_id" id="inputLocalId">
									<div id="horariosList" class="list-group">
										<!-- Horários via JS -->
									</div>
								</div>
							</form>
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
	<style>
		.fc-scrollgrid-section-sticky {
			z-index: 1 !important;
		}
	</style>
	<?php
	// DEBUG TEMPORÁRIO:
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	?>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				locale: 'pt-br',
				height: 'auto',

				dateClick: function (info) {
					let dataSelecionada = info.dateStr;
					document.getElementById('dataSelecionada').innerText = dataSelecionada;
					let modalLocais = new bootstrap.Modal(document.getElementById('modalLocais'));
					modalLocais.show();
				},

				events: [
					<?php
					$eventos = [];
					$sql = $conn->prepare("SELECT agendas.*, locais.nome as local FROM agendas LEFT JOIN locais ON locais.id = agendas.local_id");
					$sql->execute();
					while ($dados = $sql->fetch()) {
						$eventos[] = "{ title: " . json_encode($dados['local']) . ", start: " . json_encode($dados['data']) . " }";
					}
					echo implode(',', $eventos);
					?>
				]

			});
			calendar.render();

			// Quando o usuário clicar em um horário
			document.getElementById('horariosList').addEventListener('click', function (e) {
				if (e.target && e.target.matches('button.list-group-item')) {
					let horarioSelecionado = e.target.textContent.trim();
					let data = document.getElementById('inputData').value;
					let localId = document.getElementById('inputLocalId').value;

					// Enviar via AJAX
					fetch('salvar-agendamento.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						body: `data=${data}&horario=${horarioSelecionado}&local_id=${localId}`
					})
						.then(response => response.text())
						.then(result => {
							alert(result);
							location.reload();  // Atualiza a página para mostrar no calendário
						})
						.catch(error => {
							console.error('Erro:', error);
						});
				}
			});
		});
	</script>

</body>


</html>