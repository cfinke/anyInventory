					</div>
				</td>
			</tr>
			<tr class="footerCell">
				<td>
					 <?php echo FOOTER_TEXT_PRE; ?> <b><?php
					 
					$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . "";
					$result = $db->query($query);
					if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
					
					echo ($result->numRows() / 1);
					
					?></b>  <?php echo FOOTER_TEXT_POST; ?>
				</td>
			</tr>
		</table>
	</body>
</html>
