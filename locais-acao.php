<?php include('conexao.php');

$id = $_POST["txtId"];
$nome = $_POST["txtNome"];
$status = $_POST["txtStatus"];

if (!$nome) {
    echo "<script>alert('Campo nome Obrigatório!'); history.back();</script>";
    exit; // Impede a execução do restante
} else {

    if (!$id) {
        //inserir
        $sql = $conn->prepare("
                        insert into locais set nome='$nome',
                                            status='$status'
    ");
        $sql->execute();
    } else {
        //atualizar
        $sql = $conn->prepare("
    update locais set nome='$nome',
                      status='$status' where id='$id'
    ");
        $sql->execute();
    }
}
header("location:locais-pesquisar.php");
