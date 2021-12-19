<?
/* *******************************************************************************************************
MODUL NAME 			: SIMKeu
FILE NAME 			: PageNumber.php
AUTHOR				: Wawan
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle pagging on page
***************************************************************************************************** */

//include_once("../../kejagung/WEB-INF/classes/WEB-INF/functions/math.func.php");

class PageNumber
{
	var $rowCount; #jumlah seluruh record
    var $numPage; #jumlah halaman

    var $page; #current page
    var $limit; #batas record per page
    var $from; #awal nomor record
	
	var $xmaks;
	var $fileName;
	
	var $requestRowLimit;
	var $drawOption;
	
	var $anyflag;
	
	function initialize($rowCount,$limit,$reqPage,$fileName)
	{   
		$this->rowCount = $rowCount;
		
		if(strpos($fileName, "?") === false)
			$this->fileName = $fileName."?";
		else
			$this->fileName = $fileName;
		
		if(isset($this->requestRowLimit))
			$this->limit = $this->requestRowLimit;
		else
			$this->limit = $limit;
		
		$this->page = $reqPage;

		if(empty($this->page))
		{
			$this->page = 1;
		}
		
		$this->xmaks = $this->getStartRowIdx();
		$this->numPage = ceil($this->rowCount / $this->limit); 
		$this->from = ($this->page - 1) * ($this->limit);
	}
	
	/* fungsi untuk mengeluarkan option tampilkan berapa data
	 * $sesVarName = variabel sesion untuk menyimpan banyak data yg ditampilkan
	 * $rowCount = jumlah seluruh record
	 * $reqRowLimit = passing variable
	 * $currRowLimit = nilai default untuk option, sebaiknya samakan dengan $limit yang dipakai pada method initialize()
	 * $option = pilihan untuk tampilkan data
	 * $choice = multiplier
	 * $showAll = keluarkan option untuk tampilkan semua data. default = false
	 DEPENDNCIES :
	 * 1. dijalankan sebelum fungsi initialize()
	 * 2. session_start()
	 RESULT :
	 * $this->drawOption = untuk mengeluarkan form pilihan
	 */
	function drawRequestRowLimit($sesVarName, $rowCount, $reqRowLimit, $currRowLimit=10, $option=10, $choice=5, $withForm=false, $showAll=false)
	{
		if(isset($reqRowLimit))
		{
			$_SESSION[$sesVarName] = $reqRowLimit;
		}
		
		if(isset($_SESSION[$sesVarName]))
		{
			$this->requestRowLimit = $_SESSION[$sesVarName];
		}
		else
		{
			$this->requestRowLimit = $currRowLimit;
		}	
	
		$this->drawOption = "
			<table cellpadding='2' cellspacing='1' class='paging_nav' cellspacing='0' border='0'>
		";
		
		if($withForm == true)
		{
			$this->drawOption .= "
				<form action='' method='post'>
			";
		}
		
		$this->drawOption .= "		
				<tr>
					<td>Tampilkan</td>
					<td>
						<select name='reqRowLimit' onChange='submit()'>
		";
		
		for($i = $option; $i <= $option * $choice; $i += $option)
		{
			if($i == $this->requestRowLimit)
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			
			$this->drawOption .= "
							<option value='$i' $selected>$i</option>
			";
		}
		
		if($showAll == true)
		{
			if($reqRowLimit == $rowCount)
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			
			$this->drawOption .= "
							<option value='$rowCount' $selected>Semua</option>
			";
		}
		
		$this->drawOption .= "
						</select>
					</td>
					<td>Data</a>
				</tr>";
		
		if($withForm == true)
		{
			$this->drawOption .= "
				</form>
			";
		}
		
		$this->drawOption .= "
			</table>
		
		";
	}
	
	function drawPageInfo()
	{
		echo "
			<table style='width:100%; margin:1px;' cellpadding='2' cellspacing='1' class='paging_nav' cellspacing='0' border='0'>
				<tr>	
		";
		
		if ($this->rowCount > 0) 
		{
			if ($this->page == $this->numPage) 
			{
				echo "
					<td width='100%'>
					Data&nbsp;:&nbsp;<span class='highlight'>" . ($this->from + 1) . "</span>&nbsp;sampai&nbsp;<span class='highlight'>" . $this->rowCount ."</span>&nbsp;dari&nbsp;<span class='highlight'>" . $this->rowCount ."</span>&nbsp;pada&nbsp;halaman&nbsp;<span class='highlight'>" . $this->numPage ."</span>
					</td>
				";
			}
			else 
			{
				echo "
					<td width='100%'>
					Data&nbsp;:&nbsp;<span class='highlight'>" . ($this->from + 1) . "</span>&nbsp;sampai&nbsp;<span class='highlight'>" . ($this->from + $this->limit) ."</span>&nbsp;dari&nbsp;<span class='highlight'>" . $this->rowCount ."</span>&nbsp;pada&nbsp;halaman&nbsp;<span class='highlight'>" . $this->page ."</span>
					</td>
				";
			}
		} 
		else
			echo "
					<td>
					Data&nbsp;tidak&nbsp;ditemukan
					</td>
			";
		
		echo "
				</tr>
			</table>
		";
	}
	
	function getStartRowIdx()
	{
    	return ($this->limit * ($this->page-1)) + 1;
    }
	
	function drawPageFlex()
	{
		$shownav = 13; //berapa banyak navigasi halaman yg ditampilkan (kalo bisa jangan lebih kecil ato sama dgn jumpnav)
		$jumpnav = floor($shownav / 2); //banyak loncatan halaman
		
		$anyflag = $flag;
		
		//----- mulai paging ------//
				
		echo "";
				 
		if($this->rowCount <= 0) 
			$this->page = 0;
				
		//echo "
		//		Halaman&nbsp;<span class='highlight'>".$this->page."</span>&nbsp;dari&nbsp;<span class='highlight'>".$this->numPage."</span>
		//";
				
		$iPage = 0;
		if (!empty($this->page))
			$iPage = $this->page;
				
		/*
		Main Engine
		Rule the behaviour of paging
		*/
		if($this->numPage <= $shownav)
			$showHal = $this->numPage;
		else if($this->numPage > $shownav)
			$showHal = $shownav;
				
		if(($iPage + $jumpnav) > $showHal)
			$showHal = $iPage+(2 * $jumpnav);
				
		if(($iPage - $jumpnav) < ($showHal - $shownav))
			$showHal = $showHal-$jumpnav;
				
		$awal = $showHal - $shownav + 1;
				
		if($showHal <= $shownav)
			$showHal = $shownav;
		else if($showHal >= $this->numPage)
			$showHal = $this->numPage;
				
		if($showHal <= $shownav && $this->numPage < $shownav)
			$showHal = $this->numPage;
				
		if($awal<$shownav || $awal>$shownav)
			$awal = $showHal-$shownav+1;
				
		if($halaman == $showHal)
			$awal = $showHal-$shownav+1;
		
		if($awal<=0)
			$awal = 1;
		/*
		End of Main Engine
		*/

		
		//--- draw the navigation --//
		if ($this->page > 1) 
		{ 
			echo "
				<a href='".$this->fileName."&reqPage=1&reqFlag=".$this->anyflag."'>First</a>
				&nbsp;<a href='".$this->fileName."&reqPage=".($this->page-1)."&reqFlag=".$this->anyflag."'>&lt;</a>&nbsp;
			";
		} 
		else 
		{ 
			// Jika Halaman Awal
			//echo "
			//	First
			//	&nbsp;&lt;&nbsp;
			//"; 
		}   
		//------//
				
		/*
		echo "
				<td align='center'>
		
					<table class='paging_nav' cellspacing='1' cellpadding='0'>
						<tr>
		";
		*/
		
		//----- draw the navigational number ------//
		if($awal !== 1)
			echo "
							<a href='".$this->fileName."&reqPage=1&reqFlag=".$this->anyflag."'>1...</a>
			";
				
		for ($i = $awal; $i <= $showHal; $i++)
		{
			echo "";
			if($this->page == $i)
				echo"<span class=\"current\"><b>$i</b></span>&nbsp;";
			else
				echo"<a href='".$this->fileName."&reqPage=$i&reqFlag=".$this->anyflag."'>$i</a>&nbsp;";
			echo "";
		}
				
		if ($i <= $this->numPage)
			echo "
			<a href='".$this->fileName."&reqPage=".$this->numPage."&reqFlag=".$this->anyflag."'>...".$this->numPage."</a>
			";
		//------------------------------------------//
		
		/*	
		echo "			
						</tr>
					</table>
				</td>
		";
		*/
		
		//--- draw the navigation --//		
		if ($this->page < $this->numPage) 
		{ 
			echo "&nbsp;<a href='".$this->fileName."&reqPage=".($this->page + 1)."&reqFlag=".$this->anyflag."'>&gt;</a>&nbsp;<a href='".$this->fileName."&reqPage=".$this->numPage."&reqFlag=".$this->anyflag."'>Last</a>
			";
		} 
		else 
		{ 
			// Jika Halaman Terakhir
			//echo "
			//	&nbsp;&gt;&nbsp;
			//	Last
			//";
		} 
				
		echo "			
		";
		//------//
					
	}
	
	function drawPage($lang="id") {
		if ($lang == "en") {
			echo "(Page ".$this->page." of ".$this->numPage.")\n";
		} 
		else if ($lang == "id") {
			echo "(Halaman ".$this->page." dari ".$this->numPage.")\n";
		}
	}

}

//--- instantiate the class ---//	
$pageNumber = new PageNumber();
  
$reqPage = $_GET["reqPage"];
$reqRowLimit = $_REQUEST['reqRowLimit'];
//	if(!$reqPage)
//		$reqPage = $HTTP_GET_VARS["reqPage"];
?>