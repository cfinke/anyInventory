<?php

// English language file

// Dates
define('MONTH_1','January');
define('MONTH_2','February');
define('MONTH_3','March');
define('MONTH_4','April');
define('MONTH_5','May');
define('MONTH_6','June');
define('MONTH_7','July');
define('MONTH_8','August');
define('MONTH_9','September');
define('MONTH_10','October');
define('MONTH_11','November');
define('MONTH_12','December');

// XML
define('DOWNLOAD_LINK','download');
define('DOWNLOAD_AS_XML','Download inventory as XML file');

// General
define('APP_TITLE','anyInventory');
define('HOME','Home');
define('ADMINISTRATION','Administration');
define('APPLIES_TO','Applies to');
define('ACTIVE_WHEN','Active when');
define('FOOTER_TEXT_PRE','you have inventoried');
define('ANYINVENTORY_LINK','<a href="http://anyinventory.sourceforge.net/">anyInventory, the most flexible and powerful web-based inventory system</a>');
define('FOOTER_TEXT_POST','items with '.ANYINVENTORY_LINK);
define('HELP','Help');
define('EDIT','Edit');
define('_DELETE','Delete');
define('CANCEL','Cancel');
define('SUBMIT','Submit');
define('VALUE','Value');
define('NAME','Name');
define('EDIT_LINK','edit');
define('DELETE_LINK','delete');
define('TYPE','Type');

// Search
define('SEARCH','Search');
define('SEARCH_RESULTS','Search results');
define('IN','In');
define('NO_RESULTS','No matching results');
define('NO_MATCHING_ITEMS','There were no items that matched your search conditions.');

// Error messages
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

// Labels
define('LABEL','Label');
define('LABELS','Labels');
define('LABEL_ERROR','You do not have all of the PHP functions needed to create labels installed.  These functions are <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, and <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  One or more of these functions is not installed.');
define('LABEL_CAT_INSTRUCTIONS','Select the categories to which the items belong for which you want to produce labels.  All categories that you select must have at least one field in common.');
define('LABEL_ITEM_INSTRUCTIONS','Select the field from which you want to produce the barcode and the items for which you want to produce a label.');
define('GENERATE_LABELS','Generate Labels');
define('GENERATE_FROM','Generate from');
define('GENERATE_FOR','Generate for');

// Fields
define('FIELD','Field');
define('FIELDS','Fields');
define('ADD_FIELD','Add Field');
define('DATA_TYPE','Data type');
define('TEXT','Text');
define('RADIO','Radio Buttons');
define('CHECKBOX','Checkboxes');
define('SELECT_BOX','Select Box');
define('MULTIPLE','Multiple ('.TEXT.' + '.SELECT_BOX.')');
define('FILE','File');
define('VALUES','Values');
define('DEFAULT_VALUE','Default value');
define('VALUES_INFO',"Only for data types 'Multiple', 'Select Box', 'Checkbox', and 'Radio Buttons.'  Separate with commas.");
define('DEFAULT_VALUE_INFO',"Only for data types 'Multiple', 'Select Box', 'Text', and 'Radio Buttons.'");
define('SIZE','Size, in characters');
define('_SIZE','Size');
define('SIZE_INFO',"Only for 'text' data type.");
define('HIGHLIGHT','Highlight');
define('HIGHLIGHT_FIELD','Highlight this field');
define('DELETE_FIELD','Delete Field');
define('DELETE_FIELD_CONFIRM','Are you sure you want to delete this field?');
define('NONE','None');
define('FIELD_CATS_PRE','This field is used in');
define('AUTO_INCREMENT','auto-increment');
define('SHOW_AUTOINC_FIELD','Show auto-increment field');
define('DIVIDER','Divider');
define('ADD_DIVIDER','Add Divider');
define('_FRONT_PAGE_TEXT','Front-page text');
define('_NAME_FIELD_NAME','"Name" field name');
define('DOWN_LINK','down');
define('UP_LINK','up');
define('EDIT_AUTOINC_FIELD','Edit Auto-Increment Field');
define('EDIT_FRONT_PAGE_TEXT','Edit Front Page Text');
define('EDIT_NAME_FIELD','Edit Name Field');
define('APPLY_FIELDS',"Apply this category's fields to all subcategories.");
define('EDIT_FIELD','Edit Field');

// Categories
define('CATEGORIES','Categories');
define('ADD_CATEGORY','Add Category');
define('TOP_LEVEL_CATEGORY','Top');
define('INHERIT_FIELDS','Inherit fields from parent (in addition to fields checked below)');
define('ADD_CAT_HERE','Add a category here');
define('NO_SUBCATS','There are no sub-categories in this category.');
define('SUBCATS_IN','Sub-categories in');
define('PARENT_CATEGORY','Parent Category');
define('DELETE_CATEGORY','Delete Category');
define('DELETE_CATEGORY_CONFIRM','Are you sure you want to delete this category?');
define('NUM_ITEMS','Number of items');
define('DELETE_ALL_ITEMS','Delete all items in this category');
define('MOVE_ITEMS_TO','Move all items in this category to ');
define('NUM_SUBCATS','Number of subcategories');
define('DELETE_ALL_SUBCATS','Delete all sub-categories');
define('MOVE_SUBCATS_TO','Move all sub-categories to');
define('NUM_ITEMS_TO','Number of items in this<br /> category and its subcategories');
define('UPDATE_CATEGORIES','Update Categories');
define('EDIT_CATEGORY','Edit Category');

// Items
define('ITEMS','Items');
define('ADD_ITEM','Add Item');
define('ADD_ITEM_HERE','Add an item here');
define('ADD_ITEM_TO','Add Item to');
define('ITEMS_IN_CAT','Items in this Category');
define('NO_ITEMS_HERE','There are no items in this category.');
define('MOVE','Move');
define('MOVE_LINK','move');
define('RELATED_ITEMS','Related Items');
define('MORE_ITEMS',' et. al.');
define('DELETE_ITEM','Delete Item');
define('DELETE_ITEM_CONFIRM','Are you sure you want to delete this item?');
define('MOVE_ITEM','Move Item');
define('MOVE_TO','Move to');
define('EDIT_ITEM','Edit Item');

// Alerts
define('ALERT','Alert');
define('ALERTS','Alerts');
define('EFFECTIVE_DATE','Effective as of');
define('CONDITION','Condition');
define('ADD_ALERT','Add Alert');
define('ADD_ALERT_IN','Add alert in');
define('ALERT_TITLE','Alert Title');
define('TIMED_ONLY_LABEL','Make this alert <a href="../docs/en/alerts.php#time_based">time-based only</a>.');
define('TIMED_ONLY_EXPLANATION','For time-based alerts, you do not need to fill in the field, condition, or value.');
define('DELETE_ALERT','Delete Alert');
define('DELETE_ALERT_CONFIRM','Are you sure you want to delete this alert?');
define('EDIT_ALERT','Edit Alert');
define('EXPIRATION_DATE','Expiration date');
define('ALLOW_EXPIRATION','Allow this alert to expire');
define('EMAIL_ALERT_TO','E-mail alert to');
define('EMAIL_ALERT_INFO','If you do not want to be notified by e-mail when this alert is activated, leave this field blank.');
define('ALERT_ACTIVATED_BY','This alert was initially activated by this item');

// Users
define('USERS','Users');
define('ADD_USER','Add User');
define('LOGIN','Login');
define('LOG_OUT','Log Out');
define('USERNAME','Username');
define('PASSWORD','Password');
define('GIVE_VIEW_TO','Give viewing priveleges to');
define('GIVE_ADMIN_TO','Give admin priveleges to');
define('CAN_VIEW','Can view');
define('CAN_ADMIN','Can admin');
define('ALL','All');
define('USER_TYPE','User type');
define('DELETE_USER','Delete User');
define('DELETE_USER_CONFIRM','Are you sure you want to delete this user?');
define('EDIT_PASSWORD_INFO','If you do not enter a new password, it will remain unchanged.');
define('USER','User');
define('ADMINISTRATOR','Administrator');
define('EDIT_USER','Edit User');

?>