<?php

include("globals.php");

switch (LANG){
	case 'es':
		$title = "anyInventory: Ayuda > Buscando";
		$breadcrumbs = '<a href="./">Ayuda</a> > Buscando';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Buscando</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Cuando introduces un t&eacute;rmino en la forma localizada en la parte superior de cualquier p&aacute;gina de anyInventory, la b&uacute;squeda se efect&uacute;a de la siguiente manera:</p>
						<ol>
							<li>Si escribes solamente un n&uacute;mero, anyInventory buscar&aacute; en cada campo, <em>adem&aacute;s</em> del de autoincremento.</li>
							<li>Si introduces una t&eacute;rmino no num&eacute;rico, anyInventory buscar&aacute; en cada campo, <em>adem&aacute;s</em> del nombre.</li>
							<li>En caso de que introduzcas mas de un t&eacute;rmino, anyInventory buscar&aacute; los art&iacute;culos que contengas todos los t&eacute;rminos, en cualquiera de sus campos.</li>
						</ol>
						<p>anyInventory entonces mostrar&aacute; los resultado ordenados por categor&iacute;a.  Las b&uacute;squedas Booleanas no han sido implementadas a&uacute;n (ej. usar "AND" o "OR" no afectar&aacute; la b&uacute;squeda).</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="labels.php">&lt;&lt; Anterior: Etiquetas</a></div>
			<div style="text-align: right;"><a href="whats_next.php">Siguiente: ¿Qu&eacute; sigue? &gt;&gt;</a></div>';
		break;
	case 'fr':
		$title = "anyInventory: Aide > Recherche";
		$breadcrumbs = '<a href="./">Aide</a> > Recherche';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Recherche</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>Quand vous entrez des termes à rechercher dans la boîte en haut de n\'importe quelle page d\'anyInventory, la recherche est faite de la façon suivante:</p>
						<ol>
							<li>Si vous écrivez un nombre et aucun autre terme, anyInventory recherchera dans chaques champs <em>plus</em> le champ d\'auto-incrémentation unique pour ce nombre.</li>
							<li>Si vous écrivez un terme qui n\'est pas numérique, anyInventory recherchera dans chaques champs que vous avez défini <em>plus</em> dans le champ "Nom".</li>
							<li>Si vous écrivez plus d\'un terme, anyInventory recherchera un article qui a chacuns de ces termes de recherche contenu dans un ou plusieurs de ses champs.</li>
						</ol>
						<p>anyInventory renverra alors les résultats rangé par catégorie.  Les recherches booléennes ne sont pas actuellement supportées (ie. utiliser "AND" ou "OR" n\'affecte pas la recherche).</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="labels.php">&lt;&lt; Précédent: Etiquettes</a></div>
			<div style="text-align: right;"><a href="whats_next.php">Suivant: Quelles futures évolutions? &gt;&gt;</a></div>';
		break;
	case 'en':
	default:
		$title = "anyInventory: Help > Searching";
		$breadcrumbs = '<a href="./">Help</a> > Searching';
		
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Searching</td>
				</tr>
				<tr>
					<td class="tableData">
						<p>When you enter search terms in the box at the top of any page in anyInventory, the search is made in the following manner:</p>
						<ol>
							<li>If you enter a number and no other terms, anyInventory will search each field <em>plus</em> the unique auto-incrementing field for that number.</li>
							<li>If you enter one term that is not numeric, anyInventory will search each field that you defined <em>plus</em> the "name" field.</li>
							<li>If you enter more than one term, anyInventory will seach for an item that has each of the search terms contained somewhere within one or more of its fields.</li>
						</ol>
						<p>anyInventory will then return the results ordered by category.  Boolean searches are not currently supported (ie. using "AND" or "OR" will not affect the search).</p>
					</td>
				</tr>
			</table>
			<div style="float: left;"><a href="labels.php">&lt;&lt; Previous: Labels</a></div>
			<div style="text-align: right;"><a href="whats_next.php">Next: What\'s Next? &gt;&gt;</a></div>';
		break;
}

display($output);

?>