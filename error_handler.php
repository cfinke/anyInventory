<?php

include("globals.php");

$title = APP_TITLE.": ".ERROR;

$errors = array();

$errors[0] = array(ERROR,ERROR_DUPLICATE_FIELD,"breadcrumbs"=>ERROR);
$errors[1] = array(ERROR,ERROR_BAD_DEFAULT_VALUE,"breadcrumbs"=>ERROR);
$errors[2] = array(ERROR,ERROR_EMPTY_CATEGORY,"breadcrumbs"=>ERROR);
$errors[3] = array(ERROR,ERROR_NO_COMMON_FIELDS,"breadcrumbs"=>ERROR);
$errors[5] = array(ERROR,ERROR_ALERT_NO_CATEGORIES,'breadcrumbs'=>ERROR);
$errors[6] = array(ERROR,ERROR_ALERT_NO_ITEMS,'breadcrumbs'=>ERROR);
$errors[7] = array(ERROR,ERROR_NO_TOP_LEVEL_EDIT,'breadcrumbs'=>ERROR);
$errors[8] = array(ERROR,ERROR_NO_VALUES,'breadcrumbs'=>ERROR);
$errors[10] = array(ACCESS_DENIED,ERROR_PRIVELEGES,'breadcrumbs'=>ACCESS_DENIED);
$errors[11] = array(ACCESS_DENIED,ERROR_PRIVELEGES,'breadcrumbs'=>ACCESS_DENIED);
$errors[12] = array(ACCESS_DENIED,ERROR_PRIVELEGES,'breadcrumbs'=>ACCESS_DENIED);
$errors[13] = array(ACCESS_DENIED,ERROR_PRIVELEGES,'breadcrumbs'=>ACCESS_DENIED);
$errors[14] = array(ACCESS_DENIED,ERROR_DELETE_OWN_ACCOUNT.'breadcrumbs'=>ACCESS_DENIED);
$errors[15] = array(ACCESS_DENIED,ERROR_PRIVELEGES,'breadcrumbs'=>ACCESS_DENIED);
$errors[16] = array(ERROR,ERROR_DUPLICATE_USER,'breadcrumbs'=>ERROR);
$errors[17] = array(ERROR,ERROR_BARCODE,"breadcrumbs"=>ERROR);

$breadcrumbs = $errors[$_GET["eid"]]["breadcrumbs"];

$output = '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>'.$errors[$_GET["eid"]][0].'</td>
		</tr>
		<tr>
			<td class="tableData">
				<table>
					<tr>
						<td>'.$errors[$_GET["eid"]][1].'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>