<?php

// German language file
define('LANGUAGE','Sprache');
define('SWITCH_TO_LIST','&Auml;ndern Sie zur Liste');
define('SWITCH_TO_TABLE','&Auml;ndern Sie zum Rasterfield');
define('ID_MATCH','&auml;hnliche '.AUTO_INC_FIELD_NAME);
define('NAME_MATCH','&auml;hnliche '.NAME_FIELD_NAME);

// Dates
define('MONTH_1','Januar');
define('MONTH_2','Februar');
define('MONTH_3','März');
define('MONTH_4','April');
define('MONTH_5','Mai');
define('MONTH_6','Juni');
define('MONTH_7','Juli');
define('MONTH_8','August');
define('MONTH_9','September');
define('MONTH_10','Oktober');
define('MONTH_11','November');
define('MONTH_12','Dezember');

// XML
define('DOWNLOAD_LINK','download');
define('DOWNLOAD_AS_XML','Download der Inventar-Einträge als XML file');

// General
define('APP_TITLE','anyInventory');
define('HOME','Home');
define('ADMINISTRATION','Administration');
define('APPLIES_TO','Anwenden auf');
define('ACTIVE_WHEN','Aktiv wenn');
define('FOOTER_TEXT_PRE','Sie haben inventarisiert');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, dass flexible und mächtigste web-basierte Inventar-System</a>');
define('FOOTER_TEXT_POST','Einträge mit '.ANYINVENTORY_LINK);
define('HELP','Hilfe');
define('EDIT','Editieren');
define('_DELETE','Löschen');
define('CANCEL','Cancel');
define('SUBMIT','Absenden');
define('VALUE','Wert');
define('NAME','Name');
define('EDIT_LINK','editieren');
define('DELETE_LINK','löschen');
define('TYPE','Typ');
define('SELECT_NONE','Keine Auswahl');
define('SUBMIT_REPORT','Sie können bei der Entwicklung von anyInventory mitwirken, indem Sie diesen Fehlerreport an <a href="https://sourceforge.net/tracker/?func­d&amp;group_id.0239&amp;atide5777">senden</a>.');

// Search
define('SEARCH','Suchen');
define('SEARCH_RESULTS','Such-Ergebnisse');
define('IN','In');
define('NO_RESULTS','Keine Treffer');
define('NO_MATCHING_ITEMS','Es wurden keine Treffer zu Ihren Such-Kriterien gefunden.');

// Error messages
define('ERROR','Fehler');
define('ACCESS_DENIED','Zugriff verweigert');
define('ERROR_DUPLICATE_FIELD',"Es gibt bereits ein Feld mit diesem Namen. Wenn Sie ein Feld zu mehreren Kategorien ergänzen möchten können Sie dies tun, indem sie das Feld editieren und mehrere Kategorien wählen indem Sie die Strg-Taste festhalten.");
define('ERROR_BAD_DEFAULT_VALUE',"Der Standard-Wert für eine Auswahl oder ein Radio-Feld muss in die Werteliste eingeschlossen werden.");
define('ERROR_EMPTY_CATEGORY',"Es sind keine Einträge in den ausgewählten Kategorien; dies ist notwendig um Warnungen darin anzulegen.");
define('ERROR_NO_COMMON_FIELDS',"Es sind keine gemeinsamen Felder in den ausgewählten Kategorien.");
define('ERROR_ALERT_NO_CATEGORIES','Eine Warnung muss mindestens einer Kategorie zugeordnet sein.');
define('ERROR_ALERT_NO_ITEMS','Eine Warnung muss zu mindestens einem Inventar-Eintrag zugeordnet werden.');
define('ERROR_NO_TOP_LEVEL_EDIT','Die '.TOP_LEVEL_CATEGORY.' Kategorie kann nicht editiert oder gelöscht werden.');
define('ERROR_NO_VALUES','Sie müssen dem Feld eine Liste von Werten zuordnen.');
define('ERROR_PRIVELEGES','Sie haben nicht die nötige Rechte.');
define('ERROR_DELETE_OWN_ACCOUNT','Sie können nicht Ihren eigenen Benutzer-Account löschen.');
define('ERROR_DUPLICATE_USER','Ein Benutzer mit diesem Namen existiert bereits.');

// Labels
define('LABEL','Label');
define('LABELS','Labels');
define('LABEL_ERROR','Sie haben nicht alle notwendigen PHP-Funktionen installiert um Label zu entwerfen. Diese Funktionen sind: <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, und <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>. Eine oder mehrere dieser Funktionen sind nicht installiert.');
define('LABEL_CAT_INSTRUCTIONS','Wählen Sie die Kategorien aus, zu denen die Einträge gehören, zu denen dann Labels produziert werden sollen. Alle ausgewählten Kategorien müssen mindestens ein gemeinsames Feld besitzen.');
define('LABEL_ITEM_INSTRUCTIONS','Wählen Sie das Feld aus, von dem der Bar-Code produziert werden soll und die Einträge, zu denen die Labels produziert werden sollen.');
define('GENERATE_LABELS','Label erzeugen');
define('GENERATE_FROM','Erzeugen von');
define('GENERATE_FOR','Erzeugen für');

// Fields
define('FIELD','Feld');
define('FIELDS','Felder');
define('ADD_FIELD','Feld ergänzen');
define('DATA_TYPE','Data Typ');
define('TEXT','Text');
define('RADIO','Radio Buttons');
define('CHECKBOX','Checkboxes');
define('SELECT_BOX','Box auswählen');
define('MULTIPLE','Mehrfach ('.TEXT.'   '.SELECT_BOX.')');
define('FILE','File');
define('VALUES','Wert');
define('DEFAULT_VALUE','Standard Wert');
define('VALUES_INFO',"Nur für Daten vom Typ 'Multiple', 'Select Box', 'Checkbox', und 'Radio Buttons.'  Unterteilen mit Komma.");
define('DEFAULT_VALUE_INFO',"Nur für Daten vom Typ 'Multiple', 'Select Box', 'Text', und 'Radio Buttons.'");
define('SIZE','Größe, in Zeichen');
define('_SIZE','Größe');
define('SIZE_INFO',"Nur für 'text' Daten Typ.");
define('HIGHLIGHT','Markiert');
define('HIGHLIGHT_FIELD','Markiere dieses Feld');
define('DELETE_FIELD','Feld löschen');
define('DELETE_FIELD_CONFIRM','Sind Sie sicher, das Feld zu löschen?');
define('NONE','Kein');
define('FIELD_CATS_PRE','Dieses Feld wird benutzt in');
define('AUTO_INCREMENT','automatischer Zähler');
define('SHOW_AUTOINC_FIELD','Zeige Feld mit automatischem Zähler');
define('DIVIDER','Trenner');
define('ADD_DIVIDER','Ergänze Trenner');
define('_FRONT_PAGE_TEXT','Text des Deckblatts');
define('_NAME_FIELD_NAME','"Name" Feld-Name');
define('DOWN_LINK','nach Unten');
define('UP_LINK','nach Oben');
define('EDIT_AUTOINC_FIELD','Editiere Feld mit automatischem Zähler');
define('EDIT_FRONT_PAGE_TEXT','Editiere Text des Deckblatts');
define('EDIT_NAME_FIELD','Editiere Namens-Feld');
define('APPLY_FIELDS',"Dieses Feld allen Untekategorien zuordnen.");
define('ED','Feld editieren');

// Categories
define('CATEGORIES','Kategorien');
define('ADD_CATEGORY','Kategorie ergänzen');
define('TOP_LEVEL_CATEGORY','Top');
define('INHERIT_FIELDS','Inhärentes Feld zur Oberkategorie (ergänzend zu den unten stehenden Feldern)');
define('ADD_CAT_HERE','Kategorie hier ergänzen');
define('NO_SUBCATS','Es sind keine Unter-Kategorien in dieser Kategorie.');
define('SUBCATS_IN','Sub-categories in');
define('PARENT_CATEGORY','Übergeordnete Kategorie');
define('DELETE_CATEGORY','Kategorie löschie');
define('DELETE_CATEGORY_CONFIRM','Sind Sie sicher, dass Sie die Kategorie löschen wollen?');
define('NUM_ITEMS','Anzahl der Einträge');
define('NUM_ITEMS_R','Anzahl der Einträge in dieser und allen Unterkategorien');
define('DELETE_ALL_ITEMS','Alle Einträge in dieser Kategorie löschen.');
define('MOVE_ITEMS_TO','Alle Einträge dieser Kategorie verschieben nach ');
define('NUM_SUBCATS','Anzahl der Unterkategorien');
define('DELETE_ALL_SUBCATS','Alle Unterkategorien löschen');
define('MOVE_SUBCATS_TO','Alle Unterkategorien verschieben nach');
define('NUM_ITEMS_TO','Anzahl der Einträge in dieser <br /> Kategorie und deren Unterkategorien');
define('UPDATE_CATEGORIES','Kategorien updaten ');
define('EDIT_CATEGORY','Kategorie editieren');

// Items
define('ITEMS','Eintrag');
define('ADD_ITEM','Eintrag hinzufügen');
define('ADD_ITEM_HERE','Eintrag hier hinzufügen');
define('ADD_ITEM_TO','Eintrag hinzufügen zu');
define('ITEMS_IN_CAT','Einträge in dieser Kategorie');
define('NO_ITEMS_HERE','Es sind keine Einträge in dieser Kategorie.');
define('MOVE','verschieben');
define('MOVE_LINK','verschieben');
define('RELATED_ITEMS','Einträge mit Bezug');
define('MORE_ITEMS',' et. al.');
define('DELETE_ITEM','Eintrag löschen');
define('DELETE_ITEM_CONFIRM','Sind Sie sicher, den Eintrag zu löschen?');
define('MOVE_ITEM','Eintrag verschieben');
define('MOVE_TO','Verschieben nach');
define('EDIT_ITEM','Eintrag editieren');

// Alerts
define('ALERT','Warnung');
define('ALERTS','Warnungen');
define('EFFECTIVE_DATE','Gültig ab');
define('CONDITION','Bedingung');
define('ADD_ALERT','Warnung hinzufügen');
define('ADD_ALERT_IN','Warnung hinzufügen zu');
define('ALERT_TITLE','Titel der Warnung');
define('TIMED_ONLY_LABEL','Diese Warnung nur  <a href="../docs/de/alerts.php#time_based">zeitbasiert einstellen.</a>.');
define('TIMED_ONLY_EXPLANATION','Für zeitbasierte Warnungen brauchen Sie nicht das Feld, Bedingung oder Wert eingeben.');
define('DELETE_ALERT','Warnung löschen');
define('DELETE_ALERT_CONFIRM','Sind Sie sicher, die Warnung zu löschen?');
define('EDIT_ALERT','Warnung editieren');
define('EXPIRATION_DATE','Verfall-Datum');
define('ALLOW_EXPIRATION','Dieser Warnung erlauben, ungültig zu werden');
define('EMAIL_ALERT_TO','E-mail-Warnung schicken an');
define('EMAIL_ALERT_INFO','Wenn Sie nicht per e-mail benachrichtigt werden möchten lassen Sie das Feld leer.');
define('ALERT_ACTIVATED_BY','Diese Warnung wurde ursprünglich durch diesen Eintrag aktiviert.');

// Users
define('USERS','Benutzer');
define('ADD_USER','Benutzer ergänzen');
define('LOGIN','Login');
define('LOG_OUT','Log Out');
define('USERNAME','Benutzername');
define('PASSWORD','Passwort');
define('GIVE_VIEW_TO','Anzeige-Privilegien geben an');
define('GIVE_ADMIN_TO','Admin-Privilegien geben an');
define('CAN_VIEW','Kann sehen');
define('CAN_ADMIN','Kann verwalten');
define('ALL','Alle');
define('USER_TYPE','Benutzer-typ');
define('DELETE_USER','Benutzer löschen');
define('DELETE_USER_CONFIRM','Sind Sie sicher, den Benutzer zu löschen?');
define('EDIT_PASSWORD_INFO','Wenn Sie kein neues Passwort eingeben bleibt das alte unverändert bestehen.');
define('USER','Benutzer');
define('ADMINISTRATOR','Administrator');
define('EDIT_USER','Benutzer editieren');

?>