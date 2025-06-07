<?php include("login-validar.php"); ?>

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
					<div class="row">
						<h3>SISTEMA DE ANGENDAMENTOS</h3>
					</div>
					<div class="row">
						<div class="col-10 ">
						</div>
						<div class="col-2 col-xs-12">
							<div class="card">
								<div class="row mb-1"><a href="noticias-cadastro.php" class="btn btn-primary">Adicionar Noticias</a></div>
								<div class="row"><a href="cursos-cadastro.php" class="btn btn-success">Adicionar Cursos</a></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-sm-6">
										<div class="card">
											<div class="card-body">
												<div id="redial"></div>
												<span class="right-sign">
													<svg width="93" height="93" viewBox="0 0 93 93" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<g filter="url(#filter0_d_3_700)">
															<circle cx="46.5" cy="31.5" r="16.5" fill="#F8B940" />
														</g>
														<g clip-path="url(#clip0_3_700)">
															<path
																d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
																fill="#222B40" />
														</g>
														<defs>
															<filter id="filter0_d_3_700" x="0" y="0" width="93"
																height="93" filterUnits="userSpaceOnUse"
																color-interpolation-filters="sRGB">
																<feFlood flood-opacity="0"
																	result="BackgroundImageFix" />
																<feColorMatrix in="SourceAlpha" type="matrix"
																	values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
																	result="hardAlpha" />
																<feOffset dy="15" />
																<feGaussianBlur stdDeviation="15" />
																<feComposite in2="hardAlpha" operator="out" />
																<feColorMatrix type="matrix"
																	values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
																<feBlend mode="normal" in2="BackgroundImageFix"
																	result="effect1_dropShadow_3_700" />
																<feBlend mode="normal" in="SourceGraphic"
																	in2="effect1_dropShadow_3_700" result="shape" />
															</filter>
															<clipPath id="clip0_3_700">
																<rect width="24" height="24" fill="white"
																	transform="translate(35 19)" />
															</clipPath>
														</defs>
													</svg>
												</span>
												<div class="redia-date text-center">
													<h4>My Progress</h4>
													<p>
														Lorem ipsum dolor sit amet, consectetur
													</p>
													<a href="crm.html" class="btn btn-secondary text-black">More
														Details</a>
												</div>
											</div>

										</div>
									</div>
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