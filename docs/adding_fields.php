<?php

include("globals.php");

$inHead = '
	<script type="text/javascript">
	   _editor_url = "'.$DIR_PREFIX.'htmlarea/";
	   _editor_lang = "'.LANG.'";
	</script>
	<script type="text/javascript" src="'.$DIR_PREFIX.'htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';


switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Campos > Agregando Campos";
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
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Champs > Ajouter un Champ";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="fields.php">Fields</a> > Ajouter un Champ';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Ajouter un Champ</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>
							Pour commencer à gérer vos reçus, vous devez ajouter les champs énumérés à la page précédente de sorte que vous puissiez entrer les données plus tard.
							Pour ceci, procédez a l\'<a href="'.$DIR_PREFIX.'admin/add_field.php">ajout de champ</a>. Là, vous verrez
							quelque chose qui ressemble à ceci:
						</p>
						<form method="post" action="#">
							<table>
								'.display_field_form().'
							</table>
						</form>
						<p>Commençons à ajouter nos champs, n\'est-ce pas?  D\'abord la date de l\'achat.</p>
						<p>"Mais attendez, ne devrions-nous pas entrer le nom de chaque article?" Ne vous inquiétez pas.  Vous ne devrez jamais créer un champ pour le nom d\'article; c\'est un des deux champs préintégrés dans anyInventory, l\'autre étant le champ d\'auto-incrementation.</p>
						<p>Si vous choisissez de cocher "Mettre ce champ en surbrillance", le champ et sa valeur serons affiché avec une couleur de fond dans la description de l\'article.  Ceci pourrait être utile pour mettre en valeur des champs spéciaux pour un article, tel que l\'UPC, le numéro de série, ou les codes produit.</p>
						<p>Retournons à la date d\'achat: d\'abord, nous entrons dans le champ Nom:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Date D\'Achat','text').'
							</table>
						</form>
						<p>Là nous allons choisir quel type de champ nous voulons.  Puisque "texte" est déjà choisi ici, il n\'y a aucun besoin de changer le type de données.</p>
						<p>La "Valeur par défaut" définie ce qui est affiché par défaut dans un champ, quand vous ajoutez un article.  Par exemple, nous voulons nous rappeler dans quel format écrire la date, ainsi nous avons mis par DDMMYYYY:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Date D\'Achat','text','','DDMMYYYY').'
							</table>
						</form>
						<p>Après nous avons la taille du champ.  Ceci limite le nombre de caractères qui peuvent être écrits dans le champ. Puisque nous savons déjà le format de notre date, nous pouvons mettre 10, puisque c\'est exactement la taile de notre format de date.</p>
						<p><em>Note: si la taille est de 256 ou davantage, vous obtiendrez une boîte texte à la place d\'une ligne texte pour saisir vos données.  La boîte texte, montré ci-dessous, rend simplement les données plus visible.</em></p>
						<form style="padding-left: 50px; margin: 10px;">
							<textarea rows="10" cols="60" style="width: 100%;">
								Ceci est une boîte texte.  Soyez libre de taper ce que vous voulez dedans.
							        Si vous avez un navigateur compatible, ceci devrait également être un éditeur WYSIWYG.
							</textarea>
						</form>
						<br />
						<form method="post" action="#">
							<table>
								'.display_field_form('','Date D\'Achat','text','','DDMMYYYY',8).'
							</table>
						</form>
						<p>Le dernier champ, "Appliquer à", permet d\'appliquer ce champ à un ensemble de catégories.  Nous n\'avons pas besoin de nous inquiéter à ce sujet, puisque nous n\'avons ajouté encore aucune catégorie. Si nous avions déjà ajouté quelques catégories, nous pourrions choisir les catégories nous voulons pour contenir ce champ. Ajouter des champs aux catégories est décrit plus loin dans <a href="categories.php#adding">ajouter une catégorie</a>.</p>
						<p>Ajouter le prix total et l\'article acheté se fera de la même manière, mais jetons un coup d\'oeil à un des autres champs pour voir comment en ajoutant des champs "énumérés" cela marche, "énuméré" signifiant que vous pouvez indiquer un ensemble de valeurs pour le champ.</p>
						<p>Ajoutons le champ "Lieu d\'Achat" maintenant, avec le type "multiple."  (Nous le choisisons multiple au lieu de le choisir en boîte de sélection afin de nous permettre de saisir un endroit qui n\'est pas dans la liste.)</p>
						<p>D\'abord, nous entrons dans le champ nom et choisissons le type de champ:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Lieu d\'Achat','multiple').'
							</table>
						</form>
						<p>La prochaine chose que nous devons faire est de donner à ce champ quelques valeurs. Nous faisons ceci en entrant les magasins que nous voulons voir apparaître dans la liste, séparés par des virgules. Ainsi, nous mettons les cinq magasins où nous faisons des emplettes le plus souvent, et nous placerons par défaut le magasin où nous allons le plus.</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Lieu d\'Achat','multiple',array("Staples", "Bureau Max", "Bureau de Dépôt", "Radio Shack", "Sam Goody"),'Bureau Max').'
							</table>
						</form>
						<p>Puisque nous n\'avons ajouté aucune catégorie, nous pouvons ignorer le champ "Appliquer à :".<p>
						<p>Ce champ, dans une page d\'ajout d\'article, ressemblera à ceci:</p>
						<form style="padding-left: 50px; margin: 10px;">
							<input type="text" value="Bureau Max" id="store_we_shop_at"/>
							<select name="field_values">
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Staples\';">Staples</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Bureau Max\';">Bureau Max</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Bureau de Dépôt\';">Bureau de Dépôt</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Radio Shack\';">Radio Shack</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Sam Goody\';">Sam Goody</option>
							</select>
						</form>
						<p>Ajouter un radio bouton, une case à cocher, ou une boîte de sélection se fait de la même manière.</p>
						<p>Ajouter un champ de type \'fichier\' vous permet d\'importer un fichier pour ce champ au lieu de saisir ou de choisir une valeur.  Depuis la version 1.6, ceci a remplacé les champs intégrés "de téléchargement de fichiers" et "de fichiers distant".</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="fields.php#types">&lt;&lt; Précédent: Champs</a></div>
			<div style="text-align: right;"><a href="editing_fields.php">Suivant: Editer un Champ &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Fields > Adding Fields";
		
		$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Adding Fields';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Adding Fields</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>
							To begin tracking your receipts, you must add the fields listed on the previous page so that you can enter in the data later.
							For this, proceed to the <a href="'.$DIR_PREFIX.'admin/add_field.php">field addition</a> page.  There, you will see
							something that looks like this:
						</p>
						<form method="post" action="#">
							<table>
								'.display_field_form().'
							</table>
						</form>
						<p>Let\'s begin adding our fields, shall we?  First up is the date of purchase.</p>
						<p>"But wait," you might say.  "Shouldn\'t we keep track of the name of each item?"  Don\'t worry.  You will never need to create a field to track an item name; that is one of only two built-in fields in anyInventory, the other being the auto-incrementing field.</p>
						<p>If you choose to check the box marked "Highlight this field," this field and its value will appear with a highlighted background in the item\'s description.  This might be useful for denoting special fields for an item, such as UPC, serial number, or product codes.</p>
						<p>Back to the purchase date: first, we enter in the field name:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Purchase Date','text').'
							</table>
						</form>
						<p>There we go.  Now, we select what type of field we want.  Since "text" is already selected here, there\'s no need to change the data type.</p>
						<p>The "default value" defines what will appear in a field by default when you add an item.  For this, maybe we want to remember what format in which to enter the date, so we set the default as YYYY/MM/DD:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Purchase Date','text','','YYYYMMDD').'
							</table>
						</form>
						<p>Next is the size of the field.  This limits how many characters can be entered in the field.  Since we already know the format of our date, we can set this to 10, exactly enough to hold our format of date.</p>
						<p><em>Note: if this is set to 256 or more, you will be given a text box rather than a text field to enter your data.  The text box, shown below, simply makes more data visible as your enter it.</em></p>
						<form style="padding-left: 50px; margin: 10px;">
							<textarea rows="10" cols="60" style="width: 100%;">
								This is a text box.  Feel free to type in it.
								If you have a supported browser, this should also be a WYSIWYG editor.
							</textarea>
						</form>
						<br />
						<form method="post" action="#">
							<table>
								'.display_field_form('','Purchase Date','text','','YYYYMMDD',8).'
							</table>
						</form>
						<p>The last field, "Apply to," deals with applying this field to a set of categories.  We don\'t need to worry about this, since we have not added any categories yet.  If we had already added some categories, we could select which categories we wanted to contain this field.  Adding fields to categories is described lated in <a href="categories.php#adding">adding categories</a>.</p>
						<p>Adding the total price and item purchased fields will work the same way, but let\'s take a look at one of the other fields to see how adding an enumerated field works, "enumerated" meaning that you can specify a set of values for the field.</p>
						
						<p>Let\'s add the "place of purchase" field now, which is of type "multiple."  (We set it as multiple instead of select in order 
						to allow us to type in a place if it doesn\'t appear in the list.)</p>
						<p>First, we enter in the field name and choose the field type:</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Place of Purchase','multiple').'
							</table>
						</form>
						<p>The next thing we need to do is to give this field some values. We do this by entering the stores we want to appear in the list, separated by commas. So, let\'s put in the five stores we shop at the most often, and we\'ll set the default to the store that we shop at the most.</p>
						<form method="post" action="#">
							<table>
								'.display_field_form('','Place of Purchase','multiple',array("Staples", "Office Max", "Office Depot", "Radio Shack", "Sam Goody"),'Office Max').'
							</table>
						</form>
						<p>Once again, since we have not added any categories yet, we can ignore the "Apply to" field.<p>
						<p>This field, when it is shown on an item addition page, will look like this:</p>
						<form style="padding-left: 50px; margin: 10px;">
							<input type="text" value="Office Max" id="store_we_shop_at"/>
							<select name="field_values">
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Staples\';">Staples</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Max\';">Office Max</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Depot\';">Office Depot</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Radio Shack\';">Radio Shack</option>
								<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Sam Goody\';">Sam Goody</option>
							</select>
						</form>
						<p>Adding a radio button, checkbox, or select field works in the same way.</p>
						<p>Adding a field of type \'file\' allows you to upload a file for that field instead of typing or selecting a value.  As of version 1.6, this replaced the built-in "File Upload" and "Remote File" fields.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="fields.php#types">&lt;&lt; Previous: Field Types</a></div>
			<div style="text-align: right;"><a href="editing_fields.php">Next: Editing Fields &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>