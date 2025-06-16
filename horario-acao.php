<?php
require("conexao.php");


$secretaria = $_POST["txtSecretaria"];
$aulas = $_POST["txtAulas"];


    $sql = $conn->prepare("INSERT INTO horarios SET secretaria='$secretaria',
                                                     aulas='$aulas'
                                                    ");
    $sql->execute();

   


header("location: horario-editar.php");
