<?php

// French language file

define('SWITCH_TO_TABLE','Afficher en vue tableau');
define('SWITCH_TO_LIST','Afficher en vue liste');

define('ID_MATCH','Identifiant Unique Correspondant');
define('NAME_MATCH',NAME_FIELD_NAME.' correspondant');

define('LANGUAGE','Langue');

// Dates
define('MONTH_1','Janvier');
define('MONTH_2','F&#233;vrier');
define('MONTH_3','Mars');
define('MONTH_4','Avril');
define('MONTH_5','Mai');
define('MONTH_6','Juin');
define('MONTH_7','Juillet');
define('MONTH_8','Ao&#251;t');
define('MONTH_9','Septembre');
define('MONTH_10','Octobre');
define('MONTH_11','Novembre');
define('MONTH_12','D&#233;cembre');

// XML
define('DOWNLOAD_LINK','t&#233;l&#233;charger');
define('DOWNLOAD_AS_XML','T&#233;l&#233;charger le fichier XML d&#146;inventaire');

// General
define('APP_TITLE','anyInventory');
define('HOME','Accueil');
define('ADMINISTRATION','Administration');
define('APPLIES_TO','Appliquer &#224; ');
define('ACTIVE_WHEN','Actif quand');
define('FOOTER_TEXT_PRE','vous avez inventori&#233;');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, le plus fexible et puissant syst&#232;me d&#146;inventaire</a>');
define('FOOTER_TEXT_POST','articles avec '.ANYINVENTORY_LINK);
define('HELP','Aide');
define('EDIT','Editer');
define('_DELETE','Supprimer');
define('CANCEL','Abandonner');
define('SUBMIT','Soumettre');
define('VALUE','Valeur');
define('NAME','Nom');
define('EDIT_LINK','&#233;diter');
define('DELETE_LINK','supprimer');
define('TYPE','Type');
define('SELECT_NONE','Aucune S&#233;lection');
define('SUBMIT_REPORT','Vous pouvez aider au d&#233;veloppement de anyInventory en <a href="https://sourceforge.net/tracker/?func=add&amp;group_id=110239&amp;atid=655777">soumettant cette erreur dans le rapport de d&#233;boguage</a>.');

// Search
define('SEARCH','Rechercher');
define('SEARCH_RESULTS','R&#233;sultats de la Recherche');
define('IN','Dans');
define('NO_RESULTS','Pas de r&#233;sultas correspondants');
define('NO_MATCHING_ITEMS','Il n&#146;y avait aucun article correspondant &#224; vos crit&#232;res de recherche.');

// Error messages
define('ERROR','Erreur');
define('ACCESS_DENIED','Acc&#233;s Refus&#233;');
define('ERROR_DUPLICATE_FIELD',"Il y a d&#233;j&#224; un champ avec le nom que vous avez indiqu&#233;. Si vous souhaitez ajouter un champ &#224; plusieurs cat&#233;gories, vous pouvez le faire en &#233;ditant le champ puis en s&#233;lectionnant plusieurs cat&#233;gories en maintenant la touche Ctrl.");
define('ERROR_BAD_DEFAULT_VALUE',"La valeur par d&#233;faut pour une Boîte de S&#233;lection ou pour Radio Boutons doit être incluse dans la liste de valeurs.");
define('ERROR_EMPTY_CATEGORY',"Il n'y avait aucun article dans les cat&#233;gories que vous avez choisies; il doit y avoir des articles dans une cat&#233;gorie pour que vous puissiez y ajouter une alerte.");
define('ERROR_NO_COMMON_FIELDS',"Il n'y avait aucun champ commun dans les cat&#233;gories que vous avez choisies.");
define('ERROR_ALERT_NO_CATEGORIES','Une alerte doit s&#146;appliquer au moins &#224; une cat&#233;gorie.');
define('ERROR_ALERT_NO_ITEMS','Une alerte doit s&#146;appliquer au moins &#224; un article.');
define('ERROR_NO_TOP_LEVEL_EDIT','La cat&#233;gorie '.TOP_LEVEL_CATEGORY.' ne peut pas être &#233;dit&#233; ou supprim&#233;.');
define('ERROR_NO_VALUES','Vous devez fournir une liste de valeurs pour ce champ.');
define('ERROR_PRIVELEGES','Vous n&#146;avez pas les privil&#232;ges n&#233;cessaires.');
define('ERROR_DELETE_OWN_ACCOUNT','Vous ne pouvez pas supprimer votre propre compte d&#146;utilisateur.');
define('ERROR_DUPLICATE_USER','Un utilisateur avec ce nom existe d&#233;j&#224;.');

// Labels
define('LABEL','Etiquette');
define('LABELS','Etiquettes');
define('LABEL_ERROR','Vous n&#146;avez pas toutes les fonctions PHP requises install&#233;es, pour cr&#233;er des &#233;tiquettes .  Ces fonctions sont <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, et <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  Une ou plusieurs de ces fonctions ne sont pas install&#233;es.');
define('LABEL_CAT_INSTRUCTIONS','Choisissez les cat&#233;gories auxquelles les articles appartiennent et pour lesquelles vous voulez cr&#233;er des &#233;tiquettes.  Toutes les cat&#233;gories que vous s&#233;lectionnez doivent avoir au moins un champ en commun.');
define('LABEL_ITEM_INSTRUCTIONS','Choisissez le champ &#224; partir duquel vous voulez cr&#233;er le code barre et les articles pour lesquels vous voulez produire une &#233;tiquette.');
define('GENERATE_LABELS','G&#233;n&#233;ration des &#233;tiquettes');
define('GENERATE_FROM','G&#233;n&#233;rer depuis');
define('GENERATE_FOR','G&#233;n&#233;rer pour');

// Fields
define('FIELD','Champ');
define('FIELDS','Champs');
define('ADD_FIELD','Ajouter un Champ');
define('DATA_TYPE','Type de donn&#233;es');
define('TEXT','Texte');
define('RADIO','Radio Boutons');
define('CHECKBOX','Cases &#224; cocher');
define('SELECT_BOX','Boîte de S&#233;lection');
define('MULTIPLE','Multiple ('.TEXT.'   '.SELECT_BOX.')');
define('FILE','Fichier');
define('VALUES','Valeurs');
define('DEFAULT_VALUE','Valeur par d&#233;faut');
define('VALUES_INFO',"Seulement pour les types de donn&#233;es 'Multiple', 'Boîte de S&#233;lection', 'Cases &#224; cocher', et 'Radio Boutons.'  S&#233;parer par une virgule.");
define('DEFAULT_VALUE_INFO',"Seulement pour les types de donn&#233;es 'Multiple', 'Boîte de S&#233;lection', 'Texte', et 'Radio Boutons.'");
define('SIZE','Taille, en caract&#232;res');
define('_SIZE','Taille');
define('SIZE_INFO',"Seulement pour les donn&#233;es de type 'texte'.");
define('HIGHLIGHT','Surbrillance');
define('HIGHLIGHT_FIELD','Mettre ce champ en surbrillance');
define('DELETE_FIELD','Supprimer le champ');
define('DELETE_FIELD_CONFIRM','Êtes vous s&#251;r de vouloir supprimer ce champ?');
define('NONE','Aucun');
define('FIELD_CATS_PRE','Ce champ est utilis&#233; dans');
define('AUTO_INCREMENT','auto-incr&#233;mention');
define('SHOW_AUTOINC_FIELD','Monter le champ d&#146;auto-incr&#233;mentation');
define('DIVIDER','Diviseur');
define('ADD_DIVIDER','Ajouter un Diviseur');
define('_FRONT_PAGE_TEXT','Texte de la Page Principale');
define('_NAME_FIELD_NAME','"Nom" du champ nom');
define('DOWN_LINK','descendre');
define('UP_LINK','monter');
define('EDIT_AUTOINC_FIELD','Editer le champ d&#146;Auto-Incr&#233;mentation');
define('EDIT_FRONT_PAGE_TEXT','&#233;ditez le Texte de la Page Principale');
define('EDIT_NAME_FIELD','Editer le Champ Nom');
define('APPLY_FIELDS',"Appliquez les champs de cette cat&#233;gorie &#224; toutes les sous-cat&#233;gories.");
define('EDIT_FIELD','Editer le Champ');

// Categories
define('CATEGORIES','Cat&#233;gories');
define('ADD_CATEGORY','Ajouter une Cat&#233;gorie');
define('TOP_LEVEL_CATEGORY','Top');
define('INHERIT_FIELDS','H&#233;ritez des champs parent (en plus des champs v&#233;rifi&#233;s ci-dessous)');
define('ADD_CAT_HERE','Ajouter une cat&#233;gorie ici');
define('NO_SUBCATS','Il n&#146;y a aucune sous-cat&#233;gorie dans cette cat&#233;gorie.');
define('SUBCATS_IN','Sous-cat&#233;gories dans');
define('PARENT_CATEGORY','Parent Category');
define('DELETE_CATEGORY','Supprimer cette Cat&#233;gorie');
define('DELETE_CATEGORY_CONFIRM','Etes vous s&#251;r de vouloir supprimer cette cat&#233;gorie?');
define('NUM_ITEMS','Nombre d&#146;articles');
define('NUM_ITEMS_R','Nombre d&#146;articles dans cette et toutes les sous-cat&#233;gories');
define('DELETE_ALL_ITEMS','Supprimez tous les articles dans cette cat&#233;gorie');
define('MOVE_ITEMS_TO','D&#233;placez tous les articles de cette cat&#233;gorie vers ');
define('NUM_SUBCATS','Nombre de sous-cat&#233;gories');
define('DELETE_ALL_SUBCATS','Supprimez toutes les sous-cat&#233;gories');
define('MOVE_SUBCATS_TO','D&#233;placez toutes les sous-cat&#233;gories vers');
define('NUM_ITEMS_TO','Nombre d&#146;articles dans cette<br /> cat&#233;gorie et ses sous-cat&#233;gories');
define('UPDATE_CATEGORIES','Mise &#224; jour des Cat&#233;gories');
define('EDIT_CATEGORY','Editer une Cat&#233;gorie');

// Items
define('ITEMS','Articles');
define('ADD_ITEM','Ajouter un Article');
define('ADD_ITEM_HERE','Ajouter un Article ici');
define('ADD_ITEM_TO','Ajouter un Article &#224;');
define('ITEMS_IN_CAT','Articles dans cette Cat&#233;gorie');
define('NO_ITEMS_HERE','Il n&#146;y as pas d&#146;article dans cette cat&#233;gorie.');
define('MOVE','D&#233;placer');
define('MOVE_LINK','d&#233;placer');
define('RELATED_ITEMS','Articles Relatifs');
define('MORE_ITEMS',' et. al.');
define('DELETE_ITEM','Supprimer l&#146;Article');
define('DELETE_ITEM_CONFIRM','Etes-vous sur de vouloir supprimer c&#146;est article?');
define('MOVE_ITEM','D&#233;placer l&#146;Article');
define('MOVE_TO','D&#233;placer vers');
define('EDIT_ITEM','Editer l&#146;Article');

// Alerts
define('ALERT','Alerte');
define('ALERTS','Alertes');
define('EFFECTIVE_DATE','Effective en date de');
define('CONDITION','Condition');
define('ADD_ALERT','Ajouter une Alerte');
define('ADD_ALERT_IN','Ajouter une alerte dans');
define('ALERT_TITLE','Titre de l&#146;alerte');
define('TIMED_ONLY_LABEL','Faire que cette alerte soit <a href="../docs/fr/alerts.php#time_based">basé sur le temps seulement</a>.');
define('TIMED_ONLY_EXPLANATION','Pour les alertes temporelles, vous n&#146;avez pas besoin de compléter le champ, la condition, ou la valeur.');
define('DELETE_ALERT','Supprimer l&#146;Alerte');
define('DELETE_ALERT_CONFIRM','Etes vous s&#251;r de vouloir supprimer cette alerte?');
define('EDIT_ALERT','Editer l&#146;Alerte');
define('EXPIRATION_DATE','Date d&#146;Expiration');
define('ALLOW_EXPIRATION','Permettre &#224; cette alerte d&#146;expirer');
define('EMAIL_ALERT_TO','Alerte par E-mail &#224;');
define('EMAIL_ALERT_INFO','Si vous ne voulez pas être notifi&#233; par E-mail quand cette alerte est activ&#233;e, laissez ce champ vierge.');
define('ALERT_ACTIVATED_BY','Cette alerte a &#233;t&#233; initialement activ&#233;e par cet article');

// Users
define('USERS','Utilisateurs');
define('ADD_USER','Ajouter un Utilisateur');
define('LOGIN','Connexion');
define('LOG_OUT','D&#233;connexion');
define('USERNAME','Nom d&#146;utilisateur');
define('PASSWORD','Mot de passe');
define('GIVE_VIEW_TO','Donnez les privil&#232;ges de consultation &#224;');
define('GIVE_ADMIN_TO','Donnez les privil&#232;ges d&#146;administration &#224;');
define('CAN_VIEW','Peut consulter');
define('CAN_ADMIN','Peut administrer');
define('ALL','Tous');
define('USER_TYPE','Type d&#146;utilisateur');
define('DELETE_USER','Supprimer l&#146;utilisateur');
define('DELETE_USER_CONFIRM','Etes vous s&#251;r de vouloir supprimer cet utilisateur?');
define('EDIT_PASSWORD_INFO','Si vous n&#146;entrez pas un nouveau mot de passe, il demeurera inchang&#233;.');
define('USER','Utilisateur');
define('ADMINISTRATOR','Administrateur');
define('EDIT_USER','Editer l&#146;utilisateur');

?>