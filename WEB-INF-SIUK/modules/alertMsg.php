<div id="moduleAlert" style="z-index: 2; position:absolute; top:10px; left:10px;">
<table class="table_form" cellspacing="1" border="0">
	<tr>
		<th colspan="3">
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<span  style="background-image: url(images/icn_info.gif);
						   background-repeat: no-repeat;
						   background-position: 0px 0px;
						   padding-left: 20px;">
					Pesan
					</span>
				</td>
				<td align="right">
					<a href="javascript:displayElement('moduleAlert')" title="Close">
						<img src="images/panel_collapse_small.png" border="0" />
					</a>
				</td>
			</tr>
		</table>
		</th>
	</tr>
	<tr>
		<td colspan="3">
		<?=$alertMsg?>
		</td>
	</tr>
	<?
	if($alertMsgArray)
	{
	?>
	<tr>
		<td colspan="3" height="1" bgcolor="#ADC1DC"></td>
	</tr>
	<?
		while(list($key,$val) = each($alertMsgArray))
		{
    ?>
	<tr>
		<td width="200"><?=$key?></td>
		<td width="10" align="center">:</td>
		<td><?=$val?></td>
	</tr>
	<?
		}
    }
	?>
</table>
</div>
