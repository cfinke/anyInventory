<?php



include("globals.php");



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



display($output);



?>
