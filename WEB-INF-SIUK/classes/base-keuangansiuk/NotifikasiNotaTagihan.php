<? 
/* *******************************************************************************************************
MODUL NAME 			: IMASYS
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * EntitySIUK-base class untuk mengimplementasikan tabel SAFM_BANK.
  * 
  ***/
  include_once("../WEB-INF-SIUK/classes/db/Entity.php");
  include_once("../PHPMailer/PHPMailerAutoload.php");

  class NotifikasiNotaTagihan extends EntitySIUK{ 

	var $query;
    /**
    * Class constructor.
    **/
    function NotifikasiNotaTagihan()
	{
      $this->EntitySIUK(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("KODE", $this->getNextId("KODE","AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN")); 		

		$str = "
				INSERT INTO AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN (
   					KODE, NO_NOTA, EMAIL_TUJUAN, CREATED_DATE, CREATED_BY) 
				VALUES ( 
					".$this->getField("KODE").", '".$this->getField("NO_NOTA")."', '".$this->getField("EMAIL_TUJUAN")."', SYSDATE, '".$this->getField("CREATED_BY")."'
				)";
				
		$this->id = $this->getField("BADAN_USAHA_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT 
				KODE, NO_NOTA, EMAIL_TUJUAN, CREATED_DATE, CREATED_BY
				FROM AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN
				WHERE 1 = 1
				"; 
		//, FOTO
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "
				SELECT 
				KODE, NO_NOTA, EMAIL_TUJUAN, CREATED_DATE, CREATED_BY
				FROM AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN
				WHERE 1 = 1
				"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY KODE ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
	
	function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN
		        WHERE 1 = 1 ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str);
		$this->query = $str; 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	function selectDataPelanggan($paramsArray=array(),$limit=-1,$from=-1, $statement="", $sOrder=" ")
	{
		$str = "
				SELECT MPLG_KODE, MPLG_NAMA, MPLG_BADAN_USAHA, MPLG_ALAMAT, MPLG_EMAIL_ADDRESS 
					FROM AKUNTANSI.SAFM_PELANGGAN
				WHERE 1 = 1
				"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(KODE) AS ROWCOUNT FROM AKUNTANSI.NOTIFIKASI_NOTA_TAGIHAN
		        WHERE 1=1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
	
	function sendMail($sendTo, $no_invoice, $valuta, $keterangan) {
		
		/*error_reporting(E_ALL);
		ini_set('display_errors', 1);
		ini_set('max_execution_time', 300);
		*/
		date_default_timezone_set('Etc/UTC');
		
		$str = "SELECT B.MPLG_KODE, B.MPLG_NAMA, NO_NOTA, NO_REF1, FAKTUR_PAJAK, TO_CHAR(TGL_POSTING, 'DD MON YYYY') TGL_POSTING, TO_CHAR(TGL_FAKTUR_PAJAK, 'DD MON YYYY') TGL_FAKTUR_PAJAK 
				FROM AKUNTANSI.KPTT_NOTA A JOIN SAFM_PELANGGAN B ON B.MPLG_KODE = A.KD_KUSTO 
				WHERE NO_NOTA = '" . $no_invoice . "'";
		
		$this->select($str); 
		$this->firstRow();
		
		
		//------ PATH REPORT -------
		$xml_file = "../WEB-INF-SIUK/web.xml"; 
		$data_xml = simplexml_load_file($xml_file);
		$data_xml_user=3;
		$data_xml_pass=4;
		$data_xml_path=5;
		$data_xml_connection=6;
		$path = $data_xml->path->path->configValue->$data_xml_path;
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = "mail.pelindomarine.com";
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 25;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail->Username = "pms@pelindomarine.com";
		//Password to use for SMTP authentication
		$mail->Password = "pms123";
		//Set who the message is to be sent from
		$mail->setFrom('pms@pelindomarine.com', 'pms');
		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		$addresses = explode(';', $sendTo);
		foreach ($addresses as $address) {
			$mail->AddAddress($address, $address);
		}
		//$mail->addAddress($sendTo, $sendTo);
		//Set the subject line
		$mail->Subject = "Invoice No : ". $this->getField("NO_REF1") ." PT Pelindo Marine Service";
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), $path);
		$mail->IsHTML(true);
	     $mail->Body = $this->displayMessage($valuta, $this->getField("MPLG_NAMA"), $this->getField("NO_REF1"), 
		 $this->getField("FAKTUR_PAJAK"), $this->getField("TGL_POSTING"), $this->getField("TGL_FAKTUR_PAJAK"), $keterangan);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file $_SERVER[HTTP_HOST]
		//$mail->addAttachment('penjualan_non_tunai_cetak_nota_rpt.php?reqId=0923/INV/IX-2014&reqKdValuta=IND');
		$url = "http://$_SERVER[HTTP_HOST]/keuangan/penjualan_non_tunai_cetak_nota_rpt.php?reqId=". $this->getField("NO_REF1") ."&reqKdValuta=$valuta&reqPejabat=EKO%20MUNADI&reqParam1=SPV%20ADM%20KEU&reqParam2=ASMAN%20TRESURI";
		//$binary_content = file_get_contents($url);
		$binary_content = $mail->curl($url);
		$mail->AddStringAttachment($binary_content, "invoice.pdf", $encoding = 'base64', $type = 'application/pdf');
		
		//send the message, check for errors
		if (!$mail->send()) {
			return "Mailer Error: " . $mail->ErrorInfo . $url;
		} else {
			return "Message sent!" . $url;
		}	
	}
	
	function displayMessage($valuta, $pelanggan, $no_invoice, $no_faktur, $tgl_invoice, $tgl_faktur, $keterangan) {
	
	if ($valuta=="IND") {
		$message = "<table style='undefined;table-layout: fixed; width: 800px'>
					<colgroup>
					<col style='width: 223px'>
					<col style='width: 21px'>
					<col style='width: 556px'>
					</colgroup>
					  <tr>
						<th colspan='3'>Pelanggan Yth,<br>Terimakasih telah menggunakan jasa layanan PT Pelindo Marine Service.<br>Bersama ini kami sampaikan copy tagihan dengan informasi singkat sebagai berikut :</th>
					  </tr>
					  <tr>
						<td>Pengguna Jasa</td>
						<td>:</td>
						<td>$pelanggan</td>
					  </tr>
					  <tr>
						<td>Nomor Invoice &amp; Faktur Pajak</td>
						<td>:</td>
						<td>$no_invoice / $no_faktur</td>
					  </tr>
					  <tr>
						<td>Tanggal Invoice &amp; Faktur Pajak</td>
						<td>:</td>
						<td>$tgl_invoice / $tgl_faktur</td>
					  </tr>
					  <tr>
						<td>Keterangan</td>
						<td>:</td>
						<td>$keterangan</td>
					  </tr>
					  <tr>
						<td colspan='3'>Original invoice kami akan kirimkan pada kesempatan pertama.<br>Jika anda mempunyai pertanyaan atas invoice ini, silakan menghubungi :<br>treasury@pelindomarine.com<br>Telp. +6231 3282216; 2271; 2278; 2289; 2321<br>Terima kasih<br>Hormat kami,<br>Tim Treasury<br>PT Pelindo Marine Service</td>
					  </tr>
					</table>";
		} else {
			$message = "<table style='undefined;table-layout: fixed; width: 800px'>
						<colgroup>
						<col style='width: 223px'>
						<col style='width: 21px'>
						<col style='width: 556px'>
						</colgroup>
						  <tr>
							<th colspan='3'>Dear Valued Customer,<br>We would like to thank you for using our services. Enclosed please find a copy of invoice  :  </th>
						  </tr>
						  <tr>
							<td>Customer Name</td>
							<td>:</td>
							<td>$pelanggan</td>
						  </tr>
						  <tr>
							<td>Invoice &amp; Tax Invoice</td>
							<td>:</td>
							<td>$no_invoice / $no_faktur</td>
						  </tr>
						  <tr>
							<td>Date of Invoice &amp; Tax</td>
							<td>:</td>
							<td>$tgl_invoice / $tgl_faktur</td>
						  </tr>
						  <tr>
							<td>Description</td>
							<td>:</td>
							<td>$keterangan</td>
						  </tr>
						  <tr>
							<td colspan='3'>Original invoices will be send soonest. <br>If you have question regarding this invoice, please contact : treasury@pelindomarine.com<br>Telp. +6231 3282216; 2271; 2278; 2289; 2321<br>Best Regard,<br><br><br>Treasury Team<br>PT Pelindo Marine Service</td>
						  </tr>
						</table>";
		}
		
		return $message;
			
	}
	
  } 
?>