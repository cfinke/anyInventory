				</td>
			</tr>
			<tr>
				<td>
					<div align="center" style="width: 100%; height: 100%; color: #cccccc; FONT-SIZE: 10px; padding:4px">
						you have inventoried <b><?php
						
						$query = "SELECT `id` FROM `anyInventory_items`";
						$result = query($query);
						
						echo (mysql_num_rows($result) / 1);
						
						?></b> items with <a href="http://anyinventory.sourceforge.net/">anyInventory, the web's most flexible and powerful inventory system</a>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>