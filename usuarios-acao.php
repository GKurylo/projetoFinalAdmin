<?php
require("conexao.php");

$id = $_POST["txtid"];
$nome = $_POST["txtNome"];
$senha = $_POST["txtSenha"];
$usuario = $_POST["txtUsuario"];
$cargo = $_POST["txtCargo"];
$status = $_POST["txtStatus"];

if (!$id) {
    $sql = $conn->prepare("INSERT INTO usuarios SET nome='$nome',
                                                     senha='$senha',
                                                     usuario='$usuario',
                                                     cargo='$cargo',
                                                     status='$status'
                                                    ");
    $sql->execute();

} else {
    $sql = $conn->prepare("UPDATE usuarios SET nome='$nome',
                                                    senha='$senha',
                                                    usuario='$usuario',
                                                    cargo='$cargo',
                                                    status='$status'
                                                    WHERE id='$id'
                                                    ");
    $sql->execute();

}

header("location: usuarios-pesquisar.php");
?>