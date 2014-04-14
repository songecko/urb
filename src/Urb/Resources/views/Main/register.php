<div id="contenedor" class="register">
	<img src="<?php echo $view['assets']->getUrl('images/urb.png')?>" width="150" style="padding: 15px" />
	<h2>¡Registrate y participá!</h2>
	<p class="texto_registro">Llega el frío y es hora de renovar tu look pero, ¿sabés cuál es tu color ideal para esta temporada? ¡Nosotros te ayudamos! Elige tu foto y te mostraremos cual es el tono ideal para vos. Registrate para empezar. </p>
	<ul class="registro">
		<li>
			<label>Nombre</label>
			<input type="text" name="nombre"  id ="nombre"  value="" />
		</li>
		<li>
			<label>Apellido</label>
			<input type="text" name="apellido"  id ="apellido"  value="" />
		</li>
		<li>
			<label>DNI</label>
			<input type="text" name="dni"  id ="dni"  value="" />
		</li>
		<li>
			<label>E-mail</label>
			<input type="text" name="email"  id ="email"  value="" />
		</li>
		<li>
			<label>Fecha de nacimiento</label>
			<input class="fecha" type="text" name="dia" id ="dia" value="" maxlength="2" />
			<input class="fecha" type="text" name="mes" id ="mes" value="" maxlength="2" />
			<input class="fecha" type="text" name="anio" id ="anio" value="" maxlength="4" />
		</li>
		<li style="text-align: left; padding-left: 210px"><input style="width: auto;" type="checkbox" /> Acepto bases y condiciones</li>
		<li style="text-align: left; padding-left: 210px"><input style="width: auto;" type="checkbox" /> Quiero recibir información sobre Jumbo.</li>
		<li>
			<a href="registro.html" class="boton1" style="float:right; width: 230px; margin-top: 20px"><span>Continuar</span> <i class="fa  fa-arrow-circle-right"></i></a>
		</li>
	</ul>
	<img class="logo_jumbo" src="<?php echo $view['assets']->getUrl('images/jumbo.png')?>" width="120" style="padding: 15px" />
</div>