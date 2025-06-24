<?php
include "login-validar.php";
include "conexao.php";

$usuario_id = $_SESSION['id'] ?? null;
$observacao = $_POST['txtObservacao'] ?? '';
$local = $_POST['txtLocal'] ?? '';
$data = $_POST['txtData'] ?? '';
$horario = $_POST['txtHorario'] ?? '';
$id = $_POST['txtid'] ?? '';

// Calcula o horário final (+50 minutos)
$dataMod = new DateTime($horario);
$dataMod->modify('+50 minutes');
$horariofin = $dataMod->format('H:i:s');

// Converter data de dd/mm/yyyy para yyyy-mm-dd
if (strpos($data, '/') !== false) {
    $partes = explode('/', $data);
    $data = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
}

// Validação de campos obrigatórios 
if (empty($local) || empty($data) || empty($horario) || empty($horariofin)) {
    echo "Erro: Campos obrigatórios faltando.";
    exit;
}

// Verifica se o usuário está logado
if (!$usuario_id) {
    echo "Erro: Usuário não está logado.";
    exit;
}

// Verifica se o horário já está ocupado
$verifica = $conn->prepare("
    SELECT COUNT(*) FROM agendas
    WHERE local_id = :local AND data = :data AND horario = :horario
");
$verifica->bindParam(":local", $local);
$verifica->bindParam(":data", $data);
$verifica->bindParam(":horario", $horario);
$verifica->execute();
$existe = $verifica->fetchColumn();

if ($existe > 0) {
    echo "Erro: Este horário já está ocupado para o local selecionado.";
    exit;
}

// INSERT ou UPDATE
if (empty($id)) {
    // INSERT
    echo "Indo fazer INSERT...";
    $sql = $conn->prepare("
    INSERT INTO agendas (usuario_id, local_id, data, horario, horariofin, observacao) 
    VALUES (:usuario_id, :local, :data, :horario, :horariofin, :observacao)
");
    $sql->bindParam(":usuario_id", $usuario_id);
    $sql->bindParam(":local", $local);
    $sql->bindParam(":data", $data);
    $sql->bindParam(":horario", $horario);
    $sql->bindParam(":horariofin", $horariofin);
    $sql->bindParam(":observacao", $observacao);

    if ($sql->execute()) {
        echo "Agendado com sucesso!";
    } else {
        echo "Erro ao salvar agendamento.";
    }
} else {
    // UPDATE
    $sql = $conn->prepare("
        UPDATE agendas
        SET local_id = :local, data = :data, horario = :horario, horariofin = :horariofin, observacao = :observacao
        WHERE id = :id
    ");
    $sql->bindParam(":local", $local);
    $sql->bindParam(":data", $data);
    $sql->bindParam(":horario", $horario);
    $sql->bindParam(":horariofin", $horariofin);
    $sql->bindParam(":observacao", $observacao);
    $sql->bindParam(":id", $id);
}

if ($sql) {
    header("Location: agendas-pesquisar.php");
    exit;
} else {
    http_response_code(500);
    echo "Erro ao salvar.";
}

exit;
?>