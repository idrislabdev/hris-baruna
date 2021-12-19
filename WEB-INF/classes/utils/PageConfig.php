<?

include_once("../WEB-INF/classes/base/SubMenu.php");
include_once("../WEB-INF/classes/base/Menu.php");
include_once("../WEB-INF/classes/base/Content.php");

class PageConfig
{
	var $defaultPage;
	var $registerPage = array();
	var $inputPage;
	var $pageTitle;
	var $pageRoot;
	var $pageCategory;
	
	/**
	* Class constructor
	* Fetching isi data pada table submenu 
	* ke variabel $registerPage = array('user URL' => 'URL file relatif terhadap page template')
	**/
	function PageConfig()
	{
		$sub_menu = new SubMenu();
		
		$sub_menu->selectByParams();
		while($sub_menu->nextRow())
		{
			$user_URL = $sub_menu->getField('USER_URL');
			$file = $sub_menu->getField('FILE');
			$this->registerPage[$user_URL] = $file;
		}
	}
	
	/**
	* Method untuk menerjemahkan URL file dari variabel $_GET['pg'] dari URL 
	* menjadi URL file yang sebenarnya untuk di-include kan ke page template
	**/
	function getPageURL()
	{
		if($this->registerPage[$this->inputPage] == true)
		{
			$outputPage = $this->registerPage[$this->inputPage];
		}
		else
		{
			$outputPage = $this->defaultPage;
		}
		
		return $outputPage;
	}
	
	/**
	* Memanggil path pada tiap halaman mengandalkan isi field PATH pada table submenu
	* !!! BETA Version !!! (aku ae gaeruh iki bener opo salah :D )
	**/
	function getPagePath()
	{
		$sub_menu = new SubMenu();
		$menu = new Menu();
		
		$sub_menu->selectByUrl($this->inputPage);
		$sub_menu->firstRow();
		
		$path = $sub_menu->getField('PATH').",";
		$path = trim($path);
		
		$arrPath = explode(",", $path);
		$this->pageRoot = $arrPath[0];
		
		foreach($arrPath as $value)
		{
			$sub_menu->selectByUrl($value);
			$sub_menu->firstRow();
			
			/* if have a MID (Menu or page category) */
			if($sub_menu->getField('MID') != '' && $value != '' && $sub_menu->getField('MID') != '0')
			{
				$param['MID'] = $sub_menu->getField('MID');
				$menu->selectExact($param);
				$menu->firstRow();
				
				$pagePath .= $menu->getField('NAMA');
				$pageTitle .= $menu->getField('NAMA');
				$this->pageCategory = $menu->getField('MID');
			}
			
			if($value != '')
			{
				$pagePath .= ' &raquo; <a href="?pg='.$sub_menu->getField('USER_URL').'">'.$sub_menu->getField('USER_CAPTION').'</a>';
				$pageTitle .= ' :: '.$sub_menu->getField('USER_CAPTION');
			}	
		}
		
		$this->pageTitle = $pageTitle;
		
		return $pagePath;
		
		unset($this->pageTitle);
	}
	
	function getPageTitle()
	{
		$this->getPagePath();
		return $this->pageTitle;
	}
	
	/**
	 * mengambil halaman root dari subpath 
	 * contoh : 	Main Menu 	>	Education	>	School		>	Edit School Data
	 *  			#category		#page root		#sub root 1		#sub root 2
	**/
	function getPageRoot()
	{	
		$this->getPagePath();
		return $this->pageRoot;
	}
	
	function getPageCategory()
	{
		$this->getPagePath();
		return $this->pageCategory;
	}
	
	function getPageContent($inputCTID = false)
	{
		$content = new Content();
		
		if(!$inputCTID)
			$inputCTID = $this->inputPage;
			
		$content->selectExact(array('CTID'=>$inputCTID));
		
		if($content->firstRow())
		{
			$writeContent = '<div class="contentStyle">';
			
			if($content->getField('PIC_URL') != '')
				$writeContent .= '<img src="'.$content->getField('PIC_URL').'" /><br />';
				
			$writeContent .= $content->getField('DESCRIPTION');
			$writeContent .= '</div>';
			
			return $writeContent;
			
			unset($writeContent);
		}
	}
	
	function checkUserPrivilege($userLevel)
	{
		$sub_menu = new SubMenu();
		$sub_menu->selectByUrl($this->inputPage);
		$sub_menu->firstRow();
		
		if($sub_menu->getField('LEVEL_ACCESS') >= $userLevel)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

$page_config = new PageConfig();

// register admin pages
$page_config->defaultPage = 'home.php?pg=home';
$page_config->registerPage['?pg=formal_edukasi_add'] = "formal_edukasi_add.php";
$page_config->registerPage['?pg=sertifikasi_add'] = "sertifikasi_add.php";
$page_config->registerPage['?pg=training_add'] = "training_add.php";
$page_config->registerPage['?pg=software_add'] = "software_add.php";


?>