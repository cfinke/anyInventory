					</div>
				</td>
			</tr>
			<tr class="footerCell">
				<td>
					you have inventoried <b><?php
					
					$query = "SELECT `id` FROM `anyInventory_items`";
					$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					
					echo (mysql_num_rows($result) / 1);
					
					?></b> items with <a href="http://anyinventory.sourceforge.net/">anyInventory, the web's most flexible and powerful inventory system</a>
				</td>
			</tr>
		</table>
	</body>
</html>