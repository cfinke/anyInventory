<?php

require_once("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Introducci&oacute;n";
		$breadcrumbs = '<a href="./">Ayuda</a> > <a href="introduction.php">Introducci&oacute;n</a>';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Introducci&oacute;n</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory fue creado para cubrir la falta de sistemas personalizados de inventario; todos los otros sistemas de inventario han sido diseñados con una cierta clase de inventario en mente.  anyInventory es diferente; ha sido diseñado para permitirte a ti, el usuario, decidir que tipo de art&iacute;culos quieres manejar y que tipo de informaci&oacute;n quieres almacenar.</p>
						<p>Por ejemplo, cualquier otro sistema que pudieras haber probado te dir&iacute;a, "Con este sistema, puedes organizar y controlar los programas de tu computadora.  Para cada un de ellos, puedes guardar el nombre, fabricante, y la fecha de compra; tambi&eacute;n puedes, si as&iacute; lo deseas, subir una imagen." Pero, si tu quisieras tambi&eacute;n manejar el n&uacute;mero de serie, tendr&iacute;as que añadir ese campo en el c&oacute;digo fuente, o simplemente adaptarte.  Esta es la gran diferencia con anyInventory:</p>
						<p>Este sistema viene sin <em>ninguna</em> idea predefinida de lo que quieres hacer con &eacute;l.  Es tan flexible como para llevar el control de la comida en el refrigerador as&iacute; como tu colecci&oacute;n de mas de 1000 estampas.  Tan sencillo como para controlar tu colecci&oacute;n de pel&iacute;culas DVD, pero sufici&eacute;ntemente eficiente como para llevar el control del inventario de tu negocio.</p>
						<p>La raz&oacute;n por la que anyInventory puede ser tan flexible y eficiente es la manera en que t&uacute;, el usuario, captura la informaci&oacute;n.  En lugar de empezar capturando art&iacute;culos, empezamos definiendo que tipo de informaci&oacute;n queremos manejar.  Para una revisi&oacute;n mas detallada de esta informaci&oacute;n, contin&uacute;a leyendo acerda de los <a href="fields.php">campos</a>.  Si eligiste proteger con contraseña tu instalaci&oacute;n, desear&aacute; tambi&eacute;n leer sobre <a href="users.php">usuarios</a>.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="index.php">&lt;&lt; Anterior: Tabla de contenido</a></div>
			<div style="text-align: right;"><a href="users.php">Siguiente: Usuarios &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Introduction";
		$breadcrumbs = '<a href="./">Aide</a> > <a href="introduction.php">Introduction</a>';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Introduction</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory a été créé pour remplir un vide dans le domaine personnel des systèmes d\'inventaire; tous les autres systèmes d\'inventaire étant conçus avec un certain type d\'inventaire à l\'esprit.  anyInventory est différent; il est conçu pour vous permettre de décider de quel type d\'article vous voulez référencer et quel type de données vous voulez maintenir.</p>
						<p>Par exemple, n\'importe quel autre système d\'inventaire que vous pourriez trouver vous indiquerait, "Avec ce produit, vous pouvez référencer vos logiciels. Pour chaque logiciel, vous pouvez sauver le nom, l\'éditeur, et la date de l\'achat; vous pouvez également télécharger une image si vous le souhaitez." Si vous vouliez enregister le numéro de série, vous pourriez essaiyer d\'ajouter ce champ dans le code source, ou vous pourriez juste le négocier.  Voici pourquoi anyInventory est différent:</p>
						<p>Ce logiciel vient avec <em>aucunes</em> notions préconçues de ce que vous voulez faire avec lui. Il est assez flexible pour géré la nourriture dans votre réfrigérateur en plus des dés de votre collection de plus de 1000 pièces. Il est suffisament simple pour être employé comme DVDthèque, et assez puissant pour gérer l\'inventaire de votre entreprise.</p>
						<p>La raison pour laquelle anyInventory peut être si le puissant et flexible est la manière dont vous, l\'utilisateur, saisissez les données.  Au lieu de commencer par entrer les articles dans l\'inventaire, vous commencez par définir quelles données vous voulez y mettre.  Pour une vision plus détaillé de ces données, vous pouvez jeter un oeil sur les <a href="fields.php">champs</a>.  Si vous choisissiez un mot de passe pour protéger votre installation, vous pouvez regarder la documentation sur les <a href="users.php">utilisateurs</a>.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="index.php">&lt;&lt; Précédent: Table des Matières</a></div>
			<div style="text-align: right;"><a href="users.php">Suivant: Utilisateurs &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Introduction";
		$breadcrumbs = '<a href="./">Help</a> > <a href="introduction.php">Introduction</a>';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Introduction</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>anyInventory was created to fill a void in the personal inventory system field; all of the other inventory systems are designed with a certain type of inventory in mind.  anyInventory is different; it is designed to allow you, the user, to decide what type of item you want to track and what type of data you want to keep track of.</p>
						<p>For example, any other inventory system you might come across would tell you, "With this product, you can keep track of your computer software.  For each piece of software, you can save the name, the publisher, and the date of purchase; you can also upload a picture if you wish." If you wanted to keep track of the serial number as well, you could either try to add that field into the source code, or you could just deal with it.  Here\'s how anyInventory is different:</p>
						<p>This software comes with <em>zero</em> pre-conceived notions of what you want to do with it.  It is flexible enough to track the food in your refrigerator alongside the thimbles in your 1000+ piece thimble collection.  It is simple enough to be used as a library of your DVDs, but it is powerful enough to track the inventory of your small business.</p>
						<p>The reason that anyInventory can be so powerful and flexible is the way the you, the user, enter data.  Instead of starting by entering in items into the inventory, you start by defining what data you want to track.  For a more in-depth look at this data, continue on to read about <a href="fields.php">fields</a>.  If you chose to password-protect your installation, you may want to look at the documentation on <a href="users.php">users</a>.</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="index.php">&lt;&lt; Previous: Table of Contents</a></div>
			<div style="text-align: right;"><a href="users.php">Next: Users &gt;&gt;</a></div>';
		break;
}

display($output);

?>