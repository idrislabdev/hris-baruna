<script language='javascript'>
function pilih(s){
	if (s != null) {	
		var a = s.split("#");
		<?  $spil = explode("||",$pil); $xpil = explode("|",$spil[0]);
			$i = 0; foreach ($xpil as $idvid) { list($id,$vid) = explode(":",$idvid) ?>	
			window.opener.document.frm.<?= $id ?>.value=a[<?= $i?>];
		<? $i++; } ?>
	}
	window.close();
}

function pilihSubmit(s){
	if (s != null) {	
		var a = s.split("#");
		<?   $spil = explode("||",$pil); $xpil = explode("|",$spil[0]);
			$i = 0; foreach ($xpil as $idvid) { list($id,$vid) = explode(":",$idvid) ?>	
			window.opener.document.frm.<?= $id ?>.value=a[<?= $i?>];
		<? $i++; } ?>
		window.opener.document.frm.action.value = 'pilih2';
		window.opener.document.frm.submit();
	}
	window.close();
}
</script>

