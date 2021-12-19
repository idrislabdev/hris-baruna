<?
$checkbox_index = rand();
?>

<tr id="node-<?=$checkbox_index?>">
  <td> 
    <input type="text" name="reqNoUrut[]" readonly id="reqNoUrut<?=$checkbox_index?>" class="easyui-validatebox" value="" />
  </td>
<td>
  <input type="text" name="reqSiswa[]" readonly id="reqSiswa<?=$checkbox_index?>" class="easyui-validatebox" style="width:95%" onKeyDown="pencarianSiswa('<?=$checkbox_index?>', event)" />
</td>
<td>
<input readonly type="text" name="reqKdBukuBesar[]" id="reqKdBukuBesar<?=$checkbox_index?>" />
<input type="hidden" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>"
value="0" tabindex="14" onMouseDown="tabindex=14" />
</td>
<td>
<input type="text" name="reqNilaiJasa[]"  id="reqNilaiJasa<?=$checkbox_index?>" style="text-align:right" OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); hitungTotalTransaksi();" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" tabindex="15" onMouseDown="tabindex=15"/>
</td>
<td>
<input type="text" name="reqKeteranganTambah[]" id="reqKeteranganTambah<?=$checkbox_index?>" style="width:98%;" class="easyui-validatebox"/>
</td> 
<td align="center">
<label>
<input type="hidden" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" />
<input type="hidden" name="reqNilaiPajak[]"  id="reqNilaiPajak<?=$checkbox_index?>" value="0" />

<input type="hidden" name="reqDK[]" id="reqDK<?=$checkbox_index?>" value="K" />
<a onclick="$(this).parent().parent().parent().remove(); hitungTotalTransaksi();"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
</label>
</td>
</tr>