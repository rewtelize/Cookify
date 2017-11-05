<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
   		<title>Home - Cookify</title>
   		<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/home.css"); ?>" />
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
    <?php
        $session_data = $this->session->userdata('logged_in');
    ?>
	<body id="home-body">
	<div class="background-image"></div>
	<div class="foreground">
        <a href="#top"><div class="btn-top"><i class="glyphicon glyphicon-chevron-up top"></i></div></a>
		<div class="container" id="top">
	      	<div class="page-header" id="home-header">
	         	<div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
        			<div class="navbar-header"><a class="navbar-brand" href="<?php echo base_url('/')?>">Cookify</a>
       					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            			</button>
        			</div>
        			<div class="collapse navbar-collapse navbar-menubuilder">
			            <ul class="nav navbar-nav navbar-left">
			                <li><a href="<?php echo base_url('/')?>">Home</a></li>
			            </ul>
			            <ul class="nav navbar-nav navbar-right">
				            <li style="margin-right: 50px"><a href="<?php echo base_url("index.php/home/logout"); ?>"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>
				        </ul>
        			</div>
				</div>
	      	</div>
	      	<div class="row">
	      		<!------------------------------------- Parte de USUARIO -------------------------------------------->
	  			<div class="col-md-3 comun-barra well" id="barra-izquierda">	
	  				<div class="col-md-12">
			  			<div class="media">
						 	<div class="media-left">
						    	<?php echo "<img id='img_profile' src='data:image/jpeg;base64,".base64_encode( $session_data['pp'] )."'/>";?>
						  	</div>
						  	<div class="media-body" style="text-align: center">
						    	<h2 class="media-heading"><?php echo $session_data['u'] ?></h2>
						    	<p><?php echo $session_data['e'] ?></p>
						    	<a href="<?php echo base_url('index.php/usuario/perfil/'.$session_data['u'])?>"><button type="submit" name="log-me-in" id="btn-profile" class="btn-blue">Perfil</button></a>
						  	</div>
						</div>
					</div>
					<div class="col-md-12" style="padding: 5px">
						<a href="<?php echo base_url('index.php/recetas')?>"><button type="submit" name="nueva_receta" id="btn-login" class="btn-orange">Nueva receta</button></a>
					</div>
					<div class="row gen-info" style="text-align: center">
			  			<div class="col-md-4">Recetas<br><a href="<?php echo base_url('index.php/recetas/ver_recetas')?>"><?php echo $session_data['num_recetas']?></a></div>
                        <div class="col-md-4">Seguidores<br><a href="<?php echo base_url('index.php/usuario/ver_seguidores')?>"><?php echo $session_data['num_seguidores']?></a></div>
                        <div class="col-md-4">Siguiendo<br><a href="<?php echo base_url('index.php/usuario/ver_siguiendo')?>"><?php echo $session_data['num_siguiendo']?></a></div>
			  		</div>
                    <div class="col-md-12" style="text-align: center">
                    <h3>Busqueda de usuarios</h3>
                        <form action="<?php echo base_url('index.php/usuario/busqueda') ?>" method="POST">
                            <input type="text" class="form-control" value="" placeholder="Nombre de usuario" name="usuario">
                            <button style="margin-top: 10px" type="submit" name="boton" id="btn-login" class="btn-orange">Buscar</button>
                        </form>
                    </div>
	  			</div>

	  			<!------------------------------------- Parte de Perfil -------------------------------------------->
    			<div class="col-md-9 comun-barra well" id="barra-central" style="text-align: center">
                    <div class="col-md-12">
                        <?php echo "<img  style='border-radius: 10px' width='200' height='200' id='img_profile' src='data:image/jpeg;base64,".base64_encode( $perfil_info['foto'] )."'/>";?>
                    </div>
                    <div class="col-md-12">
                            <h2><?=$perfil_info['nombre']?></h2>
                            <h3><?=$perfil_info['email']?></h3>
                    </div>
                    <div class="col-md-12 gen-info">
                            <div class="col-md-4">Recetas<br><a href="<?php echo base_url('index.php/recetas/ver_recetas/'.$perfil_info['nombre'])?>"><?php echo $info['num_recetas']?></a></div>
                        <div class="col-md-4">Seguidores<br><a href="<?php echo base_url('index.php/usuario/ver_seguidores/0/'.$perfil_info['nombre'])?>"><?php echo $info['num_seguidores']?></a></div>
                        <div class="col-md-4">Siguiendo<br><a href="<?php echo base_url('index.php/usuario/ver_siguiendo/0/'.$perfil_info['nombre'])?>"><?php echo $info['num_siguiendo']?></a></div>
                            <?php
                                if($info['es_el_mismo'] == 1 || $info['es_admin'] == 1) 
                                {
                            ?>
                                    <?php
                                        if($nuevo["error"] != "") 
                                        {
                                    ?>
                                        <div class="col-md-12">
                                            <div class='alert alert-danger'>
                                                <?=$nuevo["error"]?>
                                            </div>
                                        </div>
                                    <?php    
                                        }
                                        echo form_open_multipart('index.php/usuario/perfil/'.$perfil_info['nombre']);
                                    ?>
                                    <div class="col-md-12 profile-picture-box" style="margin-top: 10px; margin-bottom: 10px;">
                                    <h3> Actualizar foto de perfil </h3>
                                        <div style="width: 100px; height: 100px; margin: 0 auto; text-align: left;"> <img id="profile-preview" width="100" height="100" src="<?php echo base_url("assets/images/default-pp.png"); ?>" alt="">
                                        </div>
                                    </div>
                                    <input required type='file' id="profile-picture" name="pp-picture" value='' />
                                    <button style="margin-top: 10px" type="submit" class="btn btn-success btn-borrar">Actualizar</button>
                                    </form>
                                    <div class="col-md-4">
                                        <form action="<?php echo base_url('index.php/usuario/perfil/'.$perfil_info['nombre'])?>" method="POST">
                                            <h3>Actualizar nombre</h3>
                                            <input required value="<?=$nuevo['u']?>" placeholder="Nuevo nombre" type="text" class="form-control" name="nuevo-nombre">
                                            <button style="margin-top: 10px" type="submit" class="btn btn-success btn-borrar">Actualizar</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <form action="<?php echo base_url('index.php/usuario/perfil/'.$perfil_info['nombre'])?>" method="POST">
                                            <h3>Actualizar contraseña</h3>
                                            <input value="<?=$nuevo['p1']?>" pattern=".{8,}"   required title="8 caracteres minimo" placeholder="Nueva contraseña" type="password" class="form-control" name="nuevo-password1">
                                            <input value="<?=$nuevo['p2']?>" pattern=".{8,}"   required title="8 caracteres minimo" placeholder="Repita contraseña" type="password" class="form-control" name="nuevo-password2">
                                            <button style="margin-top: 10px" type="submit" class="btn btn-success btn-borrar">Actualizar</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <form action="<?php echo base_url('index.php/usuario/perfil/'.$perfil_info['nombre'])?>" method="POST">
                                            <h3>Actualizar e-mail</h3>
                                            <input value="<?=$nuevo['e1']?>" required placeholder="Nuevo e-mail" type="email" class="form-control" name="nuevo-email1">
                                            <input value="<?=$nuevo['e2']?>" required placeholder="Repita e-mail" type="email" class="form-control" name="nuevo-email2">
                                            <button style="margin-top: 10px" type="submit" class="btn btn-success btn-borrar">Actualizar</button>
                                        </form>
                                    </div>

                                    <div class="col-md-12" style="text-align: right; margin-top: 10px">
                                    <form action=" <?php echo base_url('index.php/usuario/borrar_usuario'); ?>" method="POST">
                                        <input type="hidden" name="usuario" value="<?php echo $perfil_info['nombre'];?>">
                                        <button type="submit" class='btn btn-danger'>Borrar usuario</button>
                                    </form>
                                    </div>
                            <?php
                                }
                                else
                                    if($info['lo_sigo'] == 1)
                                        echo "<a href='".base_url('index.php/usuario/dejar_de_seguir/'.$perfil_info['nombre'])."'><button type='submit' class='btn btn-danger'>Dejar de seguir</button></a>";
                                    else
                                        echo "<a href='".base_url('index.php/usuario/seguir/'.$perfil_info['nombre'])."'><button type='submit' class='btn btn-success'>Seguir</button></a>";
                            ?>

                    </div>
                    <?php
                        if(isset($recetas))
                        foreach ($recetas as $k => $v) 
                        {
                    ?>

                            <div class="col-md-6 well" id="bloque-timeline">
                                <div class="col-md-12" id="titulo-timeline">
                                    <?=$v['nombre']?>        
                                </div>
                                <div class="col-md-6">
                                    <?php echo "<img id='image-timeline' src='data:image/jpeg;base64,".base64_encode($v['foto'])."'/>";?>
                                </div>
                                <div class="col-md-6 datos-timeline">
                                    <table>
                                        <tr><td><strong>Autor</strong></td><td><a href="<?php echo base_url('index.php/usuario/perfil/'.$perfil_info['nombre'])?>"><?=$perfil_info['nombre']?></a></td></tr>
                                        <tr><td><strong>Dificultad</strong></td>
                                                                    <td> <?php 
                                                                        switch ($v['dificultad'])
                                                                        {
                                                                            case "1" : echo "<span class='label label-success'>Fácil</span>";break;
                                                                            case "2" : echo "<span class='label label-warning'>Media</span>";break;
                                                                            case "3" : echo "<span class='label label-danger'>Difícil</span>";break;
                                                                        }
                                                                        ?>
                                                                    </td></tr> 
                                        <tr><td><strong>Tipo</strong></td><td> <?=$v['tipo']?></td></tr>
                                        <tr><td><strong>Fecha</strong></td><td> <?=$v['fecha']?></td></tr>
                                        <tr><td><strong>Valoraciones</strong></td><td> <?=$v['num_valoraciones']?> <i class="glyphicon glyphicon-user"></i></td></tr>
                                        <tr><td><strong>Valoracion media</strong> 
                                    </table>
                                    <div class="progress">
                                    <?php
                                        $pct_valoracion = 20 * $v['valoracion'];
                                        $barra_valoracion;
                                        if(intval($v['valoracion']) < 2)
                                            $barra_valoracion = "<div class='progress-bar progress-bar-danger' ";
                                        else if(intval($v['valoracion']) < 4)
                                            $barra_valoracion = "<div class='progress-bar progress-bar-warning' ";
                                        else 
                                            $barra_valoracion = "<div class='progress-bar progress-bar-success' ";

                                       $barra_valoracion = $barra_valoracion . 
                                       "role='progressbar' aria-valuenow='".$v['valoracion']."' aria-valuemin='1' aria-valuemax='5' style='width: $pct_valoracion%'>".
                                                    $v['valoracion']."
                                        </div>";

                                        echo $barra_valoracion;
                                    ?>
                                    </div>
                                    <?php $url = base_url('index.php/recetas/ver_receta/'.$v['id']); ?>
                                    <a href="<?=$url?>"><button type="submit" name="nueva_receta" class="btn-blue">Ampliar receta</button></a>
                                </div>
                            </div>

                        
                    <?php
                        }
                    ?>
                <div class="col-md-12">
                    <p><?php echo $links; ?></p>
                </div>
                </div>

                </div>
			</div>
	    </div>
   </div>
   <script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-formhelpers.min.js"); ?>"></script>
   <script type="text/javascript">
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

$(".chosen-select").chosen();
   </script>
 	</body>

</html>