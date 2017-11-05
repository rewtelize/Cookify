<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Registro - Cookify</title>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/estilo.css"); ?>" />
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
                            <h2><i class="glyphicon glyphicon-log-in"></i> Registro Válido</h2>                     
                                <div class="profile-picture-box">
                                    <div style="width: 50%; margin: 0 auto; text-align: center;"> 
                                    <?php echo '<img id="profile-preview" width="100" height="100" src="data:image/jpeg;base64,'.base64_encode($pp).'" alt=""/>';?></div><br><br>
                                    <div class="alert alert-success" style="text-align: center">
                                    <strong>Gracias, <?php echo $u?></strong>
                                    </div>
                                </div>
                        </div>
                        <?php echo form_open('index.php/home'); ?>
                        <button type="submit" name="log-me-in" id="btn-login" tabindex="5" class="btn-orange">Ir a Inicio</button>
                        </form>
                               
                    </div>
                </section>
            </article>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</body>
</html>