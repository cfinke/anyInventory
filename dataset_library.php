<?php

// +----------------------------------------------------------------------+
// | Dataset Library	1.02b			                                  |
// | Started by Blaine Garrett & Justin Gehring on 2004-05-21 09:30:00 	  |
// +----------------------------------------------------------------------+
// | Purpose Description...									              |
// |																	  |
// |	The dataset library allows you to quickly and easily create       |
// |	standardized table rows of data with paging and sorting options.  |
// |	Simply feed the library a query without LIMIT, and ORDER info     |
// |	and let the library generate the sql result as well as the        |
// |	sorting and paging. Note, the library does not currently output   |
// |	 <table> tags, only <tr> so you can establish your own tables.	  |
// |																	  |
// | Features:															  |
// |	Sorting/paging are 'sticky' so you can leave the page and come    |
// |	   and have it remember your selections. 				          |
// |	Allows for multiple datasets per page and session to work and be  |
// |	   sticky independently. 										  |
// +----------------------------------------------------------------------+
// | Usage...						    					   			  |
// |																	  |
// |	To be able to dynamically generate columns for the data table     |
// |	   you must specifically select the db columns you want to have   |
// |	   be data set columns.	To do this, simply format SELECT          |
// |       statements like:   											  |
// |			SELECT *, `LAST_NAME` AS `sortcol_lastname`, ...    	  |
// |		for columns you want to sort by, and :    	  				  |
// |			SELECT *, `LAST_NAME` AS `nosortcol_lastname`, ...    	  |
// |		for columns you do not want to sort by.    					  |
// |		Note that you can create Constant column values in mysql with:|
// |			SELECT *, CONCAT(' ',' ') AS `nosortcol_options`,...  |
// |															    	  |
// |//Example : Quicky    												  |
// |	    													     	  |
// |	//do paging and all that later...    							  |
// |	$query =     		 											  |
// |	'SELECT *,CONCAT(' ',' ') AS `nosortcol_options`,     		  |
// |		`lastname` AS `sortcol_lastname`,     		       			  |
// |		`firstname` AS `sortcol_firstname`    						  |
// |	 FROM `db`.`members`     				     					  |
// |	 WHERE `id` IS NOT NULL ';    		    	     				  |
// |	    												     		  |
// |	//create a new dataset lib object to display the data    		  |
// |	$data_obj = new dataset_library('senior_outreach_noapas_form',    |
// |									$query, $_REQUEST,'mysql');		  |
// |	$result = $data_obj->get_result_resource();    					  |
// |	$rows = $data_obj->get_result_set();    						  |
// |	    						 									  |
// |	/*generate body of table cells making sure we have one <td>       |
// |		per sortcol_* in our query */    					      	  |
// |	if (mysql_mysql_num_rows($result) > 0 ) {    						 	  |
// |		$i = 0;    													  |
// |		while($row = mysql_fetch_assoc($result)) {    				  |
// |			$color_code = (($i % 2) == 1)? 'row_on':'row_off';    	  |
// |			$table_set .= '<tr class="'. $color_code .'">';    		  |
// |			$table_set .=     						 				  |
// |				'<td align="center">[edit][delete]</td>    			  |
// |				 <td width="50%">' . $row['lastname']  . '</td>    	  |
// |				 <td width="50%">' . $row['firstname'] . '</td>';     |
// |			$table_set .= "</tr>";    						  		  |
// |			$i++;    						  						  |
// |		}    						 								  |
// |	}    						 									  |
// |	else $table_set .= '<tr class="row_off"><td>There are     		  |
// |		no members to display</td></tr>';    						  |
// |	    						  									  |
// |	//prepend on sorting interface row    					     	  |
// |	$table_set = $data_obj->get_sort_interface()     			      |
// |				. $table_set    						 			  |
// |				. $data_obj->get_paging_interface();    			  |
// |	echo '<table>' . $table_set . '</table>';    					  |
// |	exit;    						  								  |
// |	    						  									  |
// +----------------------------------------------------------------------+
// | Author(s): Blaine Garrett <bgarrett@class.cla.umn.edu>               |
// |	    	Justin Gehring <gehring@class.cla.umn.edu>                |
// +----------------------------------------------------------------------+
// | Revision History: see bottom of file for significant revisions 	  |
// +----------------------------------------------------------------------+

class dataset_library {
	//////////////////////////////////////////////////////
	// Admin Specified Member Vars (should be private?) //
	//////////////////////////////////////////////////////
	var $query;
	var $db_type;
	var $name; //ID of this for
	
	var $result_resource;
	var $col_num = 0;
	var $header_cols_sort = array(); //headers
	
	var $start_offset = 0;
	var $result_length = 20;
	var $sort_col = false;
	var $sort_order = 'ASC';
	
	//image sources for sorting arrows
	var $up_arrow_img_src = 'images/arrow_up.gif';
	var $down_arrow_img_src = 'images/arrow_down.gif';
	
	function dataset_library($id, $query, $request, $db_type, $default_sort_column = false){
		global $DIR_PREFIX;
		
		$this->up_arrow_img_src = $DIR_PREFIX.$this->up_arrow_img_src;
		$this->down_arrow_img_src = $DIR_PREFIX.$this->down_arrow_img_src;
		
		///////////////////////////////////////////////////
		// Step 1) Store important arguements
		///////////////////////////////////////////////////
		$this->query = $query;
		$this->db_type = $db_type;
		$this->name = $id;
		$result_query = $query; //make copy of query to manipulate
		$this->sort_col = $default_sort_column;
		
		////////////////////////////////////////////////////////////
		// Step 2) Save Requested Values to "sticky" session vars //
		////////////////////////////////////////////////////////////
		if (isset($request['nav'][$this->name]['start_offset']))
			$_SESSION['nav'][$this->name]['start_offset'] = $request['nav'][$this->name]['start_offset'];
		
		if (isset($request['nav'][$this->name]['result_length']))
			$_SESSION['nav'][$this->name]['result_length'] = $request['nav'][$this->name]['result_length'];
		
		if (isset($request['nav'][$this->name]['sort_col']))
			$_SESSION['nav'][$this->name]['sort_col'] = $request['nav'][$this->name]['sort_col'];
			
		if (isset($request['nav'][$this->name]['sort_order']))
			$_SESSION['nav'][$this->name]['sort_order'] = $request['nav'][$this->name]['sort_order'];
			
		//////////////////////////////////////////////////////////////////////////////////
		//  Store "Sticky" or Requested values to object for later use or set defaults  //
		//////////////////////////////////////////////////////////////////////////////////
		if (isset($_SESSION['nav'][$this->name]['start_offset']))
			$this->start_offset = $_SESSION['nav'][$this->name]['start_offset'];
		else  $this->start_offset = 0;  //Defaults		
		
		if (isset($_SESSION['nav'][$this->name]['result_length']))
			$this->result_length = $_SESSION['nav'][$this->name]['result_length'];
		else $this->result_length = 25; //Default should be specified by user?
		
		if (isset($_SESSION['nav'][$this->name]['sort_col']))
			$this->sort_col = $_SESSION['nav'][$this->name]['sort_col'];
		//else $this->sort_col = false; //Default should be specified by user?
		
		if (isset($_SESSION['nav'][$this->name]['sort_order']))
			$this->sort_order = $_SESSION['nav'][$this->name]['sort_order'];
		else $this->sort_order = 'ASC'; 
		
		//Append Ordering Info
		if ($this->sort_col) 
			$result_query .= ' ORDER BY `' . $this->sort_col . '` ' . $this->sort_order;
			
		//Append Limit information to base query
		if (strtolower($this->result_length) != 'all')
			$result_query .= ' LIMIT ' . $this->start_offset . ',' . $this->result_length;
		
		//Attach SQL_CALC_FOUND_ROWS to SELECT for FOUND_ROWS in order to easily calculate the total items
		//   Scope out mysql documentation for more info... 
		//	 http://dev.mysql.com/doc/mysql/en/Information_functions.html
		
		$pattern = "/^(.*)(SELECT)(.*)(FROM)/is";
		$replacement = "\\1\\2 SQL_CALC_FOUND_ROWS \\3\\4";
		$result_query =  preg_replace($pattern, $replacement, $result_query);
		
		//////////////////////////////////////
		//Query for actual data	 			//
		//////////////////////////////////////
		$result = mysql_query($result_query) or user_error('ERROR: ' . $result_query . '<br />' . mysql_error(), E_USER_ERROR);
		$this->result_resource = $result;
		//echo '<BR><BR><strong>ACTUAL QUERY RAN: </strong><pre>' . $result_query . '</pre>';
		
		//////////////////////////////////////////////////////
		//prepare info for sorting and paging interface 	//
		//////////////////////////////////////////////////////
		
		//query for total items using FOUND_ROWS(). See above comment for documentation info on this mysql fun.
		$total_query = 'SELECT FOUND_ROWS()';
		$total_result = mysql_query($total_query) or user_error(mysql_error(), E_USER_ERROR);
		$total_items = mysql_fetch_row($total_result);
		$this->total_items = $total_items[0];
		
		//loop through columns to see which ones we want to display, and additionally, which ones are sortable
		$pattern = array("/^(.*)(SELECT)(.*)(FROM)(.*)$/is", "/( AS )(`|)(sortcol_|nosortcol_)([^`]*)(`|)(,|)/is");
		$replacement = array("\\3", "(xoxoxoxUNIQUExoxoxox)\\3\\4(xoxoxoxUNIQUExoxoxox)");
		$temp_output =  preg_replace($pattern, $replacement, $query);
		$potential_columns_array = explode('(xoxoxoxUNIQUExoxoxox)', $temp_output);
		
		//do final pass to filter out any bad cols that made it through, and categorize good ones as sortable or not
		foreach ($potential_columns_array as $colname) {
			$colname = trim($colname);  
			//display column, sortable
			if (substr($colname, 0, 8) == 'sortcol_') {
				$this->col_num++;
				$this->header_cols_sort[str_replace('sortcol_', '', $colname)] = true; 
			}
			//display column, but not sortable
			else if (substr($colname, 0, 10) == 'nosortcol_') {
				$this->col_num++;
				$this->header_cols_sort[str_replace('nosortcol_', '', $colname)] = false;
			}
			//else   we do not want to use this column as a display one
		}
	}
	
	function get_result_set() {  return $this->result_array; 	}
	function get_result_resource() { return  $this->result_resource; } 
	
	function get_sort_interface() {
		//put the id of this object as part of the js function name
		
		$output = '<tr class="row_head">';
		
		//iterate through cols we want
		
		foreach ($this->header_cols_sort as $colname => $sortable) {
			$output .= '<td align="center"><span style="white-space:nowrap;';
			//bold the col if we are currently sorting by it
			if ('sortcol_' . $colname == $this->sort_col)
				$output .= 'font-weight:bold;';
			$output .= '">';
			
			//if the page is sortable, then display sort link/info
			if ($sortable) {
				$output .= '<a href="javascript:void(0);" title="Sort by ' . $colname . '"
				onClick="
				javascript:
				var sort_form_obj = document.forms[\'paging_form_' . $this->name . '\'];
				var sort_col_obj =  sort_form_obj.elements[\'nav[' . $this->name . '][sort_col]\'];
				var sort_order_obj = sort_form_obj.elements[\'nav[' . $this->name . '][sort_order]\'];
				if (sort_col_obj.value == \'sortcol_' . $colname . '\') 
					sort_order_obj.value = (sort_order_obj.value == \'DESC\') ? \'ASC\' : \'DESC\';
				else {
					sort_order_obj.value = \'ASC\';
					sort_col_obj.value = \'sortcol_' . $colname . '\';
				}
				sort_form_obj.submit();
				return false;">' . $colname .'</a>'; 
				
				if ('sortcol_' . $colname == $this->sort_col) 
					$output .= '<img src="' . (($this->sort_order == 'ASC') ? $this->up_arrow_img_src : $this->down_arrow_img_src) . '" title="Sorted ' . (($this->sort_order == 'ASC') ? 'ascending' : 'descending') . '"/>';
			}
			else
				$output .= $colname;
			$output .= '</span></td>';
		}
		$output .=  '</tr>';
		
		$output = 
		'<form name="paging_form_' . $this->name . '" id="sorting_form_' . $this->name . '" method="post" action="">' 
		. $output . 
		'<input type="hidden" name="nav[' . $this->name . '][sort_col]" value="' . (($this->sort_col) ? '' . $this->sort_col : '') . '" />
		 <input type="hidden" name="nav[' . $this->name . '][sort_order]" value="' . $this->sort_order . '" />
		 </form>';
		
		return $output;
	}

	function get_paging_interface($data_label = 'results') {
		//////////////////////////////////////////////
		// Get total number of items 				//
		//////////////////////////////////////////////
		//Note this used to be calculated here, but since we are now using the faster FOUND_ROWS() method, 
		//		we have to calculate the rows right after we run the LIMIT query.
		$total_items = $this->total_items;
		
		///////////////////////////////////////////////////////
		// Construct Option List for startoffset select      //
		///////////////////////////////////////////////////////
		
		if (strtolower($this->result_length) == 'all')
			$start_offset_options =  '<option value="0" selected="1">1 - ' . $total_items . '</option>';
		else if ($total_items == 0)
			$start_offset_options =  '<option value="0" selected="1">none</option>';
		else {
			for ($temp_start = 0; ($total_items - $temp_start) > 0; $temp_start = ($temp_start + $this->result_length)){
				if (($total_items - $this->result_length - $temp_start) > 0)
					$end_number = $temp_start + $this->result_length;
				else
					$end_number = $temp_start + ($total_items - $temp_start);
				
				//select
				$SELECTED  = ($temp_start == $this->start_offset) ?  ' selected="1"' : '';
				$start_offset_options .=  '<option value="' . $temp_start . '"' . $SELECTED . '>' . ($temp_start + 1) . ' - ' . ($end_number) . '</option>';
			}
		}
		/////////////////////////////////////////////////////////
		// Construct Option List for result_length select      //
		/////////////////////////////////////////////////////////
		
		//build array of items_per_page to help make select box
		$items_per_page_array = Array(10);
		
		for ($i = 25; $i <=100; $i += 25) 
			$items_per_page_array[] = $i;
		$items_per_page_array[] = 'ALL';
		
		//build offset options...
		foreach ($items_per_page_array as $value){
			$SELECTED = (strtolower($this->result_length) == $value) ? ' selected="1"' : '';
			$result_length_options .= '<option value="' . $value . '"' . $SELECTED . '>' . $value . '</option>';
		}
		
		//////////////////////////////////////////////////////////////
		// Generate the HTML 										//
		//////////////////////////////////////////////////////////////
		$items_per_page_select =   '<select name="nav[' . $this->name . '][result_length]" onchange="javascript:this.form.submit();">' . $result_length_options . '</select>';
		$start_offset_select_box = '<select name="nav[' . $this->name . '][start_offset]"  onchange="javascript:this.form.submit();">' . $start_offset_options. '</select>';
		
		$output = 
		'<form name="paging_form_' . $this->name . '" id="sorting_form_' . $this->name . '" method="post" action="">
		<tr class="row_head">
			<td align="left" colspan="' . $this->col_num . '">
				<span style="float:left;">Displaying ' . $data_label . ' ' . $start_offset_select_box . ' of ' . $total_items . '.</span> 
				<span style="float:right;">Display  ' . $items_per_page_select . ' ' . $data_label . ' per page.</span>
			</td>
		</tr>
		</form>';
		
		return $output;
	}
}
// +----------------------------------------------------------------------+
// | Significant Revision History			 							  |
// +----------------------------------------------------------------------+
// |																	  |
// +----------------------------------------------------------------------+
// |																	  |
// +----------------------------------------------------------------------+
// |																	  |
// +----------------------------------------------------------------------+
// | 2004-05-28 : 1.02b : Fixed bug for when sort column names 			  |
// |					contain spaces. Special thanks to Chris Finke 	  |
// |					<chris@efinke.com>	for finding this.     		  |
// +----------------------------------------------------------------------+
// | 2004-05-21 : 1.01b : Added FOUND_ROWS() to calculate total items     |
// |					instead of doing an extra query.     			  |
// |			  Added CSS white-space:nowrap to column headers     	  |
// |			  Constructor takes in required dbtype now, and optional  |
// |			  	 default sort column.     			 				  |
// |			  Currently sorted column is now bolded 				  |
// |			  CVS version 1.5	 									  |
// +----------------------------------------------------------------------+
// | 2004-05-20 : 1.0b : Completed 1.0b CVS version 1.0					  |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | To do List				     			 							  |
// +----------------------------------------------------------------------+
// |	Add support for mssql    			 							  |
// |	Fix bug where you are at the end of result set with limit 10 and  |
// |		then switch to 25 and offset select box says 1-25 		      |
// |	Add support for Unions  and other whacky SQL statements 		  |
// |	Add support for other possible conditions in WHERE such as   	  |
// |		ABC limit for a column or other user specified conds.    	  |
// |	Make base class and child classes for msql, mssql, and arrays	  |
// |		to have unified function names, but keeping code separate	  |
// +----------------------------------------------------------------------+