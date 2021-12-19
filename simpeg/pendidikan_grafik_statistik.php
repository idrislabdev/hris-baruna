<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");

/* LOGIN CHECK */
$reqView = httpFilterGet("reqView");
$reqId = httpFilterRequest("reqId");
$reqDepartemen = httpFilterRequest("reqDepartemen");

if($reqView == 'LihatNoLogin'){}
else
{
	if ($userLogin->checkUserLogin()) 
	{ 
		$userLogin->retrieveUserInfo();
	}
}

if($reqDepartemen == "")
	$reqDepartemen = "";

?>
<!DOCTYPE HTML>
<html>
	<head>
    <title id='Description'>jqxChart Stacked Line Series Example</title>
    <link rel="stylesheet" href="../WEB-INF/lib/jqwidgets-ver3.4.0/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/jqwidgets-ver3.4.0/scripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/jqwidgets-ver3.4.0/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/jqwidgets-ver3.4.0/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/jqwidgets-ver3.4.0/jqwidgets/jqxchart.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<link href="../WEB-INF/css/gaya.css" rel="stylesheet" type="text/css" /> 
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare the data
			// GOLONGAN	
			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'KETERANGAN' },
					{ name: 'RATA' },
					{ name: 'JUMLAH_PS' },
					{ name: 'JUMLAH_OPS' }
				],
				url: '../json-grafik/pendidikan_json.php?reqDepartemen=<?=$reqDepartemen?>'
			};
			var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });
		
			// prepare jqxChart settings
			var settings = {
				title: "Grafik Pegawai Berdasarkan Pendidikan",
				description: "Tahun <?=date("Y")?>",
				enableAnimations: true,
                showLegend: true,
                legendLayout: { left: 400, top: 100, width: 400, height: 500, flow: 'vertical' },
                padding: { left: -290, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                colorScheme: 'scheme02',
				seriesGroups:
                    [
                        {
                            type: 'pie',
                            showLabels: false,
                            series:
                                [
                                    { 
                                        dataField: 'RATA',
                                        displayText: 'KETERANGAN',
                                        labelRadius: 185,
                                        initialAngle: 15,
                                        radius: 170,
                                        centerOffset: 0,
                                        formatSettings: { sufix: '%', decimalPlaces: 2 }
                                    }
                                ]
                        }
                    ]
			};
		
			// setup the chart
			$('#chartGolongan').jqxChart(settings);
		
			// select the chart element and set background image.
			//$('#chartGolongan').jqxChart({backgroundImage: 'images/bg-chart.jpg'});
			
			// select the chart element and change the default border line color.
			$('#chartGolongan').jqxChart({borderLineColor: '#aeaeae'}); 
			
			// refresh the chart element
			$('#chartGolongan').jqxChart('refresh');
		
			$.getJSON('../json-grafik/pendidikan_json.php?reqDepartemen=<?=$reqDepartemen?>', function (data) 
			{
				$.each(data, function (i, SingleElement) {
					$("#tableGolongan tbody").append('<tr><td>'+SingleElement.KETERANGAN+'</td><td>'+SingleElement.TOTAL+'</td><td>'+SingleElement.JUMLAH_PS+'</td><td>'+SingleElement.JUMLAH_OPS+'</td></tr>');							
				});
			});		
			
			  $('#reqDepartemen').combotree({
					onSelect: function(param){
						document.location.href = 'pendidikan_grafik_statistik.php?reqDepartemen='+param.id;
					}
			  });			

        });
		
    </script>
    
	</head>
    <body>
    	<div id="konten">
            <div style="margin-bottom:10px">
            Departemen : <input id="reqDepartemen" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/departemen_combo_json.php',
                                valueField:'id',
                                textField:'text'" style="width:290px;" value="<?=$reqDepartemen?>">        
            </div>
            <div id="grafik-tabel">
                <table id="tableGolongan">
                <thead>  
                    <tr>
                        <td>Pendidikan</td>
                        <td>TOTAL</td>
                        <td>DARAT</td>
                        <td>LAUT</td>
                    </tr>
                </thead>
                <tbody> 
                </tbody>    
                </table>
            </div>
            <div id='chartGolongan' class="grafik-tampil" style="width:680px; height:450px; position: relative; left: 0px; top: 0px;"></div>    
        </div>
    </body>
</html>
