					</div>
				</td>
			</tr>
			<tr class="footerCell">
				<td>
					 <?php echo FOOTER_TEXT_PRE; ?> <b><?php
					
					$query = "SELECT `id` FROM `anyInventory_items`";
					$result = $db->query($query);
					
					echo intval($result->numRows());
					
					?></b>  <?php echo FOOTER_TEXT_POST; ?>
				</td>
			</tr>
		</table>
	</body>
</html>
