<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/default.func.php");

/* LOGIN CHECK */
$reqView = httpFilterGet("reqView");
$reqId = httpFilterRequest("reqId");
$reqTahun = httpFilterGet("reqTahun");


if($reqView == 'LihatNoLogin'){}
else
{
	if ($userLogin->checkUserLogin()) 
	{ 
		$userLogin->retrieveUserInfo();
	}
}

if($reqTahun == "")
	$reqTahun = date("Y");

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
	<link href="../WEB-INF/css/gaya.css" rel="stylesheet" type="text/css" /> 

    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
        
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare the data
			// GOLONGAN	
			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'KETERANGAN' },
					{ name: 'JUMLAH' }
				],
				url: '../json-grafik/jenis_pegawai_json.php?reqTahun=<?=$reqTahun?>'
			};
			var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });
		
			// prepare jqxChart settings
			var settings = {
				title: "Grafik Pegawai Berdasarkan Jenis Pegawai",
				description: "Tahun <?=$reqTahun?>",
				enableAnimations: true,
				showLegend: true,
				padding: { left: 5, top: 5, right: 15, bottom: 5 },
				titlePadding: { left: 90, top: 0, right: 0, bottom: 20 },
				source: dataAdapter,
				categoryAxis:
					{
						textRotationAngle: 20,
						dataField: 'KETERANGAN',
						showTickMarks: true,
						tickMarksInterval: 1,
						unitInterval: 1,
						axisSize: 'auto',
						tickMarksColor: '#feecce',
						gridLinesColor: '#feecce',
						showGridLines: false,
						gridLinesInterval: 1 
					},
				colorScheme: 'scheme01',
				seriesGroups:
					[
						{
							type: 'column',
							showLabels: true,
							columnsGapPercent: 50,
							seriesGapPercent: 5,
							useGradient: false, // disable gradient for the entire group
							valueAxis:
							{
								unitInterval: 500,
								displayValueAxis: true,
								description: 'pegawai',
								showGridLines: false
							},
							series: [
									{ dataField: 'JUMLAH', displayText: 'Jumlah Pegawai', opacity: 0.8, color: '#6bcaca' }
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
		
			$.getJSON('../json-grafik/jenis_pegawai_json.php?reqTahun=<?=$reqTahun?>', function (data) 
			{
				$.each(data, function (i, SingleElement) {
					$("#tableGolongan tbody").append('<tr><td>'+SingleElement.KETERANGAN+'</td><td>'+SingleElement.JUMLAH+'</td></tr>');							
				});
			});		


		    
			$('#reqTahun').combobox({
				onSelect: function(param){
					document.location.href = 'jenis_pegawai_grafik_statistik.php?reqTahun='+$('#reqTahun').combobox('getValue');
				}
			});

        });
    </script>
    

	</head>
    <body>
    <div id="konten">
    	<div id="grafik-tabel">
        Tahun : <select name="reqTahun" id="reqTahun" class="easyui-combobox">
            <?
            for($i=2014;$i<=date("Y");$i++)
            {
            ?>
                <option value="<?=$i?>" <? if($i == $reqTahun) {?> selected <? } ?>><?=$i?></option>
            <?
            }
            ?>
        </select>
            <table id="tableGolongan">
            <thead>  
                <tr>
                    <td>Tipe Pegawai</td>
                    <td>Jumlah</td>
                </tr>
            </thead>
            <tbody> 
            </tbody>    
            </table>
        </div>
		<div id='chartGolongan' class="grafik-tampil" style="width:calc(100% - 280px); height:400px; position: relative; left: 0px; top: 0px;"></div>    
    </div>
    </body>
</html>
