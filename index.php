<?php
include("conexao.php");
include("login-validar.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>INDEX</title>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
		rel="stylesheet" />
	<?php include("app-header.php"); ?>
</head>

<body>

	<?php include("app-lateral.php"); ?>

	<div class="content-body" style="min-height: 899px;">
		<div class="container-fluid">
			<div class="card p-2">
				<div class="text-center">
					<h3>SISTEMA DE AGENDAMENTOS</h3>
				</div>
				<div class="text-center">
					<div id="calendar" style="width: 100%; max-width: 100%; max-height: 700px; overflow-x: auto;"></div>
				</div>

				<!-- Modal Locais -->
				<div class="modal fade" id="modalLocais" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Escolha o Local para <span id="dataSelecionada"></span></h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<?php
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

				<!-- Modal Horários -->
				<div class="modal fade" id="modalHorarios" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<form method="POST" class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Escolha um horário para <span id="localSelecionado"></span> -
									<span id="dataSelecionada2"></span>
								</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<input type="hidden" name="data" id="inputData">
								<input type="hidden" name="local_id" id="inputLocalId">
								<label for="horariosSelect">Horário:</label>
								<select id="horariosSelect" class="form-control" multiple></select>
							</div>
							<div class="modal-footer">
								<button type="button" onclick="salvarObservacao()" id="btnSalvarAgendamento"
									class="btn btn-primary">Salvar Agendamentos</button>
								<button type="button" class="btn btn-secondary" data-bs-toggle="modal"
									data-bs-target="#modalObservacao">Observação</button>
							</div>
						</form>
					</div>
				</div>

				<!-- Modal Observação -->
				<div class="modal fade" id="modalObservacao" tabindex="-1" aria-labelledby="modalObservacaoLabel"
					aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalObservacaoLabel">Observação</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<input type="hidden" id="observacaoHidden">
								<textarea id="observacaoTexto" class="form-control" rows="5"
									placeholder="Digite sua observação aqui..."></textarea>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" id="btnSalvarObservacao"
									onclick="salvarObservacao()">Salvar Observação</button>

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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/dist/locale/pt-br.js"></script>

	<style>
		.fc-scrollgrid-section-sticky {
			z-index: 1 !important;
		}
	</style>

	<?php error_reporting(E_ALL);
	ini_set('display_errors', 1); ?>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
				initialView: 'dayGridMonth',
				locale: 'pt-br',
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
				},
				dateClick: function (info) {
					let partes = info.dateStr.split("-");
					let dataFormatada = partes[2] + "/" + partes[1] + "/" + partes[0];
					document.getElementById('dataSelecionada').innerText = dataFormatada;
					new bootstrap.Modal(document.getElementById('modalLocais')).show();
				},
				events: <?php
				$eventos = [];
				$sql = $conn->prepare("SELECT agendas.*, locais.nome AS local, locais.cor FROM agendas LEFT JOIN locais ON locais.id = agendas.local_id");
				$sql->execute();
				$sql->setFetchMode(PDO::FETCH_ASSOC);

				while ($dados = $sql->fetch()) {
					$eventos[] = [
						'title' => $dados['local'],
						'start' => $dados['data'] . 'T' . $dados['horario'],
						'end' => $dados['data'] . 'T' . $dados['horariofin'],
						'color' => $dados['cor']
					];
				}

				echo json_encode($eventos);
				
				?>
			});
			calendar.render();

			document.querySelectorAll('.local-btn').forEach(function (button) {
				button.addEventListener('click', function () {
					let localId = this.getAttribute('data-id');
					let localNome = this.getAttribute('data-nome');
					let dataSelecionada = document.getElementById('dataSelecionada').innerText;

					document.getElementById('localSelecionado').innerText = localNome;
					document.getElementById('dataSelecionada2').innerText = dataSelecionada;
					document.getElementById('inputLocalId').value = localId;
					document.getElementById('inputData').value = dataSelecionada;

					carregarHorarios();

					bootstrap.Modal.getInstance(document.getElementById('modalLocais')).hide();
					new bootstrap.Modal(document.getElementById('modalHorarios')).show();
				});
			});

			document.getElementById('btnSalvarAgendamento').addEventListener('click', function () {
				let horariosSelecionados = $('#horariosSelect').val();
				let data = document.getElementById('inputData').value;
				let localId = document.getElementById('inputLocalId').value;
				let observacao = document.getElementById('observacaoHidden').value;

				if (!horariosSelecionados || horariosSelecionados.length === 0) {
					alert("Por favor, selecione pelo menos um horário.");
					return;
				}

				horariosSelecionados.forEach(function (horario) {
					fetch('agendas-acao.php', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: `txtData=${encodeURIComponent(data)}&txtHorario=${encodeURIComponent(horario)}&txtLocal=${encodeURIComponent(localId)}&txtObservacao=${encodeURIComponent(observacao)}`
					})
						.then(response => response.text())
						.then(result => console.log(result))
						.catch(error => console.error('Erro:', error));
				});

				alert("Agendamentos salvos!");
				location.reload();
			});
		});

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

		function salvarObservacao() {
			let textoObservacao = document.getElementById('observacaoTexto').value;
			document.getElementById('observacaoHidden').value = textoObservacao;

			// Fecha o modal de observação
			var modalObsEl = document.getElementById('modalObservacao');
			var modalObs = bootstrap.Modal.getInstance(modalObsEl);
			modalObs.hide();

			// Reabre o modal de horários (se quiser)
			var modalHorarios = new bootstrap.Modal(document.getElementById('modalHorarios'));
			modalHorarios.show();
		}

		document.getElementById('btnSalvarObservacao').addEventListener('click', function () {
			let observacao = document.getElementById('observacaoInput').value;
			document.getElementById('observacaoHidden').value = observacao;
		});

	</script>

</body>

</html>