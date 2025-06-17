<?php
session_start();
$user_name = "Sofia Vasiak";

// Salas fixas
$salas = ['Sala 101', 'Sala 102', 'Sala 103'];

// Horários escolares (sem 12h)
$horarios = ['07:00', '08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

// Agendamentos na sessão simulando reserva
if (!isset($_SESSION['agendamentos'])) {
    $_SESSION['agendamentos'] = [];
}

// Reservar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $sala = $_POST['sala'];
    $hora = $_POST['hora'];
    $_SESSION['agendamentos'][] = ['data' => $data, 'sala' => $sala, 'hora' => $hora, 'usuario' => $user_name];
}

// Buscar agendamentos
function getReservas($data, $sala)
{
    $agendamentos = $_SESSION['agendamentos'];
    $horariosOcupados = [];
    foreach ($agendamentos as $ag) {
        if ($ag['data'] === $data && $ag['sala'] === $sala) {
            $horariosOcupados[$ag['hora']] = $ag['usuario'];
        }
    }
    return $horariosOcupados;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agendamento de Salas</title>

    <!-- Bootstrap CSS & FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">



    <style>
        .fc-daygrid-day-frame {
            cursor: pointer;
        }
    </style>
</head>

<body>



    <header class="bg-success text-white p-3">
        <div class="container d-flex justify-content-between">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    ☰
            </div>
            <h1 class="h4">Agendamento de Salas</h1>
            <span>Bem-vindo, <?php echo $user_name; ?>!</span>
        </div>
    </header>



    <!-- Menu lateral (offcanvas responsivo) -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasMenu"
        aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel"><i class="bi bi-grid-fill me-2"></i>Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <a class="nav-link text-white mb-2" href="dashboard.php"><i class="bi bi-house-door me-2"></i>Dashboard</a>
            <a class="nav-link text-white mb-2" href="laboratorios.php"><i
                    class="bi bi-beaker me-2"></i>Laboratórios</a>
            <a class="nav-link text-white mb-2" href="professores.php"><i
                    class="bi bi-person-vcard me-2"></i>Professores</a>
            <a class="nav-link text-white mb-2" href="agendamentos.php"><i
                    class="bi bi-calendar3 me-2"></i>Agendamentos</a>

            <div class="mt-auto">
                <a href="logout.php" class="btn btn-outline-light w-100 mb-2"><i
                        class="bi bi-box-arrow-right me-2"></i>Sair</a>
            </div>
        </div>
    </div>


    <main class="container my-4">
        <div id="calendar"></div>
    </main>



    <!-- Modal Salas -->
    <div class="modal fade" id="modalSalas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salas disponíveis para <span id="dataSelecionada"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($salas as $sala): ?>
                        <button class="btn btn-outline-primary w-100 my-1 sala-btn" data-sala="<?php echo $sala; ?>">
                            <?php echo $sala; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Horários -->
    <div class="modal fade" id="modalHorarios" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Horários disponíveis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="data" id="inputData" />
                    <input type="hidden" name="sala" id="inputSala" />
                    <div class="list-group" id="horariosList">
                        <!-- Horários serão inseridos via JS -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS & FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        let dataSelecionada = '';
        const modalSalas = new bootstrap.Modal(document.getElementById('modalSalas'));
        const modalHorarios = new bootstrap.Modal(document.getElementById('modalHorarios'));

        document.addEventListener('DOMContentLoaded', function () {
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                dateClick: function (info) {
                    dataSelecionada = info.dateStr;
                    document.getElementById('dataSelecionada').innerText = dataSelecionada;
                    modalSalas.show();
                    document.querySelectorAll('.sala-btn').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const sala = this.dataset.sala;
                            document.getElementById('inputData').value = dataSelecionada;
                            document.getElementById('inputSala').value = sala;

                            const horarios = <?php echo json_encode($horarios); ?>;
                            const reservas = <?php echo json_encode($_SESSION['agendamentos']); ?>;
                            const ocupados = {};
                            reservas.forEach(res => {
                                if (res.data === dataSelecionada && res.sala === sala) {
                                    ocupados[res.hora] = res.usuario;
                                }
                            });

                            const list = document.getElementById('horariosList');
                            list.innerHTML = '';

                            horarios.forEach(horario => {
                                const ocupado = ocupados[horario];
                                const label = ocupado
                                    ? `<button class="list-group-item list-group-item-danger disabled">${horario} - Ocupado por ${ocupado}</button>`
                                    : `<button type="submit" name="hora" value="${horario}" class="list-group-item list-group-item-action">${horario} - Reservar</button>`;
                                list.innerHTML += label;
                            });

                            modalSalas.hide();
                            modalHorarios.show();
                        });
                    });

                }
            });
            calendar.render();
        });

        document.querySelectorAll('.sala-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const sala = this.dataset.sala;
                document.getElementById('inputData').value = dataSelecionada;
                document.getElementById('inputSala').value = sala;

                // Horários disponíveis hardcoded no PHP também
                const horarios = <?php echo json_encode($horarios); ?>;
                const reservas = <?php echo json_encode($_SESSION['agendamentos']); ?>;
                const ocupados = {};
                reservas.forEach(res => {
                    if (res.data === dataSelecionada && res.sala === sala) {
                        ocupados[res.hora] = res.usuario;
                    }
                });

                const list = document.getElementById('horariosList');
                list.innerHTML = '';

                horarios.forEach(horario => {
                    const ocupado = ocupados[horario];
                    const label = ocupado
                        ? `<button class="list-group-item list-group-item-danger disabled">${horario} - Ocupado por ${ocupado}</button>`
                        : `<button type="submit" name="hora" value="${horario}" class="list-group-item list-group-item-action">${horario} - Reservar</button>`;
                    list.innerHTML += label;
                });

                modalSalas.hide();
                modalHorarios.show();
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>