<?php
require("conexao.php");

$id = $_POST["txtid"];
$local = $_POST["txtlocais"];
$data_inicio = $_POST["txtDataInicio"];
$data_final = $_POST["txtDataFinal"];
$obs = $_POST["txtObs"];

if ($local == 0) {
    echo "<script>alert('Campo local Obrigatório!'); history.back();</script>";
    exit;
}

if ($data_inicio == $data_final) {
    echo "<script>alert('Campo data de inicio e fim não podem ser iguais!'); history.back();</script>";
    exit;
}

if (!$data_inicio || !$data_final) {
    echo "<script>alert('Campo data de inicio e fim Obrigatório!'); history.back();</script>";
    exit;
}

if ($data_inicio > $data_final) {
    echo "<script>alert('Você deve selecionar uma data inicial anterior à data final.'); history.back();</script>";
    exit;
}

// Verificar conflitos de agendamento
$sql_verificar = $conn->prepare("
    SELECT * FROM agendas 
    WHERE local_id = :local 
      AND id != :id
      AND (
            (data_inicio <= :data_final AND data_fim >= :data_inicio)
          )
");
$sql_verificar->bindParam(":local", $local);
$sql_verificar->bindParam(":id", $id);
$sql_verificar->bindParam(":data_inicio", $data_inicio);
$sql_verificar->bindParam(":data_final", $data_final);
$sql_verificar->execute();

if ($sql_verificar->rowCount() > 0) {
    echo "<script>alert('Já existe um agendamento para este local nesse período. Escolha outro horário.'); history.back();</script>";
    exit;
}

// Inserir ou atualizar
if (!$id) {
    $sql = $conn->prepare("INSERT INTO agendas (local_id, data_inicio, data_fim, observacao) 
                           VALUES (:local, :data_inicio, :data_final, :obs)");
} else {
    $sql = $conn->prepare("UPDATE agendas SET local_id = :local, data_inicio = :data_inicio, data_fim = :data_final, observacao = :obs 
                           WHERE id = :id");
    $sql->bindParam(":id", $id);
}

$sql->bindParam(":local", $local);
$sql->bindParam(":data_inicio", $data_inicio);
$sql->bindParam(":data_final", $data_final);
$sql->bindParam(":obs", $obs);
$sql->execute();

header("Location: agendas-pesquisar.php");
exit;
?>
