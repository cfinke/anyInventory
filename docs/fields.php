<?php

require_once("globals.php");

switch (LANG){
	case 'es':
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
		
		break;
	case 'fr':
		$title = "anyInventory: Aide > Champs";
		$breadcrumbs = '<a href="./">Aide</a> > Champs';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Champs</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Les Champs sont la base d\'anyInventory.  Ils définissent le type de données que vous voulez. jetons un coup d\'oeil aux différents types de champs.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="types">Types de Champs</a></td>
				</tr>
				<tr>
					<td class="tableData">
					<p>Il y a sept types de champs possible pour anyInventory.  Chacun d\'eux
					   sont décrit ci-dessous, avec un exemple associé. En plus, vous pouvez créer des diviseurs de champ pour séparer les champs en groupes logiques.</p>
					<ul>
						<li>
							<b>Champ Texte</b>, contient un mot ou une phrase qui sont habituellement différents pour chaque article.  Un exemple
						    de ceci serait le nom de cahque article.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="text" value="Nom de l\'article" />
							</form>
						</li>
						<li>
							<b>Champ de Sélection</b>, prends un valeur tirée d\'une liste prédéfinie.  Un exemple de ceci
							seait la sélection du pays ou vous résidez.
							<form style="padding-left: 50px; margin: 10px;">
								<select name="field_values">
									<option>Canada</option>
									<option>Angleterre</option>
									<option>Allemagne</option>
									<option>Etats-Unis</option>
								</select>
							</form>
						</li>
						<li>
							<b>Radio Boutons</b>, prends une valeur unique parmis plusieurs propositions.  Un exemple de
						    cela est si vous voulez choisir comme réponse "Oui" ou "Non" à une question: il ne peux y avoir qu\'une réponse parmis les deux.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="radio" name="q" /> Oui<br />
								<input type="radio" name="q" /> Non
							</form>
						</li>
						<li>
							<b>Boîtes à Cocher</b>, permet d\'avoir aucune ou plusieurs valeurs dans une liste prédéfinie.  En exemple
							on peux avoir à sélectionner toutes les couleurs qui apparaisent dans une peinture.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="checkbox" name="q" /> Rouge<br />
								<input type="checkbox" name="q" /> Orange<br />
								<input type="checkbox" name="q" /> Jaune<br />
								<input type="checkbox" name="q" /> Vert<br />
								<input type="checkbox" name="q" /> Bleu<br />
								<input type="checkbox" name="q" /> Indigo<br />
								<input type="checkbox" name="q" /> Violet<br />
							</form>
						</li>
						<li>
							<b>Multiple</b>, c\'est une combinaison d\'un champ de sélection et d\'un champ texte.  Ceci vous donne la possibilité de choisir une valeur généralement utilisé à partir d\'une liste prédéfinie ou d\'entrer la valeur que vous voulez pour cet article.  (Si vous avez un navigateur web avec le Javascript installé, le champ texte devrait prendre la valeur de la dernière option choisie dans la liste prédéfinie.
		                                        
		                                        <form style="padding-left: 50px; margin: 10px;">
								<input type="text" value="Mexique" id="country"/>
								<select name="values">
									<option onclick="document.getElementById(\'country\').value = \'Canada\';">Canada</option>
									<option onclick="document.getElementById(\'country\').value = \'Angleterre\';">Angleterre</option>
									<option onclick="document.getElementById(\'country\').value = \'Allemagne\';">Allemagne</option>
									<option onclick="document.getElementById(\'country\').value = \'Etats-Unis\';">Etats-Unis</option>
								</select>
							</form>
						</li>
						<li>
							<b>Fichier</b>, vous permet transférer un fichier de votre ordinateur ou d\'un emplacement spécifique Internet.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="file" name="file" id="file"/> or <input type="text" name="fileremote" value="http://" />
							</form>
						</li>
						<li>
							<p><b>Article(s)</b>, vous permet d\'associer des articles de l\'inventaire entre eux.  Par exemple, vous pouvez créer un  champ d\'article appelé "installé sur" pour lier des articles logiciel à un article ordinateur sur lequel ils sont installés.  Ce champ apparaîtra toujours comme une liste de tous les articles de l\'inventaire, rangés par catégorie.</p>
						</li>
						<li>
							<b>Champ Diviseur</b>, vous permet de séparer les champs en groupes.
							<form style="padding-left: 50px; margin: 10px;">
								<hr />
							</form>
						</li>
					</ul>
					<p>Depuis la version 1.7.1, vous avez également la possibilité d\'avoir un champ d\'auto-incrémentation pour chaque article.  Cette option peut être activée ou non dans la partie administration pour chaque catégorie. Le nom de ce champ peut être adapté aux besoins du client dans la section d\'administration, comme le nom du champ intégré "Nom"  (depuis la version 1.8).</p>
					<p>Si ce tout ceci vous semble embrouillé, ne vous inquiétez pas.  Cela devrait devenir plus clair avec un exemple.</p>
					<h4>Un Exemple</h4>
					<p>
						Disons que vous documentez tous vos reçus des de ce que vous achetez.
					   	Vous pourriez vouloir maintenir ce qui suit:  la date de l\'achat, le lieu de l\'achat, le prix total, la taxe payé, article
					   	achété, si s\'était des dépenses d\'affaires, une image du reçu, et une image de
					   	l\'article achété.  Vos champs pour ce type d\'article ressembleraient à ce qui suit:
					</p>
					<ul>
						<li>Date d\'achat: champ texte</li>
						<li>Lieu d\'achat: champ multiple</li>
						<li>Prix total: champ texte</li>
						<li>Article acheté: champ texte</li>
						<li>Dépenses d\'affaires: radio boutons, avec les valeurs "Oui" et "Non"</li>
						<li>Image de reçu et d\'article: fichiers</li>
					</ul>
					<p>Maintenant que nous avons un groupe de champ que nous voulons utiliser,  voyons comment nous pouvons <a href="adding_fields.php">ajouter
						un champ.</a>
					</p>
				</td>
			</tr>
			</table>
			<div style="float: left;"><a href="deleting_users.php">&lt;&lt; Précédent: Supprimer un Utilisateur</a></div>
			<div style="text-align: right;"><a href="adding_fields.php">Suivant: Ajouter un Champ &gt;&gt;</a></div>';
		
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Fields";
		$breadcrumbs = '<a href="./">Help</a> > Fields';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Fields</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Fields are the basis of anyInventory.  They define the type of data that you want to track. Let\'s take a look at the different types of fields.</p>
					</td>
				</tr>
				<tr class="tableHeader">
					<td><a name="types">Field Types</a></td>
				</tr>
				<tr>
					<td class="tableData">
					<p>There are seven types of fields from which to choose when setting up anyInventory.  Each one
					   is described below, with an example shown below it. Additionally, you can create field dividers to separate the fields into logical groups.</p>
					<ul>
						<li>
							<b>Text field</b>, which holds a word or phrase that is usually different for each item.  An example
						    of this would be the name of each item.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="text" value="Name of item" />
							</form>
						</li>
						<li>
							<b>Select field</b>, which holds a value that can only be one out of a list.  An example of this
							would be selecting your country of residence from a drop-down list.
							<form style="padding-left: 50px; margin: 10px;">
								<select name="field_values">
									<option>Canada</option>
									<option>England</option>
									<option>Germany</option>
									<option>United States</option>
								</select>
							</form>
						</li>
						<li>
							<b>Radio buttons</b>, which hold a value that can only be one out of a few values.  An example of
						    this would be selecting "Yes" or "No" as an answer to a question: it has to be one of the two, and it 
							cannot be both.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="radio" name="q" /> Yes<br />
								<input type="radio" name="q" /> No
							</form>
						</li>
						<li>
							<b>Checkboxes</b>, which hold values that can be zero or more out of a list of values.  An example
							of this would be selecting all of the colors that appear in a painting.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="checkbox" name="q" /> Red<br />
								<input type="checkbox" name="q" /> Orange<br />
								<input type="checkbox" name="q" /> Yellow<br />
								<input type="checkbox" name="q" /> Green<br />
								<input type="checkbox" name="q" /> Blue<br />
								<input type="checkbox" name="q" /> Indigo<br />
								<input type="checkbox" name="q" /> Violet<br />
							</form>
						</li>
						<li>
							<b>Multiple</b>, which is a combination of the select field and the text field.  This gives you the
							option of selecting one of several commonly used values from a drop-down or entering in a
							unique value for this item.  (If you have a Web browser with Javascript enabled, the text
							field should take the value of the last selected option from the dropdown.)
							<form style="padding-left: 50px; margin: 10px;">
								<input type="text" value="Mexico" id="country"/>
								<select name="values">
									<option onclick="document.getElementById(\'country\').value = \'Canada\';">Canada</option>
									<option onclick="document.getElementById(\'country\').value = \'England\';">England</option>
									<option onclick="document.getElementById(\'country\').value = \'Germany\';">Germany</option>
									<option onclick="document.getElementById(\'country\').value = \'United States\';">United States</option>
								</select>
							</form>
						</li>
						<li>
							<b>File</b>, which allows you to upload a file from your computer or specify a file already located on the Internet.
							<form style="padding-left: 50px; margin: 10px;">
								<input type="file" name="file" id="file"/> or <input type="text" name="fileremote" value="http://" />
							</form>
						</li>
						<li>
							<p><b>Item(s)</b>, which allows you to associate items within the inventory with each other.  For example, you could create an item field called "Installed on" to link software items to the computer item on which they are installed.  This field will always show up as a list of all of the item in the inventory, sorted by category.</p>
						</li>
						<li>
							<b>Field divider</b>, which allows you to separate fields into groups.
							<form style="padding-left: 50px; margin: 10px;">
								<hr />
							</form>
						</li>
					</ul>
					<p>As of version 1.7.1, you also have the option of displaying an auto-incrementing field for each item.  This option can be turned on or off in the administration for each category.  The name of this field can be customized in the administration section, as well as the name of the built-in "Name" field (as of version 1.8).</p>
					<p>If this all seems confusing, don\'t worry.  It should become clearer with an example.</p>
					<h4>An Example</h4>
					<p>
						Let\'s say that you are documenting all of your receipts for tax purposes.
					   	You might want to keep track of the following: date of purchase, place of purchase, total price, tax paid, item 
					   	purchased, whether or not it was a business expense, an image of the receipt, and an image of the 
					   	item purchased.  Your fields for this type of item would look like the following:
					</p>
					<ul>
						<li>Date of purchase: text field</li>
						<li>Place of purchase: multiple field</li>
						<li>Total price: text field</li>
						<li>Item purchased: text field</li>
						<li>Business expense: radio buttons, with values "Yes" and "No"</li>
						<li>Receipt and item image: files</li>
					</ul>
					<p>Now that we have a group of items we want to track, let\'s see how we would go about <a href="adding_fields.php">adding
						the fields.</a>
					</p>
				</td>
			</tr>
			</table>
			<div style="float: left;"><a href="deleting_users.php">&lt;&lt; Previous: Deleting Users</a></div>
			<div style="text-align: right;"><a href="adding_fields.php">Next: Adding Fields &gt;&gt;</a></div>';
		
		break;
}

display($output);

?>