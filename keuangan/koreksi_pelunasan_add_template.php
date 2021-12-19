
<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
$i = 1;

$reqId = httpFilterGet("reqId");

$kptt_nota_d = new KpttNotaD();
$kptt_nota_d->selectDaftarTagihanJKMPembatalanPelunasan(array("A.NO_NOTA" => $reqId));
while($kptt_nota_d->nextRow())
{
	$checkbox_index = rand();
	$reqNilai = $kptt_nota_d->getField("TAGIHAN");
?>
  <tr id="node-<?=$i?>">
	  <td>
		<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("PREV_NO_NOTA")?>"  style="width:98%" readonly />
	  </td>
	  <td>
	  <input type="text" name="reqNoPpkb[]" id="reqNoPpkb<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("KD_SUB_BANTU")?>" style="width:98%" readonly />
	  </td>
	  <td>
		<input type="text" name="reqPelanggan[]" id="reqPelanggan<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("NM_SUB_BANTU")?>" readonly style="width:98%" />
	  </td>
	  <td>
		<input type="text" name="reqTanggalNota[]" id="reqTanggalNota<?=$checkbox_index?>" class="easyui-validatebox" value="<?=dateToPage($kptt_nota_d->getField("TGL_TRANS"))?>" readonly />
	  </td>
	  <td>
		<input type="text" name="reqSisaPiutang[]"  style="text-align:right;"  id="reqSisaPiutang<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqSisaPiutang<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaPiutang<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("TAGIHAN"))?>">
	  </td>
	  <td>
		<input type="text" name="reqJumlahBayar[]"  style="text-align:right;"  id="reqJumlahBayar<?=$checkbox_index?>"  OnFocus="FormatAngka('reqJumlahBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlahBayar<?=$checkbox_index?>'); hitungJumlahTotal(); hitungSisaBayar('<?=$checkbox_index?>');" OnBlur="FormatUang('reqJumlahBayar<?=$checkbox_index?>')" value="<?=numberToIna($reqNilai)?>">
	  </td>
	  <td>
      	<select name="reqKdPengganti[]">
      	<?
        $kptt_nota_d_siswa = new KpttNotaD();
		$kptt_nota_d_siswa->selectByParamsDaftarSiswa(array("A.KLAS_TRANS" => $kptt_nota_d->getField("KLAS_TRANS"),
															"A.KD_BUKU_BESAR" => $kptt_nota_d->getField("KD_BUKU_BESAR_JPJ"),
															"BLN_BUKU" => $kptt_nota_d->getField("BLN_BUKU"),
															"THN_BUKU" => $kptt_nota_d->getField("THN_BUKU")), -1, -1, " AND A.NO_REF_PELUNASAN IS NULL ");
		while($kptt_nota_d_siswa->nextRow())
		{
		?>
        	<option value="<?=$kptt_nota_d_siswa->getField("KD_SUB_BANTU")?>-<?=$kptt_nota_d_siswa->getField("NO_NOTA")?>"><?=$kptt_nota_d_siswa->getField("NM_SUB_BANTU_JPJ")?></option>
        <?
		}
		?>
        </select>
		<input type="hidden" name="reqSisaBayar[]"  style="text-align:right;"  id="reqSisaBayar<?=$checkbox_index?>"  readonly OnFocus="FormatAngka('reqSisaBayar<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqSisaBayar<?=$checkbox_index?>')" OnBlur="FormatUang('reqSisaBayar<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField("TAGIHAN")-$reqNilai)?>">
	  </td>
	  <td align="center">
	  <label>
	  <input type="hidden" name="reqBukuBesar[]" id="reqBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>">
	  <input type="hidden" name="reqPrevNoNota[]" id="reqPrevNoNota<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("NO_NOTA")?>">
	  <a style="cursor:pointer" onclick="$(this).parent().parent().parent().remove(); hitungJumlahTotal();"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
	  </label>
	  </td>
  </tr>
<?
}
?> 