<?
$no = rand();
?>	
    <tr>
        <script>
            // $('input[id^="reqNama<?=$no?>"]').va({  
            //     required:true
            // });
            // $('input[id^="reqPeriode<?=$no?>"]').combotree({  
            // });
        </script>
        <td>
          <input type="hidden" name="reqDepartemenKelasId[]" value="">
          <input type="text" id="reqNamaKelas<?=$no?>" name="reqNamaKelas[]" class="easyui-validatebox"  style="width:50%" />
        </td>
        <td>
          <input type="text" id="reqKeteranganKelas<?=$no?>" name="reqKeteranganKelas[]" class="easyui-validatebox"  style="width:50%" />
        </td>
        <td align="center">
            <a class="hapus" style="text-align:center; cursor:pointer" onclick="$(this).parent().parent().remove();">DELETE</a>
        </td>
        
    </tr>