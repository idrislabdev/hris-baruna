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
					{ name: 'JUMLAH_OPS' },
					{ name: 'JUMLAH_INTERNAL' }
				],
				url: '../json-grafik/jenis_pekerjaan_json.php?reqDepartemen=<?=$reqDepartemen?>'
			};
			var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });
		
			// prepare jqxChart settings
			var settings = {
				title: "Grafik Pegawai Berdasarkan Jenis Pekerjaan",
				description: "Tahun <?=date("Y")?>",
				enableAnimations: true,
                showLegend: true,
                legendLayout: { left: 380, top: 50, width: 500, height: 500, flow: 'vertical' },
                padding: { left: -300, top: 5, right: 5, bottom: 5 },
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
                                        labelRadius: 160,
                                        initialAngle: 15,
                                        radius: 150,
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
		
			$.getJSON('../json-grafik/jenis_pekerjaan_json.php?reqDepartemen=<?=$reqDepartemen?>', function (data) 
			{
				$.each(data, function (i, SingleElement) {
					$("#tableGolongan tbody").append('<tr><td>'+SingleElement.KETERANGAN+'</td><td>'+SingleElement.TOTAL+'</td></tr>');							
				});
			});		
			
			  $('#reqDepartemen').combotree({
					onSelect: function(param){
						document.location.href = 'jenis_pekerjaan_grafik_statistik.php?reqDepartemen='+param.id;
					}
			  });			

        });
		
		function openMonitoring(id)
		{
			top.OpenDHTML('agama_grafik_statistik_monitoring.php?reqDepartemen=<?=$reqDepartemen?>&reqId='+id, 'HRIS - Aplikasi Kepegawaian', '600', '300');	
		}
    </script>
    
	</head>
    <body>
    <div id="konten">
    	<div style="margin-bottom:10px">
        Cabang : <input id="reqDepartemen" class="easyui-combotree" name="reqDepartemen" data-options="url:'../json-simpeg/cabang_p3_saja_combo_json.php',
                            valueField:'id',
                            textField:'text'" style="width:290px;" value="<?=$reqDepartemen?>">        
        </div>
    	<div id="grafik-tabel">
            <table id="tableGolongan">
            <thead>  
                <tr>
                    <td>Jenis Pekerjaan</td>
                    <td>TOTAL</td>
                </tr>
            </thead>
            <tbody> 
            </tbody>    
            <tfoot>
            	<td colspan="2" style="color:#F00">*Untuk jabatan yang sudah ditentukan pilih langsung cabangnya.</td>
            </tfoot>
            </table>
            
        </div>
		<div id='chartGolongan' class="grafik-tampil" style="width:750px; height:500px; position: relative; left: 0px; top: 0px;"></div>    
        
    </div>
    </body>
</html>
