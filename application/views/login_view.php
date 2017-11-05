<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cookify</title>
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
        <div class="title-page"><!--Cookify--><?php echo "<img src='".base_url("assets/images/logo.png")."' width='600' height='250' style='-webkit-filter: drop-shadow(5px 5px 5px #000000); filter: drop-shadow(5px 5px 5px #000000);'/>"?></div>

        <div class="login-body">
            <article class="container-login center-block">
                <section>
                    <!--<ul id="top-bar" class="nav nav-tabs nav-justified">
                        <li class="active"><a href=""><h2>Login<</a></li>
                        <li><a href="<?php echo base_url("index.php/forgotpassword"); ?>">¿Olvidaste la contraseña?</a></li>
                    </ul>-->
                    <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
                        <div id="login-access" class="tab-pane fade active in">
                            <h2><i class="glyphicon glyphicon-user"></i> Login</h2>                     
                                 <?php 
                                    echo validation_errors();
                                    echo form_open('index.php/login/verify');
                                    if(isset($error))
                                        echo "<div class='alert alert-danger'>
                                                $error
                                        </div>"
                                ?>
                                <div class="form-group ">
                                    <label for="login" class="sr-only">Username</label>
                                        <input type="text" class="form-control" name="username" id="login_value" 
                                            placeholder="Usuario" tabindex="1" value="" required />
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="sr-only">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Contraseña" value="" tabindex="2" required />
                                </div>
                                <br/>
                                <div class="form-group">               
                                        <button type="submit" name="log-me-in" id="btn-login" tabindex="5" class="btn-orange">Entra</button>
                                </div>
                            </form>   
                            <a href="<?php echo base_url("index.php/register"); ?>"><button type="submit" name="log-me-in" id="btn-register" tabindex="5" class="btn-blue">Registro</button></a>      
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</body>
</html>