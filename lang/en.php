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
define('GIVE_VIEW_TO','Give viewing priveleges to');
define('GIVE_ADMIN_TO','Give admin priveleges to');
define('SHOW_AUTOINC_FIELD','Show auto-increment field');
define('INHERIT_FIELDS','Inherit fields from parent (in addition to fields checked below)');

define('SEARCH','Search');

define('EDIT','Edit');
define('_DELETE','Delete');
define('CANCEL','Cancel');

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

define('SEARCH_RESULTS','Search results');
define('IN','In');
define('NO_RESULTS','No matching results');
define('NO_MATCHING_ITEMS','There were no items that matched your search conditions.');
define('CAN_VIEW','Can view');
define('CAN_ADMIN','Can admin');
define('ALL','All');
define('USER_TYPE','User type');

define('ADD_ALERT','Add Alert');
define('ADD_ALERT_IN','Add alert in');
define('ALERT_TITLE','Alert Title');

define('TIMED_ONLY_LABEL.','Make this alert <a href="../docs/en/alerts.php#time_based">time-based only</a>.');

define('TIMED_ONLY_EXPLANATION','For time-based alerts, you do not need to fill in the field, condition, or value.');
define('FIELD','Field');

define('CONDITION','Condition');

define('VALUE','Value');

define('ADD_CATEGORY','Add Category');

define('NAME','Name');

define('PARENT_CATEGORY','Parent Category');
define('ADD_FIELD','Add Field');
define('DATA_TYPE','Data type');
define('TEXT','Text');
define('RADIO','Radio Buttons');
define('CHECKBOX','Checkboxes');
define('ITEMS','Item(s)');
define('SELECT_BOX','Select Box');
define('MULTIPLE','Multiple ('.TEXT.' + '.SELECT_BOX.')');
define('FILE','File');
define('VALUES','Values');
define('DEFAULT_VALUE','Default value');

define('VALUES_INFO',"Only for data types 'Multiple', 'Select Box', 'Checkbox', and 'Radio Buttons.'  Separate with commas.");
define('DEFAULT_VALUE_INFO',"Only for data types 'Multiple', 'Select Box', 'Text', and 'Radio Buttons.'");

define('SIZE','Size, in characters');
define('SIZE_INFO',"Only for 'text' data type.");

define('HIGHLIGHT_FIELD','Highlight this field');

define('ADD_ITEM','Add Item');
define('ADD_ITEM_TO','Add Item to');
define('ADD_USER','Add User');

define('EDIT_LINK','edit');
define('DELETE_LINK','delete');

define('MORE_ITEMS',' et. al.');

define('DELETE_ALERT','Delete Alert');
define('DELETE_ALERT_CONFIRM','Are you sure you want to delete this alert?');

define('DELETE_CATEGORY','Delete Category');
define('DELETE_CATEGORY_CONFIRM','Are you sure you want to delete this category?');

define('NUM_ITEMS','Number of items');
define('DELETE_ALL_ITEMS','Delete all items in this category');
define('MOVE_ITEMS_TO','Move all items in this category to ');
define('NUM_SUBCATS','Number of subcategories');
define('DELETE_ALL_SUBCATS','Delete all sub-categories');
define('MOVE_SUBCATS_TO','Move all sub-categories to');

define('NUM_ITEMS_TO','Number of items in this<br /> category and its subcategories');

define('DELETE_FIELD','Delete Field');
define('DELETE_FIELD_CONFIRM','Are you sure you want to delete this field?');

define('NONE','None');

define('FIELD_CATS_PRE','This field is used in');

define('DELETE_ITEM','Delete Item');
define('DELETE_ITEM_CONFIRM','Are you sure you want to delete this item?');

define('DELETE_USER','Delete User');
define('DELETE_USER_CONFIRM','Are you sure you want to delete this user?');

define('EDIT_ALERT','Edit Alert');
define('EDIT_CATEGORY','Edit Category');
define('EDIT_ITEM','Edit Item');
define('EDIT_FIELD','Edit Field');
define('EDIT_USER','Edit User');

define('UPDATE_CATEGORIES','Update Categories');
define('APPLY_FIELDS',"Apply this category's fields to all subcategories.");

define('EDIT_AUTOINC_FIELD','Edit Auto-Increment Field');
define('EDIT_FRONT_PAGE_TEXT','Edit Front Page Text');
define('EDIT_NAME_FIELD','Edit Name Field');

define('EDIT_PASSWORD_INFO','If you do not enter a new password, it will remain unchanged.');

define('USER','User');
define('ADMINISTRATOR','Administrator');

define('DOWN_LINK','down');
define('UP_LINK','up');

define('MOVE_ITEM','Move Item');
define('MOVE_TO','Move to');

define('AUTO_INCREMENT','auto-increment');
define('ADD_DIVIDER','Add Divider');

define('_FRONT_PAGE_TEXT','Front-page text');
define('_NAME_FIELD_NAME','"Name" field name');

define('MOVE_LINK','move');
?>