<?php

// English language file

define('APP_TITLE','anyInventory 1.8');
define('APPLIES_TO','Applies to');
define('ACTIVE_WHEN','Active when');
define('EFFECTIVE_DATE','Effective as of');
define('ALERT','Alert');
define('TOP_LEVEL_CATEGORY','Top');
define('ERROR','Error');
define('ACCESS_DENIED','Access Denied');

define('ERROR_DUPLICATE_FIELD',"There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.");
define('ERROR_BAD_DEFAULT_VALUE',"The default value for a select or radio field must be included in the list of values.");
define('ERROR_EMPTY_CATEGORY',"There were no items in the categories you selected; there must be items in a category for you to add an alert in it.");
define('ERROR_NO_COMMON_FIELDS',"There were no common fields in the categories you selected.");
define('ERROR_ALERT_NO_CATEGORIES','An alert must apply to at least one category.');
define('ERROR_ALERT_NO_ITEMS','An alert must apply to at least one item.');
define('ERROR_NO_TOP_LEVEL_EDIT','The '.TOP_LEVEL_CATEGORY.' category cannot be edited or deleted.');
define('ERROR_NO_VALUES','You must supply a list of values for this field.');
define('ERROR_PRIVELEGES','You do not have the necessary priveleges.');
define('ERROR_DELETE_OWN_ACCOUNT','You cannot delete your own user account.');
define('ERROR_DUPLICATE_USER','A user with that name already exists.');

define('FOOTER_TEXT_PRE','you have inventoried');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, the most flexible and powerful web-based inventory system</a>');
define('FOOTER_TEXT_POST','items with '.ANYINVENTORY_LINK);

define('LOG_OUT','Log Out');
define('HOME','Home');
define('LABELS','Labels');
define('HELP','Help');

define('ADMINISTRATION','Administration');
define('FIELDS','Fields');
define('CATEGORIES','Categories');
define('ITEMS','Items');
define('ALERTS','Alerts');
define('USERS','Users');

define('SEARCH','Search');

define('EDIT','Edit');
define('_DELETE','Delete');

define('ADD_CAT_HERE','Add a category here');
define('NO_SUBCATS','There are no sub-categories in this category.');

define('SUBCATS_IN','Sub-categories in');
define('ITEMS_IN_CAT','Items in this Category');
define('ADD_ITEM_HERE','Add an item here');

define('NO_ITEMS_HERE','There are no items in this category.');

define('MOVE','Move');

define('LABEL','Label');

define('RELATED_ITEMS','Related Items');

define('LABEL_ERROR','You do not have all of the PHP functions needed to create labels installed.  These functions are <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, and <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  One or more of these functions is not installed.');

define('GENERATE_LABELS','Generate Labels');
define('LABEL_CAT_INSTRUCTIONS','Select the categories to which the items belong for which you want to produce labels.  All categories that you select must have at least one field in common.');
define('SUBMIT','Submit');

define('LABEL_ITEM_INSTRUCTIONS','Select the field from which you want to produce the barcode and the items for which you want to produce a label.');
define('GENERATE_FROM','Generate from');
define('GENERATE_FOR','Generate for');

define('LOGIN','Login');
define('USERNAME','Username');
define('PASSWORD','Password');

?>