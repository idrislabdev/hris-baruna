<?
function emailTo($pengirim, $isi, $email)
{
	/*$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: $email\r\n";
	
	$subject = "a message via Web Site DPS, ".date("d-M-Y", time());
	
	mail($pengirim, $subject, $isi, $headers);*/
	
	if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
	  $eol="\r\n";
	} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
	  $eol="\r";
	} else {
	  $eol="\n";
	} 
	
	
	# To Email Address
	$emailaddress=$email;
	# Message Subject
	$emailsubject="Heres An Email Order".date("Y/m/d H:i:s");				
	
	# Common Headers
	$headers .= 'From: '.$pengirim.$eol;
	$headers .= "Message-ID:<".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
	$headers .= "X-Mailer: PHP v".phpversion().$eol;           // These two to help avoid spam-filters
	# Boundry for marking the split & Multitype Headers
	$mime_boundary=md5(time());
	$headers .= 'MIME-Version: 1.0'.$eol;
	$headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;
	$msg = "";
									
	# HTML Version
	$msg .= "--".$mime_boundary.$eol;
	$msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
	$msg .= "Content-Transfer-Encoding: 8bit".$eol;
	$msg .= $isi.$eol.$eol;
	
	# Finished
	$msg .= "--".$mime_boundary."--".$eol.$eol;   // finish with two eol's for better security. see Injection.
	
	# SEND THE EMAIL
	ini_set(sendmail_from,$pengirim);  // the INI lines are to force the From Address to be used !
	  mail($emailaddress, $emailsubject, $msg, $headers);
	ini_restore(sendmail_from); 
}
?>