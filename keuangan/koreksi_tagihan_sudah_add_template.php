<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
$checkbox_index = rand();

$pNO_NOTA = httpFilterPost("pNO_NOTA"); 
$pKD_SUB_BANTU = httpFilterPost("pKD_SUB_BANTU"); 
$pMPLG_NAMA = httpFilterPost("pMPLG_NAMA");
$pJML_VAL_TRANS = httpFilterPost("pJML_VAL_TRANS");
$pKD_BUKU_BESAR = httpFilterPost("pKD_BUKU_BESAR");
$pKLAS_TRANS = httpFilterPost("pKLAS_TRANS");

?>
<tr>
<td>
<input type="text" name="reqNoPpkb[]" id="reqNoPpkb<?=$checkbox_index?>" readonly class="easyui-validatebox" value="<?=$pNO_NOTA?>" style="width:98%" readonly />
</td>
<td>
<input type="text" name="reqNIS[]" id="reqNoPpkb<?=$checkbox_index?>" readonly class="easyui-validatebox" value="<?=$pKD_SUB_BANTU?>" style="width:98%" readonly />
</td>
<td>
<input type="text" name="reqPelanggan[]" id="reqPelanggan<?=$checkbox_index?>" readonly class="easyui-validatebox" value="<?=$pMPLG_NAMA?>" readonly  style="width:98%" />
</td>
<td>
<input type="text" name="reqTagihan[]"  style="text-align:right;"  readonly  value="<?=($pJML_VAL_TRANS)?>">
</td>
<td align="center">
<input type="hidden" name="reqBukuBesar[]" value="<?=$pKD_BUKU_BESAR?>">
<input type="hidden" name="reqKlasTrans[]" value="<?=$pKLAS_TRANS?>">
<label>
<a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
</label>
</td>
</tr>