<?php
require("conexao.php");

$id = $_POST["txtid"];
$local = $_POST["txtlocais"];
$data_inicio = $_POST["txtDataInicio"];
$data_final = $_POST["txtDataFinal"];
$obs = $_POST["txtObs"];

echo $data_inicio;

if ($local == 0) {
    echo "<script>alert('Campo local Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
} else {
    if (!$data_inicio || !$data_final) {
        echo "<script>alert('Campo data de inicio e fim Obrigatório!'); history.back();</script>";
        exit; // Impede a execução do restante
    } else {
            if($data_inicio > $data_final){
            echo "<script>alert('Você deve selecionar uma data inicial anterior a data final.'); history.back();</script>";
            exit; // Impede a execução do restante
            } else {

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
        }
    }    


header("location: agendas-pesquisar.php");
