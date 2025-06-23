<?php
 session_start();
include "conexao.php";

$usuario_id = $_SESSION['usuario_id'] ?? null;
$observacao = $_POST['txtObservacao'] ?? '';
$local = $_POST['txtLocal'] ?? '';
$data = $_POST['txtData'] ?? '';
$horario = $_POST['txtHorario'] ?? '';
$id = $_POST['txtid'] ?? '';
$nomeVariavel = 'horariofin';
$dataMod = new DateTime($horario);
$dataMod->modify('+50 minutes');
$$nomeVariavel = $dataMod->format('H:i:s');


// Converter data de dd/mm/yyyy para yyyy-mm-dd se necessário
if (strpos($data, '/') !== false) {
    $partes = explode('/', $data);
    $data = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
}

// Verificar campos obrigatórios
if (empty($local) || empty($data) || empty($horario)) {
    echo "Erro: Campos obrigatórios faltando.";
    exit;
}

// Verifica se o usuário esta logado
if (!$usuario_id) {
    echo "Erro: Usuário não está logado.";
    exit;
}

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

if (empty($id)) {
    // Se não tiver ID → INSERT
    $sql = $conn->prepare("
    INSERT INTO agendas (local_id, data, horario, horariofin, observacao) 
    VALUES (:local, :data, :horario, :horariofin, :observacao)
");
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
    // Se tiver ID → UPDATE
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

    if ($sql->execute()) {
        echo "Agendamento atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar agendamento.";
    }
}
