<?php

include("globals.php");

$title = "anyInventory: Ayuda > Campos > Agregando Campos";
$inHead = '
	<script type="text/javascript">
	   _editor_url = "'.$DIR_PREFIX.'htmlarea/";
	   _editor_lang = "'.LANG.'";
	</script>
	<script type="text/javascript" src="'.$DIR_PREFIX.'htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';
$breadcrumbs = '<a href="./">Ayuda</a> > <a href="fields.php">Campos</a> > Agregando Campos';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Agregando Campos</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>
					Para empezar a llevar el control de tus notas de compra, debemos añadir los campos listados en la p&aacute;gina anterior, para que mas tarde podamos capturar la informaci&oacute;n que ir&aacute; en ellos.
					Para esto, debemos ir a la p&aacute;gina de <a href="'.$DIR_PREFIX.'admin/add_field.php">adici&oacute;n de campos</a>.  Ah&iacute;, te encontrar&aacute;s una vista similar a esta:
				</p>
				<form method="post" action="#">
					<table>
						'.display_field_form().'
					</table>
				</form>
				<p>Empecemos a agregar nuestros campos, ¿Empezamos?  El primero es la fecha de compra.</p>
				<p>"¡Espera!," podr&iacute;as decir.  " ¿No deber&iacute;amos guardar el nombre de cada elemento primero?"  No te preocupes.  Nunca necesitar&aacute;s crear un campo para guardar el nombre de un art&iacute;culo; ese es uno de los campos predefinidos en anyInventory, el otro es el campo de autoincremento.</p>
				<p>Si seleccionas la opci&oacute;n "Remarca este campo," este campo y su descripci&oacute;n aparecer&aacute;n con un fondo subrayado en la descripci&oacute;n del art&iacute;culo.  Esto puede ser &uacute;til para remarcar campos importantes o especiales, como el UPC, n&uacute;mero de serie, o c&oacute;digos de producto.</p>
				<p>Bien, regresando a nuestro ejemplo: primero, capturamos el nombre del campo:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Fecha de compra','text').'
					</table>
				</form>
				<p>Hasta ahora vamos bien.  Seleccionemos el tipo de campo que queremos.  Ya que "campo de texto" ya est&aacute; seleccionado, no hace falta cambiar el tipo de campo.</p>
				<p>El "valor por defecto" define el valor que aparecer&aacute; por defecto en el campo cuando se agregue un art&iacute;culo.  Para esto, quiz&aacute;s querramos recordar en que formato capturar la fecha, as&iacute; que lo llenamos como YYYY/MM/DD:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Fecha de compra','text','','YYYYMMDD').'
					</table>
				</form>
				<p>Lo siguiente es el tamaño del campo.  Esto permite restringir el n&uacute;mero de caracteres que pueden ser introducidos en el campo.  Ya que sabemos el formato de la fecha, podemos especificarlo como una longitud de 10, suficiente para capturar nuestro formato de fecha.</p>
				<p><em>Nota: si este valor es de 256 o mas, se te presentar&aacute; una caja de texto en lugar de un campo de texto para capturar la informaci&oacute;n.  La caja de texto, mostrada a continuaci&oacute;n, simplemente muestra una mayor cantidad de texto mientras lo vas capturando.</em></p>
				<form style="padding-left: 50px; margin: 10px;">
					<textarea rows="10" cols="60" style="width: 100%;">
						Esta es un caja de texto.  Ten la libertad de editar este texto.
						Si est&aacute;s utilizando un navegador soportado, debe aparecer como un editor WYSIWYG.
					</textarea>
				</form>
				<br />
				<form method="post" action="#">
					<table>
						'.display_field_form('','Fecha de compra','text','','YYYYMMDD',8).'
					</table>
				</form>
				<p>El &uacute;ltimo campo, "Aplica a," nos permite seleccionar las categor&iacute;as a las cuales ser&aacute; aplicado este campo.  Por el momento no nos debemos preocupar de esto, ya que no hemos agregado categor&iacute;a alguna, si lo hubieramos hecho, podriamos seleccionar las que quisi&eacute;ramos que contengan este campo.  <a href="categories.php#adding">Agregar categor&iacute;as</a> es descrito mas adelante.</p>
				<p>Agregar el campo de precio total y el de art&iacute;culo adquirido funciona de la misma manera, mejor veamos como agregar campos enumerados, "enumerados" queriendo decir que podemos especificar los valores que un campo puede tomar.</p>

				<p>Agreguemos el campo de "Lugar de compra", que es de tipo "m&uacute;ltiple."  (Lo seleccionamos de esta manera en lugar de simplemente selecci&oacute;n para permitir agregar lugares que no estuvieran contemplados en el listado.)</p>
				<p>Primero, capturamos el nombre del campo, y seleccionamos el tipo de campo:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Lugar de compra','multiple').'
					</table>
				</form>
				<p>Lo siguiente que necesitamos es dar al campo algunos valores para el listado. Lo hacemos capturando los nombres de lugares que queremos aparezcan disponibles, separados por comas. As&iacute; que, pongamos las cinco tiendas que mas frecuentamos, y el valor por defecto ser&aacute; la tienda en la cual compramos con mayor frecuencia.</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Lugar de compra','multiple',array("La Ferre", "Office Max", "Office Depot", "Radio Shack", "Comercial Mexicana"),'La Ferre').'
					</table>
				</form>
				<p>Nuevamente, ya que no hemos capturado categor&iacute;a alguna, podemos ignorar el campo "Aplica a".<p>
				<p>Este campo, al aparecer en la p&aacute;gina de adici&oacute;n de campos, se ver&iacute;a de esta manera:</p>
				<form style="padding-left: 50px; margin: 10px;">
					<input type="text" value="La Ferre" id="store_we_shop_at"/>
					<select name="values">
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'La Ferre\';">La Ferre</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Max\';">Office Max</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Depot\';">Office Depot</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Radio Shack\';">Radio Shack</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Comercial Mexicana\';">Comercial Mexicana</option>
					</select>
				</form>
				<p>Agregar los campos de radio bot&oacute;n, casilla de selecci&oacute;n, o selecci&oacute;n funciona de la misma manera.</p>
				<p>Agregar un campo de \'archivo\' te permite enviar un archivo en lugar de capturar alg&uacute;n valor.  A partir de la versi&oacute;n 1.6, esto reemplaz&oacute; los campos predefinidos "Enviar archivo" y "Archivo remoto".</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="fields.php#types">&lt;&lt; Anterior: Tipos de campos</a></div>
	<div style="text-align: right;"><a href="editing_fields.php">Siguiente: Editando campos &gt;&gt;</a></div>';

display($output);

?>