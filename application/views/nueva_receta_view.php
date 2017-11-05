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
						    	<a href="#"><button type="submit" name="log-me-in" id="btn-profile" class="btn-blue">Perfil</button></a>
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

	  			<!------------------------------------- Parte de TIMELINE -------------------------------------------->
    			<div class="col-md-9 comun-barra well" id="barra-central" style="text-align: center">
                    <div class = "col-md-12 comun-barra " style="margin-top: -30px"><h2>Nueva receta</h2></div>
                    <div class = "col-md-12 comun-barra ">
                        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>";
                        echo form_open_multipart('index.php/recetas/nueva');?>
                        <div class="profile-picture-box">
                            <div style="width: 50%; margin: 0 auto; text-align: center;"> <img id="profile-preview" width="500" height="200" src="<?php echo base_url("assets/images/bg1.jpg"); ?>" alt=""></div>
                            <input type='file' id="profile-picture" name="receta-picture" value='' required />
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"> 
                                <h4>Nombre</h4>
                                <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" required/>
                            </div>
                            <div class="col-md-12"> 
                                <h4>Tiempo (minutos)</h4>
                                <div class="input-group">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="tiempo">
                                        <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                  <input type="text" name="tiempo" class="form-control input-number" value="60" min="1" max="120" requires>
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="tiempo">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                              </div>
                            </div>
                            <div class="col-md-12"> 
                                <h4>Tipo</h4>
                                <select class="form-control" name="tipo" required>
                                    <option value=""></option>
                                    <option value="Desayuno">Desayuno</option>
                                    <option value="Almuerzo">Almuerzo</option>
                                    <option value="Merienda">Merienda</option>
                                    <option value="Cena">Cena</option>
                                </select>
                            </div>
                            <h4>Ingredientes</h4>
                            <div class="col-md-6">
                                <?php
                                    for($i=0; $i<3; $i++)
                                    {
                                        echo "<div class='form-inline'><select placeholder='Ingrediente' class='form-control' name='ing-$i-nombre'><option value=''></option>";
                                        foreach ($ingredientes as $k => $v) 
                                            echo "<option value='$v[nombre]'>$v[nombre]</option>";
                                        echo "</select>";
                                ?>
                                        <input style="width:100px" type="text" class="form-control" name="<?php echo "ing-$i-cantidad" ?>" value="" placeholder="Cantidad"/>
                                        <select class="form-control" name="<?php echo "ing-$i-unidad" ?>">
                                            <option value="gramos">Gramos</option>
                                            <option value="miligramos">Miligramos</option>
                                            <option value="litros">Litros</option>
                                            <option value="centilitros">Centilitros</option>
                                            <option value="unidades" selected>Unidades</option>
                                        </select>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col-md-6 form-inline">
                               <?php
                                    for($i=3; $i<6; $i++)
                                    {
                                        echo "<div class='form-inline'><select placeholder='Ingrediente' class='form-control' name='ing-$i-nombre'><option value=''></option>";
                                        foreach ($ingredientes as $k => $v) 
                                            echo "<option value='$v[nombre]'>$v[nombre]</option>";
                                        echo "</select>";
                                ?>
                                        <input style="width:100px" type="text" class="form-control" name="<?php echo "ing-$i-cantidad" ?>" value="" placeholder="Cantidad"/>
                                        <select class="form-control" name="<?php echo "ing-$i-unidad" ?>">
                                            <option value="gramos">Gramos</option>
                                            <option value="miligramos">Miligramos</option>
                                            <option value="litros">Litros</option>
                                            <option value="centilitros">Centilitros</option>
                                            <option value="unidades" selected>Unidades</option>
                                        </select>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col-md-12"> 
                                <h4>Dificultad</h4>
                                <div class="col-md-4">
                                 <span class="label label-success"><input type="radio" name="dificultad" value="1" checked> Fácil</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="label label-warning"><input type="radio" name="dificultad" value="2"> Media</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="label label-danger"><input type="radio" name="dificultad" value="3"> Difícil</span>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <button type="submit" name="introducir-pasos" id="btn-login" class="btn-orange">Introducir pasos</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
			</div>
	    </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-3.1.1.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-formhelpers.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/chosen.jquery.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/chosen.proto.min.js"); ?>"></script>
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