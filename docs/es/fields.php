<?php

include("globals.php");

$title = "anyInventory: Ayuda > Campos";
$breadcrumbs = '<a href="./">Ayuda</a> > Campos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Campos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Los campos son la base de anyInventory.  Mediante ellos puedes definir el tipo de informaci&oacute;n que quieres almacenar. Echemos un vistazo a los diferentes tipos de campos.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="types">Tipos de campos</a></td>
		</tr>
		<tr>
			<td class="tableData">
			<p>Hay siete tipos de campos de entre los cuales puedes seleccionar para configurar anyInventory.  Cada uno de ellos se describe a continuaci&oacute;n, con un ejemplo mostrado inmediatamente despu&eacute;s. Adem&aacute;s, puedes crear divisores, para separar campos en grupos l&oacute;gicos.</p>
			<ul>
				<li>
					<b>Campo de texto</b>, guarda una palabra o frase, que generalmente es diferente para cada art&iacute;culo.  Un ejemplo ser&iacute;a el nombre de cada art&iacute;culo.
					<form style="padding-left: 50px; margin: 10px;">
						<input type="text" value="Nombre del art&iacute;culo" />
					</form>
				</li>
				<li>
					<b>Selecci&oacute;n</b>, que guarda un valor, que solo puede ser uno de los valores en una lista.  Un ejemplo ser&iacute;a elegir el pa&iacute;s de residencia de una lista.
					<form style="padding-left: 50px; margin: 10px;">
						<select name="values">
							<option>M&eacute;xico</option>
							<option>Canada</option>
							<option>Inglaterra</option>
							<option>Estados Unidos de Norteam&eacute;rica</option>
							<option>Alemania</option>
						</select>
					</form>
				</li>
				<li>
					<b>Radio bot&oacute;n</b>, almacena un valor, que puede ser solamente uno de una pequeña lista.  Un ejemplo es el seleccionar "Si" o "No" como respuesta a una pregunta: debe ser uno de los dos, no puede ser ambos o ninguno.
					<form style="padding-left: 50px; margin: 10px;">
						<input type="radio" name="q" /> Si<br />
						<input type="radio" name="q" /> No
					</form>
				</li>
				<li>
					<b>Casilla de selecci&oacute;n</b>, guarda un valor que puede ser ninguno o alguno de los elementos de una lista.  Un ejemplo podr&iacute;a ser el seleccionar los colores que aparecen en una pintura.
					<form style="padding-left: 50px; margin: 10px;">
						<input type="checkbox" name="q" /> Rojo<br />
						<input type="checkbox" name="q" /> Naranja<br />
						<input type="checkbox" name="q" /> Amarillo<br />
						<input type="checkbox" name="q" /> Verde<br />
						<input type="checkbox" name="q" /> Azul<br />
						<input type="checkbox" name="q" /> &Iacute;ndigo<br />
						<input type="checkbox" name="q" /> Violeta<br />
					</form>
				</li>
				<li>
					<b>M&uacute;ltiple</b>, es una combinaci&oacute;n de Selecci&oacute;n y de Campo de texto.  Esto te permite selecionar uno de los valores mas comunes de una lista, o capturar un nuevo valor para ese art&iacute;culo.  (Si el navegador utilizado tiene Javascript habilitado, el texto en la caja debe cambiar de acuerdo al valor seleccionado de la lista.)
					<form style="padding-left: 50px; margin: 10px;">
						<input type="text" value="M&eacute;xico" id="country"/>
						<select name="values">
							<option onclick="document.getElementById(\'country\').value = \'M&eacute;xico\';">M&eacute;xico</option>
							<option onclick="document.getElementById(\'country\').value = \'Canada\';">Canada</option>
							<option onclick="document.getElementById(\'country\').value = \'Inglaterra\';">Inglaterra</option>
							<option onclick="document.getElementById(\'country\').value = \'Alemania\';">Alemania</option>
							<option onclick="document.getElementById(\'country\').value = \'Estados Unidos de Norteam&eacute;rica\';">Estados Unidos de Norteam&eacute;rica</option>
						</select>
					</form>
				</li>
				<li>
					<b>Archivo</b>, te permite enviar un archivo o especificar uno que ya se encuentra en la red.
					<form style="padding-left: 50px; margin: 10px;">
						<input type="file" name="file" id="file"/> o <input type="text" name="fileremote" value="http://" />
					</form>
				</li>
				<li>
					<p><b>Art&iacute;culo(s)</b>, que te permite asociar art&iacute;culos del inventario entre si.  Por ejemplo, podr&iacute;as crear un campo llamado "Instalado en" para relacionar el programa con el equipo en el que est&aacute; instalado.  Este campo siempre se mostrar&aacute; como un listado de todos los elementos del inventario, ordenados por categor&iacute;as.</p>
				</li>
				<li>
					<b>Divisor de campos</b>, te permite separar los campos en grupos.
					<form style="padding-left: 50px; margin: 10px;">
						<hr />
					</form>
				</li>
			</ul>
			<p>A partir de la versi&oacute;n 1.7.1, tambi&eacute;n tienes la opci&oacute;n de mostrar un campo num&eacute;rico auto-incrementable para cada art&iacute;culo.  Esta opci&oacute;n puede ser deshabilidato o habilitada en la secci&oacute;n de administraci&oacute;n para cada categor&iacute;a.  El nombre de este campo puede ser modificado en la secci&oacute;n de administraci&oacute;n, as&iacute; como el nombre del campo predefinido "Nombre" (a partir de la versi&oacute;n 1.8).</p>
			<p>Si esto te parece un poco confuso, no te preocupes.  Debe ser mas claro con un ejemplo.</p>
			<h4>Ejemplo</h4>
			<p>
				Digamos que est&aacute;s inventariando tus notas de compra para declaraci&oacute;n de impuestos.
			   	Muy probablemente est&eacute;s guardando la sig. informaci&oacute;n: fecha de compra, lugar de compra, precio total, impuesto pagado, art&iacute;culo adquirido, si fue facturado como gasto empresarial, una imagen del recibo, y una imagen del art&iacute;culo comprado.  Los campos para este tipo de art&iacute;culos ser&iacute;an mas o menos as&iacute;:
			</p>
			<ul>
				<li>Fecha de compra: campo de texto</li>
				<li>Lugar de compra: m&uacute;ltiple</li>
				<li>Precio total: campo de texto</li>
				<li>Art&iacute;culo adquirido: campo de texto</li>
				<li>Facturado a empresa: radio botones, con valores "Si" y "No"</li>
				<li>Imagen del recibo y del art&iacute;culo: archivos</li>
			</ul>
			<p>Ahora que tenemos un grupo de art&iacute;culos que queremos inventariar, veamos como <a href="adding_fields.php">agregar&iacute;amos los campos.</a>
			</p>
		</td>
	</tr>
	</table>
	<div style="float: left;"><a href="deleting_users.php">&lt;&lt; Anterior: Eliminando Usuarios</a></div>
	<div style="text-align: right;"><a href="adding_fields.php">Siguiente: Agregando Campos &gt;&gt;</a></div>';

display($output);

?>