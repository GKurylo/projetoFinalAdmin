<!DOCTYPE html>
<html lang="pt-BR" class="h-100">


<head>
    <?php include("app-header.php"); ?>
     <title>LOGIN</title>
</head>

<body style="background-image:url('images/bg.png'); background-position:center;">
    <div class="authincation fix-wrapper">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <img src="images/logo/logo-full.png" alt="">
                                    </div>



                                    <h4 class="text-center mb-4">Area Restrita</h4>
                                    <form action="login-acao.php" method="POST">
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Usuário:</label>
                                            <input type="text" class="form-control" placeholder="Usuário" id="usuario" name="txtUsuario">
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="dz-password">Senha:</label>
                                            <input type="password" class="form-control" placeholder="Senha" id="password" name="txtSenha">
                                        </div> <br>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                                        </div>
                                    </form>





                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("app-script.php"); ?>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>