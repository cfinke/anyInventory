					</div>
				</td>
			</tr>
			<tr class="footerCell">
				<td>
					 <?php echo FOOTER_TEXT_PRE; ?> <b><?php
					
					$query = "SELECT `id` FROM `anyInventory_items`";
					$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					
					echo (mysql_num_rows($result) / 1);
					
					?></b>  <?php echo FOOTER_TEXT_POST; ?>
				</td>
			</tr>
		</table>
	</body>
</html>