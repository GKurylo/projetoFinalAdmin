<?php
session_start();
include "conexao.php";

$usuario_id = $_SESSION['usuario_id'] ?? null;
$id = $_POST['txtid'] ?? null;
$data = $_POST['txtData'] ?? '';
$horarioArray = $_POST['txtHorario'] ?? [];
$local = $_POST['txtLocal'] ?? '';
$observacao = $_POST['txtObservacao'] ?? '';

// Se for array, junta os horários numa string separada por vírgula
if (is_array($horarioArray)) {
    $horario = implode(',', $horarioArray);
} else {
    $horario = $horarioArray;
}

if (!$data || !$horario || !$local) {
    http_response_code(400);
    exit("Erro: Dados incompletos ou usuário não logado.");
}

// Converte data para formato YYYY-MM-DD se estiver com barras
if (strpos($data, '/') !== false) {
    [$d, $m, $y] = explode('/', $data);
    $data = "$y-$m-$d";
}

// Calcula final do último horário (+50 min do último horário escolhido)
try {
    $horariosExplodidos = explode(',', $horario);
    $ultimoHorario = end($horariosExplodidos);
    $dt = new DateTime($ultimoHorario);
    $dt->modify('+50 minutes');
    $horariofin = $dt->format('H:i:s');
} catch (Exception $e) {
    $horariofin = $ultimoHorario ?? '';
}

// Se for edição
if (!empty($id)) {
    $sql = $conn->prepare("
        UPDATE agendas SET 
            local_id = :local, 
            data = :data, 
            horario = :horario, 
            horariofin = :horariofin, 
            observacao = :obs 
        WHERE id = :id
    ");
    $res = $sql->execute([
        ':local' => $local,
        ':data' => $data,
        ':horario' => $horario,
        ':horariofin' => $horariofin,
        ':obs' => $observacao,
        ':id' => $id
    ]);
} else {
    // Verifica agendamento duplicado apenas para novos registros
    $sqlVal = $conn->prepare("SELECT COUNT(*) FROM agendas WHERE local_id=:loc AND data=:d AND horario=:h");
    $sqlVal->execute([':loc' => $local, ':d' => $data, ':h' => $horario]);
    if ($sqlVal->fetchColumn() > 0) {
        http_response_code(409);
        exit("Erro: Horário já ocupado.");
    }

    // INSERIR
    $sql = $conn->prepare("
        INSERT INTO agendas (local_id, data, horario, horariofin, observacao)
        VALUES (:loc, :d, :h, :hf, :obs)
    ");
    $res = $sql->execute([
        ':loc' => $local,
        ':d' => $data,
        ':h' => $horario,
        ':hf' => $horariofin,
        ':obs' => $observacao
    ]);
}

if ($res) {
    header("Location: agendas-pesquisar.php");
    exit;
} else {
    http_response_code(500);
    echo "Erro ao salvar.";
}
