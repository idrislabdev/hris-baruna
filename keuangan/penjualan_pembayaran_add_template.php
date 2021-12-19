
<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
$i = 1;
$checkbox_index = 0;
$reqId = httpFilterGet("reqId");
$reqNota = httpFilterGet("reqNota");
$reqPeriodeSPP = httpFilterGet("reqPeriodeSPP");

if($reqNota == "")
{}
else
	$notStatement = " AND NOT X.NO_NOTA = '".$reqNota."' ";

$statement = " AND NOT EXISTS(SELECT 1 FROM KPTT_NOTA_D X WHERE X.KD_SUB_BANTU = A.MPLG_KODE AND X.PERIODE_PEMBAYARAN = '".$reqPeriodeSPP."' ".$notStatement." AND X.STATUS_PROSES = '1' ) ";

$kbbt_jur_bb_d = new KbbtJurBbD();

$kbbt_jur_bb_d->selectByParamsSiswaSpp(array("A.DEPARTEMEN_KELAS_ID"=>$reqId),-1, -1, $statement);
while($kbbt_jur_bb_d->nextRow())
{
?>
    <tr id="node-<?=$i?>">
      <td>
        <input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
      </td>
    <td>
    <input id="reqKodeKartu<?=$checkbox_index?>" value="<?=$kbbt_jur_bb_d->getField("MPLG_KODE")?>" name="reqKodeKartu[]" style="width:90%"  readonly />
    <input type="hidden" id="reqKlasTrans<?=$checkbox_index?>" value="SPP" name="reqKlasTrans[]"  />
    </td>
    <td>
    <input id="reqNamaKartu<?=$checkbox_index?>" value="<?=$kbbt_jur_bb_d->getField("MPLG_NAMA")?>" name="reqNamaKartu[]" style="width:90%"  readonly />
    <input type="hidden" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>"  value="N"  />
    <?php /*?><input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" class="easyui-validatebox" /><?php */?>
    </td>
    <td>
    <input type="text" name="reqNilaiJasa[]" value="<?=$kbbt_jur_bb_d->getField("JUMLAH_SPP")?>" id="reqNilaiJasa<?=$checkbox_index?>" readonly style="text-align:right" OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" tabindex="15" onMouseDown="tabindex=15"/>
    </td>
    <td>
    <input type="text" name="reqKeteranganTambah[]" id="reqKeteranganTambah<?=$checkbox_index?>" style="width:98%;" class="easyui-validatebox"/>
    </td>
    <td align="center">
    <label>
    <input type="hidden" name="reqJumlah[]" value="<?=$kbbt_jur_bb_d->getField("JUMLAH_SPP")?>" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" readonly  OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" />
    <input type="hidden" name="reqNilaiPajak[]" value="0"  id="reqNilaiPajak<?=$checkbox_index?>" />
    <input type="hidden" name="reqKdBukuBesar[]" value="<?=$kbbt_jur_bb_d->getField("KODE_BB_SPP")?>" id="reqKdBukuBesar<?=$checkbox_index?>" />
    <input type="hidden" name="reqKdBukuPusat[]" value="<?=$kbbt_jur_bb_d->getField("KODE_BP_SPP")?>" id="reqKdBukuPusat<?=$checkbox_index?>" />
    <input type="hidden" name="reqDK[]" value="K" id="reqDK<?=$checkbox_index?>" />
    <a style="cursor:pointer" onclick="$(this).parent().parent().parent().remove(); hitungUlang();"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
    </label>
    </td>
    </tr>
  <?
	$i++;
	$checkbox_index++;
  }
  ?>
