<?

define('BASE_URL', '/imasys-pmsbaru2/main/'); // this you must use as an absolute path to the application root, ex: /folder1/folder2/

if (isset($_SERVER['PATH_INFO'])) {
	$url = substr($_SERVER['PATH_INFO'], 1);
	$urlParts = explode('/', $url);
	if ($urlParts[count($urlParts) - 1] == '') array_pop($urlParts);

	$urlPartsCount = count($urlParts);
	if ($urlPartsCount % 2 != 0) {
		$urlPartsCount++;
	}
	for ($i = 0; $i < $urlPartsCount; $i += 2) {
		$_GET[$urlParts[$i]] = $urlParts[$i + 1];
	}
} 

$urlPatterns = array(
	'~'.preg_quote(BASE_URL).'([^\.]+).php(\?([0-9a-zA-Z]+[^#"\']*))?~i',
); 


ob_start();

?>