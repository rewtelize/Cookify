<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Registro - Cookify</title>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/estilo.css"); ?>" />
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        <link rel="icon" href="/favicon.png" type="image/png">
        <?php include("random-bg.php");?>
        <style type="text/css">
            .background-image {
                <?php echo "background-image: url(".base_url("assets/images/$selectedBg").")"; ?>
            }
        </style>
    </head>
<body>
   <div class="background-image"></div>
    <div class="content">
        <div class="login-body">
            <article class="container-login center-block">
                <section>
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
                        <div id="login-access" class="tab-pane fade active in">
                            <h2><i class="glyphicon glyphicon-log-in"></i> Registro</h2>                     
                                <?php 
                                    echo validation_errors();
                                    echo form_open_multipart('index.php/register/newuser');
                                ?>
                                <div class="profile-picture-box">
                                    <div style="width: 50%; margin: 0 auto; text-align: center;"> <img id="profile-preview" width="100" height="100" src="<?php echo base_url("assets/images/default-pp.png"); ?>" alt=""></div>
                                    <input type='file' id="profile-picture" name="profile-picture" value=''/>
                                    </div>
                                </div>
                                <?php
                                 if(isset($error))
                                        echo "<div class='alert alert-danger'>
                                                $error
                                            </div>"
                                ?>
                                <div class="form-group ">
                                    <label for="login" class="sr-only">Username</label>
                                        <!-- Nombre de usuario  -->
                                        <input type="text" class="form-control" name="username" id="login_value"
                                            placeholder="Usuario" tabindex="1" value="<?php if(isset($u)) echo $u?>" required />
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="sr-only">Password</label>
                                        <!-- Contraseña-->
                                        <input pattern=".{8,}"   required title="8 caracteres minimo" type="password" class="form-control" name="password" id="password"
                                            placeholder="Contraseña" value="<?php if(isset($p)) echo $p?>" tabindex="2" required /><br>
                                    <label for="password2" class="sr-only">Password</label>
                                        <!-- Repita contraseña-->
                                        <input pattern=".{8,}"   required title="8 caracteres minimo" type="password" class="form-control" name="password2" id="password2"
                                            placeholder="Repita contraseña" value="<?php if(isset($p2)) echo $p2?>" tabindex="2" required />
                                </div>
                                <div class="form-group ">
                                    <label for="email" class="sr-only">Email</label>
                                        <!-- E-mail-->
                                        <input type="email" class="form-control" name="email" id="login_value"
                                            placeholder="E-mail" value="<?php if(isset($e)) echo $e?>" tabindex="2" required /><br>
                                    <label for="password2" class="sr-only">Password</label>
                                        <!-- Repita e-mail-->
                                        <input type="email" class="form-control" name="email2" id="login_value"
                                            placeholder="Repita e-mail" value="<?php if(isset($e2)) echo $e2?>" tabindex="2" required />
                                </div>
                                <br/>              
                                <div class="form-group">               
                                    <button type="submit" name="log-me-in" id="btn-register" tabindex="5" class="btn-blue">Registrar</button>
                                </div>
                            </form>   
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) 
            {
                $('#profile-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-picture").change(function(){readURL(this);});
</script>
</body>
</html>