<?php

// Norwegian Bokmal language file
// Odd-Jarle Kristoffersen (2004-09-24)

define('PAGE_DIMENSIONS','Side st&oslash;rrelse');
define('LABEL_DIMENSIONS','Etikett st&oslash;rrelse');
define('ROWS','rader');
define('COLUMNS','kolonner');
define('LABEL_TEMPLATE','Mal');
define('LANGUAGE','Spr&aring;k');
define('ID_MATCH',AUTO_INC_FIELD_NAME.' Treff');
define('NAME_MATCH',NAME_FIELD_NAME.' Treff');
define('SWITCH_TO_TABLE','Bytt til tabell visning');
define('SWITCH_TO_LIST','Bytt til liste visning');

// Dates
define('MONTH_1','Januar');
define('MONTH_2','Februar');
define('MONTH_3','Mars');
define('MONTH_4','April');
define('MONTH_5','Mai');
define('MONTH_6','Juni');
define('MONTH_7','Juli');
define('MONTH_8','August');
define('MONTH_9','September');
define('MONTH_10','Oktober');
define('MONTH_11','November');
define('MONTH_12','Desember');

// General
define('APP_TITLE','anyInventory');
define('HOME','Hjem');
define('ADMINISTRATION','Administrasjon');
define('APPLIES_TO','Gjelder');
define('ACTIVE_WHEN','Aktiv n&aring;r');
define('FOOTER_TEXT_PRE','du har lagerf&oslash;rt');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, den mest fleksible og kraftige web-baserte lagerf&oslash;ringsl&oslash;sningen</a>');
define('FOOTER_TEXT_POST','ting med '.ANYINVENTORY_LINK);
define('HELP','Hjelp');
define('EDIT','Endre');
define('_DELETE','Slett');
define('CANCEL','Avbryt');
define('SUBMIT','Lagre');
define('VALUE','Verdi');
define('NAME','Navn');
define('EDIT_LINK','lagre');
define('DELETE_LINK','slett');
define('TYPE','Type');
define('SELECT_NONE','Velg ingen');
define('SUBMIT_REPORT','Du kan bist&aring; i utviklingen av anyInventory ved &aring; <a href="https://sourceforge.net/tracker/?func=add&amp;group_id=110239&amp;atid=655777">sende inn denne feilen som en feilmelding</a>.');

// Search
define('SEARCH','S&oslash;k');
define('SEARCH_RESULTS','S&oslash;keresultat');
define('IN','i');
define('NO_RESULTS','Ingen treff');
define('NO_MATCHING_ITEMS','Det var ingen treff for ditt s&oslash;kekriterie.');

// Error messages
define('ERROR','Feil');
define('ACCESS_DENIED','Ikke tilgang');
define('ERROR_DUPLICATE_FIELD',"Det finnes allerede et felt med det navnet du benyttet. Om du &oslash;nsker &aring; legge til et felt til flere kategorier s&aring; redigerer du feltet og velger flere kategorier ved &aring; holde nede CTRL-tasten.");
define('ERROR_BAD_DEFAULT_VALUE',"Standardverdien du har angitt for en liste eller radiofelt m&aring; være inkludert i listen av verdier.");
define('ERROR_EMPTY_CATEGORY',"Det var ingen enheter i kategoriene du valgte; det mæ være enheter i en kategori f&oslash;r du kan sette opp varsel for den.");
define('ERROR_NO_COMMON_FIELDS',"Ingen felles felt i kategoriene du valgte.");
define('ERROR_ALERT_NO_CATEGORIES','Et varsel m&aring; gjelde for minst en kategori.');
define('ERROR_ALERT_NO_ITEMS','Et varsel m&aring; gjelde for minst en enhet.');
define('ERROR_NO_TOP_LEVEL_EDIT',' '.TOP_LEVEL_CATEGORY.' kategorien kan ikke redigeres eller slettes.');
define('ERROR_NO_VALUES','Du m&aring; angi en liste av verdier for dette feltet.');
define('ERROR_PRIVELEGES','Du har ikke de n&oslash;dvendige rettigheter.');
define('ERROR_DELETE_OWN_ACCOUNT','Du kan ikke slette din egen konto.');
define('ERROR_DUPLICATE_USER','En bruker med det brukernavnet eksisterer allerede.');

// Labels
define('LABEL','Etikett');
define('LABELS','Etiketter');
define('LABEL_ERROR','Du har ikke alle de n&oslash;dvendige PHP funksjoner som kreves for &aring; lage etiketter. Disse funksjonene er <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, and <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  En eller flere av disse funksjonene er ikke installert p&aring; ditt system.');
define('LABEL_CAT_INSTRUCTIONS','Velg kategorien som enhetene du &oslash;nsker &aring; lage etiketter til tilh&oslash;rer. Alle kategorier som du leger m&aring; ha minst et felt felles.');
define('LABEL_ITEM_INSTRUCTIONS','Velg feltet som du &oslash;nsker &aring; bruke til strekkode, og den enheten som du &oslash;nsker &aring; lage en etikett for.');
define('GENERATE_LABELS','Lag etiketter');
define('GENERATE_FROM','Generer fra');
define('GENERATE_FOR','Generer for');

// Fields
define('FIELD','Felt');
define('FIELDS','Felt');
define('ADD_FIELD','Legg til felt');
define('DATA_TYPE','Datatype');
define('TEXT','Tekst');
define('RADIO','Radioknapper');
define('CHECKBOX','Sjekkbokser');
define('SELECT_BOX','Valg');
define('MULTIPLE','Flere ('.TEXT.' + '.SELECT_BOX.')');
define('FILE','Fil');
define('VALUES','Verdi');
define('DEFAULT_VALUE','Standard verdi');
define('VALUES_INFO',"Kun for datatypene 'Flere', 'Valg', 'Sjekkboks' og 'Radioknapper'. Avskilt med komma.");
define('DEFAULT_VALUE_INFO',"Kun for datatypene 'Flere', 'Valg', 'Sjekkboks' og 'Radioknapper'.");
define('SIZE','St&oslash;rrelse (antall tegn)');
define('_SIZE','St&oslash;rrelse');
define('SIZE_INFO',"Kun for datatypen 'tekst'.");
define('HIGHLIGHT','Uthev');
define('HIGHLIGHT_FIELD','Uthev dette feltet');
define('DELETE_FIELD','Slett felt');
define('DELETE_FIELD_CONFIRM','Er du sikker p&aring; at du &oslash;nsker &aring; slette dette feltet?');
define('NONE','Ingen');
define('FIELD_CATS_PRE','Dette feltet er brukt i');
define('AUTO_INCREMENT','automatisk &oslash;kning');
define('SHOW_AUTOINC_FIELD','Vis automatisk &oslash;nsings feltet');
define('DIVIDER','Skilletegn');
define('ADD_DIVIDER','Legg til skille');
define('_FRONT_PAGE_TEXT','Hovedside tekst');
define('_NAME_FIELD_NAME','"Navn" felt navn');
define('DOWN_LINK','ned');
define('UP_LINK','opp');
define('EDIT_AUTOINC_FIELD','Rediger automatisk &oslash;knings feltet');
define('EDIT_FRONT_PAGE_TEXT','Rediger hovedside tekst');
define('EDIT_NAME_FIELD','Rediger navnefeltet');
define('APPLY_FIELDS',"Bruk denne kategoriens felt p&aring; alle underkategorier.");
define('EDIT_FIELD','Rediger felt');

// Categories
define('CATEGORIES','Kategorier');
define('ADD_CATEGORY','Legg til kategori');
define('TOP_LEVEL_CATEGORY','Topp');
define('INHERIT_FIELDS','Arve felt fra kategorien over (i tillegg til feltene som er valgt under)');
define('ADD_CAT_HERE','Legg til en kategori her');
define('NO_SUBCATS','Det er ingen underkategorier i denne kategorien.');
define('SUBCATS_IN','Underkategorier i');
define('PARENT_CATEGORY','Hovedkategori');
define('DELETE_CATEGORY','Slett kategori');
define('DELETE_CATEGORY_CONFIRM','Er du sikker p&aring; at du vil slette denne kategorien?');
define('NUM_ITEMS','Antall enheter');
define('NUM_ITEMS_R','Antall enheter i denne og alle underkategorier');
define('DELETE_ALL_ITEMS','Slett alle enheter i denne kategorien');
define('MOVE_ITEMS_TO','Flytt alle enheter i denne kategorien til ');
define('NUM_SUBCATS','Antall underkategorier');
define('DELETE_ALL_SUBCATS','Slett alle underkategorier');
define('MOVE_SUBCATS_TO','Flytt alle underkategorier til');
define('NUM_ITEMS_TO','Antall enheter i denne<br/> kategorien og dens underkategorier');
define('UPDATE_CATEGORIES','Oppdater kategorier');
define('EDIT_CATEGORY','Rediger kategori');

// Items
define('ITEMS','Enheter');
define('ADD_ITEM','Legg til enhet');
define('ADD_ITEM_HERE','Legg til enhet her');
define('ADD_ITEM_TO','Legg enhet til');
define('ITEMS_IN_CAT','Enheter i denne kategorien');
define('NO_ITEMS_HERE','Det er ingen enheter i denne kategorien.');
define('MOVE','Flytt');
define('MOVE_LINK','flytt');
define('RELATED_ITEMS','Relaterte enheter');
define('MORE_ITEMS',' mere.');
define('DELETE_ITEM','Slett enhet');
define('DELETE_ITEM_CONFIRM','Er du sikker p&aring; at du &oslash;nsker &aring; slette denne enheten?');
define('MOVE_ITEM','Flytt enhet');
define('MOVE_TO','Flytt til');
define('EDIT_ITEM','Rediger enhet');

// Alerts
define('ALERT','Varsel');
define('ALERTS','Varsler');
define('EFFECTIVE_DATE','Gyldig fra og med');
define('CONDITION','Tilstand');
define('ADD_ALERT','Legg til varsel');
define('ADD_ALERT_IN','Legg til varsel i');
define('ALERT_TITLE','Navn p&aring; varsel');
define('TIMED_ONLY_LABEL','Gj&oslash;r dette varslet kun <a href="../docs/alerts.php#time_based">tidsbasert</a>.');
define('TIMED_ONLY_EXPLANATION','For tidsbaserte varsler trenger du ikke fylle inn feltet, tilstand eller verdi.');
define('DELETE_ALERT','Slett varsel');
define('DELETE_ALERT_CONFIRM','Er du sikker p&aring; at du &oslash;nsker &aring; slette dette varslet?');
define('EDIT_ALERT','Rediger varsel');
define('EXPIRATION_DATE','Utl&oslash;psdato');
define('ALLOW_EXPIRATION','La varslet f&aring; lovt til &aring; utl&oslash;pe');
define('EMAIL_ALERT_TO','Send e-post varsel til');
define('EMAIL_ALERT_INFO','Hvis du ikke &oslash;nsker &aring; bli varslet via e-post n&aring;r dette varslet er aktivt lar du feltet være blankt.');
define('ALERT_ACTIVATED_BY','Dette varslet var opprinnelig aktivert av denne enheten');

// Users
define('USERS','Brukere');
define('ADD_USER','Legg til bruker');
define('LOGIN','Log p&aring;');
define('LOG_OUT','Log av');
define('USERNAME','Brukernavn');
define('PASSWORD','Passord');
define('GIVE_VIEW_TO','Gi visningsrettigheter til');
define('GIVE_ADMIN_TO','Gi administrative rettigheter til');
define('CAN_VIEW','Kan se');
define('CAN_ADMIN','Kan administrere');
define('ALL','Alle');
define('USER_TYPE','Bruker type');
define('DELETE_USER','Slett bruker');
define('DELETE_USER_CONFIRM','Er du sikker p&aring; at du &oslash;nsker &aring; slette denne brukeren?');
define('EDIT_PASSWORD_INFO','Hvis du ikke skriver nytt passord vil passordet forbli uendret.');
define('USER','Bruker');
define('ADMINISTRATOR','Administrator');
define('EDIT_USER','Rediger bruker');

define('ON_SUBMIT','On Submit');
define('ADD_ITEM_HERE','Add another item here');
define('RETURN_TO_ITEMS','Return to items page');

// Barcodes
define('BARCODE_I25', '<p>Interleaved 2 of 5 (Code 25)</p>
							<p>Interleaved 2 of 5 is a high density variable length numeric only symbology
							  that encodes digit pairs in an interleaved manner. The odd position digits
							  are encoded in the bars and the even position digits are encoded in the
							  spaces. Because of this, I 2 of 5 bar codes must consist of an even number
							  of digits. Also, because partial scans of I 2 of 5 bar codes have a slight
							  chance of being decoded as a valid (but shorter) bar code, readers are
							  usually set to read a fixed (even) number of digits when reading I 2 of
							  5 symbols. The number of digits are usually pre-defined for a particular
							  application and all readers used in the application are programmed to only
							  accept I 2 of 5 bar codes of the chosen length. Shorter data can be left
							  padded with zeros to fit the proper length. Interleaved 2 of 5 optionally
							  allows for a weighted modulo 10 check character for special situations
							  where data security is important. <br>
							  anyInventory will pad out your number
							  to even length using the pad char, but it will not add the check character
							automatically. </p> ');
define('BARCODE_C39', '<p>Code 39</p>
							<p>Code 39 is a variable length symbology that can encode the
							  following 44 characters: 1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ-. *$/+%.
							  Each Code 39 bar code is framed by a start/stop character represented by an asterisk
							  (*). The asterisk is reserved for this purpose and may not be used in the
							body of a message. <br>
							anyInventory will automatically add the asterisk to
							the start and stop. </p> ');
define('BARCODE_C128', '<p>Code 128 has 106 different printed barcode patterns. Each
								printed barcode can have one of three different meanings depending on
								which of the three character sets are used. Three different Code 128
								start characters are available to tell the scanner which character set
								is initially being used. Use Code 128 when you need alphanumeric or very
								compact numeric only barcodes.</p>');
define('BARCODE_C128A', '<p>Code 128A</p>
							<p>Character set A allows for uppercase characters, punctuation, numbers
							  and several special functions such as a return or tab.</p>');
define('BARCODE_C128B', '<p>Code 128B</p>
							<p>Character set B is the most common because it encodes everything from
							  ASCII 32 to ASCII 126. It allows for upper and lower case letters, punctuation,
							numbers and a few select functions.</p>');
define('BARCODE_C128C', '<p>Code 128C</p>
							<p> Character set C encodes only numbers and the FNC1 function. Because
							  the numbers are &quot;interleaved&quot; into pairs, two numbers are encoded
							  into every barcode character which makes it a very high density barcode.
							  If your number is not even, anyInventory will add the pad character to
							  even it out. </p>');
define('BARCODE_FOOTER', 'Check Digit Requirement - in Code 128, The modulo 103 Symbol Check Character
						is required and it is only encoded in the bar code. The check digit should never
						appear in human the readable interpretation below the bar code. anyInventory
							  will automatically add a check digit to your Code 128 barcodes.');

?>
