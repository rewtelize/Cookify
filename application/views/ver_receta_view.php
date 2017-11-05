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

	  			<!------------------------------------- Parte de RECETA -------------------------------------------->
    			<div class="col-md-9 comun-barra well receta-info" id="barra-central" style="text-align: center">
                <div class="col-md-12" id="titulo-receta">
                    <h2><?=$datos_receta['nombre']?></h2>
                </div>
                <div class="col-md-12">
                        <?php echo "<img id='image-receta' src='data:image/jpeg;base64,".base64_encode( $datos_receta['foto'] )."'/>";?>
                </div>
                <div class = "col-md-12" style="margin-top: 10px;">
                	<div class = "col-md-4">
                	 <table>
                        <tr style="text-align: left"><td><strong>Autor</strong></td><td><a href="<?php echo base_url('index.php/usuario/perfil/'.$this->user->get_username($datos_receta['id_autor']))?>"><?=$this->user->get_username($datos_receta['id_autor'])?></a></td></tr>
                        <tr style="text-align: left"><td ><strong>Dificultad</strong></td>
                        <td style="text-align: right"> <?php 
                            switch ($datos_receta['dificultad'])
                            {
                                case "1" : echo "<span class='label label-success'>Fácil</span>"; break;
                                case "2" : echo "<span class='label label-warning'>Media</span>"; break;
                                case "3" : echo "<span class='label label-danger'>Difícil</span>"; break;
                            }
                            ?>
                        </td></tr>
                    </table>
                    </div>
                    <div class = "col-md-4">
                    <table cellspacing = "10">
                    	<tr><td style="text-align: left"><strong>Tipo</strong></td><td style="text-align: right"> <?=$datos_receta['tipo']?></td></tr>
                        <tr><td style="text-align: left"><strong>Tiempo</strong></td><td style="text-align: right"> <?=$datos_receta['tiempo']?> minutos</td></tr>
                        <tr><td style="text-align: left"><strong>Fecha&nbsp;</strong></td><td style="text-align: right">&nbsp;<?=$datos_receta['fecha']?> </td></tr>
                    </table>
                    </div>
                    <div class = "col-md-4">
                        <table>
                            <tr style="text-align: left"><td><strong>Valoraciones</strong></td><td> <?=$datos_receta['num_valoraciones']?> <i class="glyphicon glyphicon-user"></i></td></tr>
                            <tr style="text-align: left"><td><strong>Valoracion media</strong></td></tr>
                        </table>
                        <div class="progress">
    	                    <?php
    	                        $pct_valoracion = 20 * $datos_receta['valoracion'];
    	                        $barra_valoracion;
    	                        if(intval($datos_receta['valoracion']) < 2)
    	                            $barra_valoracion = "<div class='progress-bar progress-bar-danger' ";
    	                        else if(intval($datos_receta['valoracion']) < 4)
    	                            $barra_valoracion = "<div class='progress-bar progress-bar-warning' ";
    	                        else 
    	                            $barra_valoracion = "<div class='progress-bar progress-bar-success' ";

    	                       $barra_valoracion = $barra_valoracion . 
    	                       "role='progressbar' aria-valuenow='".$datos_receta['valoracion']."' aria-valuemin='1' aria-valuemax='5' style='width: $pct_valoracion%'>".
    	                                    $datos_receta['valoracion']."
    	                        </div>";

    	                        echo $barra_valoracion;
    	                    ?>
                    	</div>
                    </div>
                    <?php
                        if($valoracion == false && $es_autor != 1)
                        {
                    ?>
                    <div class="col-md-4"></div>
                    <div class ="col-md-4">
                        <form action="<?php echo base_url('index.php/recetas/valorar/'.$datos_receta['id'])?>" method="POST">
                            <div class="input-group">
                            <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="valoracion">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                              <input type="text" name="valoracion" class="form-control input-number" value="5" min="1" max="5">
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="valoracion">
                                      <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                             </span>
                             </div>
                            <button type="submit" class="btn btn-success btn-borrar">Puntuar receta</button>
                        </form>
                    </div>

                    <?php 
                        }
                        else if($es_autor != 1)
                        {
                            echo "Su valoracion: ". $valoracion['puntuacion'];
                    ?>
                            <a href="<?php echo base_url('index.php/recetas/borrar_valoracion/'.$datos_receta['id'])?>"><button class='btn btn-danger btn-borrar'>Deshacer voto</button></a>
                    <?php
                        }
                    if($es_autor == 1) 
                    {
                        echo form_open_multipart('index.php/recetas/editar_receta/'.$datos_receta['id']);
                    ?>
                        <div class="col-md-12">
                        <div class="profile-picture-box" style="margin-top: -10px; margin-bottom: 10px;">
                            <div style="width: 300px; height: 100px; margin: 0 auto; text-align: left;"> <img id="profile-preview" width="300" height="100" src="<?php echo base_url("assets/images/bg1.jpg"); ?>" alt="">
                            </div>
                        </div>
                        <input type='file' id="profile-picture" name="receta-picture" value='' />
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4"> 
                                <h4>Nombre</h4>
                                <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre"/>
                            </div>
                            <div class="col-md-4"> 
                                <h4>Tiempo (minutos)</h4>
                                <div class="input-group">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="tiempo">
                                        <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                  <input type="text" name="tiempo" class="form-control input-number" value="0" min="1" max="120">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="tiempo">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-4"> 
                                <h4>Tipo</h4>
                                <select class="form-control" name="tipo">
                                    <option value=""></option>
                                    <option value="Desayuno">Desayuno</option>
                                    <option value="Almuerzo">Almuerzo</option>
                                    <option value="Merienda">Merienda</option>
                                    <option value="Cena">Cena</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                                <h4>Dificultad</h4>
                                <div class="col-md-4">
                                 <span class="label label-success"><input type="radio" name="dificultad" value="1"> Fácil</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="label label-warning"><input type="radio" name="dificultad" value="2"> Media</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="label label-danger"><input type="radio" name="dificultad" value="3"> Difícil</span>
                                </div>
                            </div>
                        </div>
                        <button style="margin-top: 10px" type="submit" class="btn btn-success btn-borrar">Actualizar</button>
                       </form>
                </div>
                <?php
                if($es_autor == 1)
                        {
                    ?>
                            <div class="col-md-12" style="text-align: right; margin-top: 10px;">
                                <a href="<?php echo base_url('index.php/recetas/borrar_receta/'.$datos_receta['id'])?>"><button class='btn btn-danger btn-borrar'>Borrar receta</button></a>
                            </div>
                    <?php
                        }
                ?>
                <?php } ?>
                <div class="col-md-12 separador-receta" style="margin-top: 30px">
                	Ingredientes
                </div>
                <div class="col-md-12 receta-ip" style="text-align: left;">
                	<ul>
                	<?php
                		foreach ($ingredientes_receta as $k => $v) 
                			echo "<li>$v[cantidad] $v[unidad] de " . $this->receta->get_nombre_ingrediente($v['id_ingrediente']);
                	?>
                	</ul>
                    <div class="col-md-8">
                    <?php
                        if($es_autor == 1)
                        {
                    ?>
                        <form class="form-inline" action="<?php echo base_url('index.php/recetas/nuevo_ingrediente/'.$datos_receta['id'])?>" method="POST">
                        <select placeholder='Ingrediente' class='form-control' name='nuevo-ingrediente[]'>
                            <?php
                            foreach ($ingredientes as $k => $v) 
                                echo "<option value='$v[nombre]'>$v[nombre]</option>";
                            ?>
                        </select>
                        <input required type="text" style="width: 50px" class="form-control" name="nuevo-ingrediente[]" value="" placeholder="Cantidad"/>
                        <select class="form-control" name="nuevo-ingrediente[]">
                            <option value="gramos">Gramos</option>
                            <option value="miligramos">Miligramos</option>
                            <option value="litros">Litros</option>
                            <option value="centilitros">Centilitros</option>
                            <option value="unidades" selected>Unidades</option>
                        </select>
                        <button type="submit" class="btn btn-success btn-borrar">Nuevo ingrediente</button>
                    </form>
                    </div>
                    <?php
                            if(!empty($ingredientes_receta))
                            {   
                    ?>
                    <div class="col-md-4" style="text-align: right;">
                            <a href="<?php echo base_url('index.php/recetas/borrar_ultimo_ingrediente/'.$datos_receta['id'])?>"><button class='btn btn-danger btn-borrar'>Borrar ultimo ingrediente</button></a>
                        </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="col-md-12 separador-receta" style="margin-top: 10px;">
                    Pasos
                </div>
                <div class="col-md-12 receta-ip" style="text-align: left;">
                    <ul>
                    <?php
                        foreach ($pasos as $k => $v) 
                            echo "<li>$v[descripcion]</li>";
                    ?>
                    </ul>
                    <?php
                        if($es_autor == 1)
                        {

                    ?>
                        <div class="col-md-8">
                            <form class="form-inline" action="<?php echo base_url('index.php/recetas/nuevo_paso/'.$datos_receta['id'])?>" method="POST">
                                <input required style="width: 300px;" type="text" class="form-control" placeholder="Descripcion del paso" name="paso-desc">
                                <button type="submit" class="btn btn-success btn-borrar">Nuevo paso</button>
                            </form>
                        </div>
                    <?php
                        if(!empty($pasos))
                        {
                    ?>
                            <div class="col-md-4" style="text-align: right;">
                                <a href="<?php echo base_url('index.php/recetas/borrar_ultimo_paso/'.$datos_receta['id'])?>"><button class='btn btn-danger btn-borrar'>Borrar ultimo paso</button></a>
                            </div>
                    <?php
                            } 
                        }
                    ?>
                </div>
                    <div class="col-md-12 separador-receta" style="margin-top: 10px;">
                    Comentarios
                    </div>
                    <div class="col-md-12 comentarios" style="margin-top: 10px;">
                        <?php
                            if($es_autor == 0)
                            {
                        ?>
                            <form class="form-group" action="<?php echo base_url('index.php/recetas/nuevo_comentario/'.$datos_receta['id'])?>" method="POST">
                                <textarea required style="width: 100%;" type="comment-box" class="form-control" placeholder="Comentario" name="nuevo-comentario"></textarea>
                                <button type="submit" class="btn btn-success btn-borrar">Comentar</button>
                            </form>
                        <?php
                            }
                            if(isset($comentarios))
                            foreach ($comentarios as $k => $v) 
                            {
                        ?>
                            <div class="media">
                                <div class="media-left media-top">
                                    <?php echo "<img class='media-object' style='width: 100px; height: 100px' src='data:image/jpeg;base64,".base64_encode( $this->user->get_user_pp($v['id_comentador']) )."'/>";?>
                                </div>
                                <div class="media-body" style="text-align: left">
                                    <h4 class="media-heading"><a href="<?php echo base_url('index.php/usuario/perfil/'.$this->user->get_username($v['id_comentador']))?>"><?=$this->user->get_username($v['id_comentador'])?></a><small><i> Realizado el: <?=$v['fecha']?></i></small></h4>
                                    <p><?=$v['comentario']?></p>
                                    <?php
                                    if($es_autor == 1 || $session_data['id'] == $v['id_comentador'])
                                    {
                                ?>
                                    <div class="col-md-12" style="text-align: right;">
                                        <a href="<?php echo base_url('index.php/recetas/borrar_comentario/'.$datos_receta['id'].'/'.$v['id'])?>"><button class='btn btn-danger btn-borrar'>Borrar comentario</button></a>
                                    </div>
                                <?php
                                    }
                                ?>
                                </div>
                            </div>
                            <hr>
                        <?php
                            }
                        ?>
                        
                    </div>
                    <div class="col-md-12 paginacion-receta">
                            <?php echo $links; ?>
                    </div>
                </div>
            
			</div>
	    </div>
   </div>
   <script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
   <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-formhelpers.min.js"); ?>"></script>
   <script type="text/javascript">
    //plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

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