<?php 
include("conexao.php");
include("login-validar.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>INDEX</title>
	<?php include("app-header.php"); ?>
</head>

<body>

	<?php include("app-lateral.php"); ?>

	<!-- Conteudo -->
	<div class="content-body" style="min-height: 899px;">
		<div class="container-fluid">
			<div class="row">
				<div class="card p-2">
					<div class="row text-center">

						<!-- Botão 1 -->
						<div class="col-4 col-xs-12">
							<a href="noticias-cadastro.php" class="btn btn-success">
								<img src="images/127 Sem Título_20250616220559.png" class="img-fluid">
							</a>
						</div>

						<!-- Botão 2 -->
						<div class="col-4 col-xs-12">
							<a href="cursos-cadastro.php" class="btn btn-success">
								<img src="images/127 Sem Título_20250616211314.png" class="img-fluid">
							</a>
						</div>
						
						<!-- Botão 3 -->
						<div class="col-4 col-xs-12">
							<a href="albuns-cadastro.php" class="btn btn-success">
								<img src="images/127 Sem Título_20250618194711.png" class="img-fluid">
							</a>
						</div>
						
						<!-- Botão 4 -->
						<div class="offset-4 col-4 col-xs-12">
							<a href="horario-editar.php" class="btn btn-success mt-2">
								<i class="fas fa-plus-circle mr-2"></i>
								Editar horario
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include("app-footer.php"); ?>


	<?php include("app-script.php"); ?>

</body>


</html>