<?php
require("conexao.php");

$id = $_POST["txtid"];
$local = $_POST["txtlocais"];
$data_inicio = $_POST["txtDataInicio"];
$data_final = $_POST["txtDataFinal"];
$obs = $_POST["txtObs"];
    
if ($local == 0) {
    echo "<script>alert('Você deve selecionar um local válido.'); history.back();</script>";
    exit; // Impede a execução do restante
}else {

    if (!$id) {
    $sql = $conn->prepare("INSERT INTO agendas SET local_id='$local',
                                                     data_inicio='$data_inicio',
                                                     data_fim='$data_final',
                                                     observacao='$obs'
                                                    ");
    $sql->execute();

    } else {
    $sql = $conn->prepare("UPDATE agendas SET local_id='$local',
                                                     data_inicio='$data_inicio',
                                                     data_fim='$data_final',
                                                     observacao='$obs'
                                                    where id='$id'
                                                    ");
    $sql->execute();

    }
}

header("location: agendas-pesquisar.php");
?>