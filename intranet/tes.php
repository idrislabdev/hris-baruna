<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>ComboGrid - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
	<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script>
		$(function(){
			$('#cc').combogrid({
				panelWidth:450,
				value:'196',
				idField:'id',
				textField:'text',
				url:'../json-intranet/user_login_lookup_json.php',
				columns:[[
					{field:'id',title:'Code',width:60},
					{field:'text',title:'Name',width:100}
				]]
				/*value:'006',
				idField:'code',
				textField:'name',
				url:'../json-intranet/datagrid_data.json',
				columns:[[
					{field:'code',title:'Code',width:60},
					{field:'name',title:'Name',width:100},
					{field:'addr',title:'Address',width:120},
					{field:'col4',title:'Col41',width:100}
				]]*/
			});
		});
		function reload(){
			$('#cc').combogrid('grid').datagrid('reload');
		}
		function setValue(){
			$('#cc').combogrid('setValue', '002');
		}
		function getValue(){
			var val = $('#cc').combogrid('getValue');
			alert(val);
		}
		function disable(){
			$('#cc').combogrid('disable');
		}
		function enable(){
			$('#cc').combogrid('enable');
		}
	</script>
</head>
<body>
	<h2>ComboGrid</h2>
	<div class="demo-info">
		<div class="demo-tip icon-tip"></div>
		<div>Click the right arrow button to show the datagrid.</div>
	</div>
	
	<div style="margin:10px 0;">
		<a href="#" class="easyui-linkbutton" onclick="reload()">Reload</a>
		<a href="#" class="easyui-linkbutton" onclick="setValue()">SetValue</a>
		<a href="#" class="easyui-linkbutton" onclick="getValue()">GetValue</a>
		<a href="#" class="easyui-linkbutton" onclick="disable()">Disable</a>
		<a href="#" class="easyui-linkbutton" onclick="enable()">Enable</a>
	</div>
    <!--<select class="easyui-combotree" name="language" data-options="url:'tree_data.json',cascadeCheck:false" multiple style="width:200px;"></select>-->
	<select id="cc" name="dept" multiple style="width:250px;"></select>
</body>
</html>