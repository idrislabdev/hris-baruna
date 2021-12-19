<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.ui.core.min.js"></script>
<script src="jquery.ui.widget.min.js"></script>
<script src="jquery.ui.position.min.js"></script>
<script src="jquery.ui.autocomplete.min.js"></script>

<link rel="stylesheet" href="jquery-ui-1.8.16.custom.css"/>

<script>
var data = [
		"Adriana",
		"Alessandra",
		"Behati",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Candice",
		"Doutzen",
		"Erin",
		"Gisele",
		"Laetitia",
		"Lily",
		"Lindsay",
		"Marisa",
		"Miranda",
		];


$(function() {

	$( "#search" ).autocomplete(
	{
		 source:'data.php'
	});
		
});
</script>

	<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		font-size:12px;
		overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
	</style>
</head>

Search: <input type="text" id="search" />
<body>
</body>
</html>