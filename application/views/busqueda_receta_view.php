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
                    <?php
                        if(isset($results))
                        foreach ($results as $k => $v) 
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
                                        <tr><td><strong>Autor</strong></td><td><a href="<?php echo base_url('index.php/usuario/perfil/'.$this->user->get_username($v['id_autor']))?>"><?=$this->user->get_username($v['id_autor'])?></a></td></tr>
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
 	</body>

</html>