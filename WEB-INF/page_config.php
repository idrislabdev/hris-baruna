<?php
// page registering
	$regURL[0]		= 'home';								$regPage[0] = 'home.php';		// => also as default page
	
	$regURL[]		= 'info';								$regPage[] = 'info.php';
	$regURL[]		= 'info_detil';								$regPage[] = 'info_detil.php';
	$regURL[]		= 'rapat';								$regPage[] = 'rapat.php';
	$regURL[]		= 'agenda';								$regPage[] = 'agenda.php';
	$regURL[]		= 'agenda_detil';								$regPage[] = 'agenda_detil.php';
	$regURL[]		= 'kalender';							$regPage[] = 'kalender.php';
	$regURL[]		= 'forum';								$regPage[] = 'forum.php';
	$regURL[]		= 'forum_sub';							$regPage[] = 'forum_sub.php';
	$regURL[]		= 'forum_sub_tambah';							$regPage[] = 'forum_sub_tambah.php';
	$regURL[]		= 'forum_topik';						$regPage[] = 'forum_topik.php';
	$regURL[]		= 'forum_detil';						$regPage[] = 'forum_detil.php';
	$regURL[]		= 'detil';								$regPage[] = 'detil.php';
	$regURL[]		= 'seputar_departemen';					$regPage[] = 'seputar_departemen.php';
	$regURL[]		= 'faq';								$regPage[] = 'faq.php';
	$regURL[]		= 'hukum';								$regPage[] = 'hukum.php';
	$regURL[]		= 'hukum_detil';						$regPage[] = 'hukum_detil.php';

// page translation, $pg = dari URL 
class pageToLoad
{
	var $regURL;
	var $regPage;
	var $pg;
	
	function pageToLoad($page)
	{
		$this->pg = $_GET['pg'];
	}
	
	function loadPage()
	{
		if(in_array($this->pg, $this->regURL))
		{
			foreach($this->regURL as $key => $value)
			{
				if($value == $this->pg)
				{
					$pageIndex = $key;
				}
			}
			
			$loadPage = $this->regPage[$pageIndex];
		}
		else
		{
			$loadPage = $this->regPage[0];
		}
		
		return $loadPage;
	}
}

// instantiate
?>