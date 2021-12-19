<?php 
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-penilaian/PenilaianPeriode.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$penilaian_periode = new PenilaianPeriode();
$reqPeriode = $penilaian_periode->getPeriodeAkhir();

?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Bonus Tahunan</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="SHORTCUT ICON" href="../WEB-INF/lib/ext/images/indracogroup.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ext/resources/css/ext-all.css">
	<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ext/css/style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ext/ext-all.js" ></script>
	<script type="text/javascript" src="../WEB-INF/lib/ext/ux/exporter/downloadify.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/ext/ux/exporter/swfobject.js"></script>
	<!--<script src="../WEB-INF/ext/ext-all-debug.js" type="text/javascript"></script>-->
	<script type="text/javascript">var perpage = 50;  </script>
	
	<script src="../WEB-INF/lib/ext/jquery/jquery.js" type="text/javascript"></script>

	<script type="text/javascript">		
		Ext.Loader.setConfig({enabled:true});
		Ext.Loader.setPath('Ext.ux', '../WEB-INF/lib/ext/ux/');
		Ext.require(['*',
			'Ext.toolbar.Paging',
			'Ext.ux.LiveSearchGridPanel',
			'Ext.tip.QuickTipManager', 
			'Ext.grid.*',
			'Ext.ux.exporter.Exporter',
			'Ext.ux.form.SearchField'
		]);
		Ext.require('Ext.view.AbstractView',
			function() {
				Ext.override(Ext.view.AbstractView, {
					onRender: function() {
						var me = this;
						me.callOverridden(arguments);
						if (me.loadMask && Ext.isObject(me.store)) {
							me.setMaskBind(me.store);
						}
					}
				});
			}
		);
	</script>
<script type="text/javascript">
Ext.onReady (function () {
	var window_tambah, window_edit, gridbaru= '';
	var tinggi = Ext.getBody().getViewSize().height;	
	Ext.form.Field.prototype.msgTarget = 'side';
	Ext.QuickTips.init();
	function successNotice(form, action) { Ext.Msg.alert('Confirmation', 'Success!');}
	function failureNotice(form, action) {
		obj = Ext.util.JSON.decode(aksi.response.responseText);
		Ext.Msg.show({
			title:'Error', msg:obj.error,
			buttons: Ext.Msg.OK, icon: Ext.MessageBox.ERROR, width: 275
		});
	}
	/*SET DATA*/
	var varReqPeriode = '<?php echo $reqPeriode; ?>';
	var varReqDepartemen = 'ALL';
	var varReqJenis = 'TIDAK_LENGKAP';
	Ext.define('DATA_BONUS', {
        extend: 'Ext.data.Model', idProperty: 'NO',
        fields: ['NO', 'NAMA','JENIS_PEGAWAI','PEGAWAI_ID', 'NRP', 'NPWP', 'DEPARTEMEN', 'NILAI_PI','NILAI_SKI','NILAI_TOTAL',
        'NILAI_KATEGORI','JUMLAH_BONUS','PPH_PERSEN','PPH_KALI','PPH_NILAI','PERIODE',
        'BANK', 'REKENING_NO', 'REKENING_NAMA', 'JUMLAH_DIBAYAR']
    });
	var data_bonus =  Ext.create('Ext.data.Store', {
		model: 'DATA_BONUS', pageSize: perpage,
		proxy: {
			type: 'ajax', url: '../json-gaji/gaji_bonus_tahunan_json_new.php',
            reader: {root: 'ISI_DATA', totalProperty: 'TOTAL' }, 
			actionMethods: {read: 'POST'},
			extraParams: {
	            reqPeriode : varReqPeriode,
	            reqDepartemen : varReqDepartemen,
	            reqJenis : varReqJenis
	        }
		},
		remoteSort: true /*
		sortInfo: { //default sort  
		    field: 'NAMA',
		    direction: 'ASC' | 'DESC'
		}*/
	});	

	var data_pilihan_periode = new Ext.data.ArrayStore({
		fields : ['ID_PERIODE', 'NAMA_PERIODE'],
		data:[['2014', '2014']]
	});

	var combo_pilihan_periode = Ext.create('Ext.form.field.ComboBox', {
		emptyText: 'Pilih Periode',
		displayField: 'NAMA_PERIODE',
		valueField: 'ID_PERIODE',
		width: 110,
		autoSelect: true,
		store: data_pilihan_periode,
		queryMode: 'local',
		typeAhead: true,
		listeners: {
            change: function (field, newValue, oldValue) {
            	varReqPeriode = combo_pilihan_periode.getValue();
            	varReqDepartemen = combo_pilihan_departemen.getValue();
            	varReqJenis = combo_pilihan_jenis.getValue();
            	data_bonus.getProxy().extraParams = {
				    reqPeriode : varReqPeriode,
				    reqDepartemen : varReqDepartemen,
			        reqJenis : varReqJenis
				};
            	data_bonus.load();
			}
        }
	});
	
	Ext.define('DATA_DEPARTEMEN', {
        extend: 'Ext.data.Model', idProperty: 'DEPARTEMEN_ID',
        fields: ['DEPARTEMEN_ID','NAMA']
    });
	var data_pilihan_departemen =  Ext.create('Ext.data.Store', {
		model: 'DATA_DEPARTEMEN', pageSize: 1000,
		proxy: {
			type: 'ajax', url: '../json-penilaian/data_pilihan_departemen_json.php',
            reader: {root: 'ISI_DATA', totalProperty: 'TOTAL' }, 
			actionMethods: {read: 'POST'}
		}
	});	
	var combo_pilihan_departemen = Ext.create('Ext.form.field.ComboBox', {
		emptyText: 'Pilih Departemen',
		displayField: 'NAMA',
		valueField: 'DEPARTEMEN_ID',
		width: 230,
		autoSelect: true,
		store: data_pilihan_departemen,
		queryMode: 'local',
		typeAhead: true,
		listeners: {
            change: function (field, newValue, oldValue) {
            	varReqPeriode = combo_pilihan_periode.getValue();
            	varReqDepartemen = combo_pilihan_departemen.getValue();
            	varReqJenis = combo_pilihan_jenis.getValue();
            	data_bonus.getProxy().extraParams = {
				    reqPeriode : varReqPeriode,
				    reqDepartemen : varReqDepartemen,
			        reqJenis : varReqJenis
				};
            	data_bonus.load();
			}
        }
	});
	
	Ext.define('DATA_JENIS_PEGAWAI', {
        extend: 'Ext.data.Model', idProperty: 'JENIS_PEGAWAI_ID',
        fields: ['JENIS_PEGAWAI_ID','NAMA']
    });
	var data_pilihan_jenis_pegawai =  Ext.create('Ext.data.Store', {
		model: 'DATA_JENIS_PEGAWAI', pageSize: 1000,
		proxy: {
			type: 'ajax', url: '../json-simpeg/data_pilihan_jenis_json.php',
            reader: {root: 'ISI_DATA', totalProperty: 'TOTAL' }, 
			actionMethods: {read: 'POST'}
		}
	});	
	var combo_pilihan_jenis = Ext.create('Ext.form.field.ComboBox', {
		emptyText: 'Pilih Jenis Pegawai',
		displayField: 'NAMA',
		valueField: 'JENIS_PEGAWAI_ID',
		width: 200,
		autoSelect: true,
		store: data_pilihan_jenis_pegawai,
		queryMode: 'local',
		typeAhead: true,
		listeners: {
            change: function (field, newValue, oldValue) {
            	varReqPeriode = combo_pilihan_periode.getValue();
            	varReqDepartemen = combo_pilihan_departemen.getValue();
            	varReqJenis = combo_pilihan_jenis.getValue();
            	data_bonus.getProxy().extraParams = {
				    reqPeriode : varReqPeriode,
				    reqDepartemen : varReqDepartemen,
			        reqJenis : varReqJenis
				};
            	data_bonus.load();
			}
        }
	});

	data_pilihan_periode.load(function(st){
		combo_pilihan_periode.select(data_pilihan_periode.getAt(0));
	});

	data_pilihan_departemen.load(function(st){
		combo_pilihan_departemen.select(data_pilihan_departemen.getAt(0));
	});

	data_pilihan_jenis_pegawai.load(function(st){
		combo_pilihan_jenis.select(data_pilihan_jenis_pegawai.getAt(0));
	});
		
		/* SET TAMPILAN */
    var viewport = Ext.create('Ext.Viewport', {
		layout: {type: 'border',padding:0},
		items: 
		[{
			xtype: 'box', region: 'north', html:'<div id="window_header"><h1>Bonus Tahunan</h1></div>', height: 65,
		},{
			id: 'panel_box', region:'center', layout: {type: 'border',padding:0},
			items: [{
				autoScroll:true,title:'',id:'panel_utama', region:'center', margins:'5 0 5 5', html:'<div id="window_utama"></div>',  bodyPadding:'5', split:true
			}]
		}],
		renderTo: Ext.getBody()
	});
	var gridku = Ext.create('Ext.grid.GridPanel', {
		store: data_bonus, 
		loadMask:true, columnLines:true,
		columns: [
			new Ext.grid.RowNumberer({text:'No', width:30 , locked:true }),
			{id:'PEGAWAI_ID',header: 'NAMA', width: 150, sortable: false, dataIndex: 'NAMA', align:'left', locked:true},
			{header: 'NRP', width: 95, sortable: true, dataIndex: 'NRP', align:'left'},
			{header: 'JENIS PEGAWAI', width: 95, sortable: true, dataIndex: 'JENIS_PEGAWAI', align:'left'},
			{header: 'DEPARTEMEN', width: 165, sortable: true, dataIndex: 'DEPARTEMEN', align:'left'},
			{header: 'NPWP', width: 145, sortable: true, dataIndex: 'NPWP', align:'left'},
			{header: 'BANK', width: 145, sortable: true, dataIndex: 'BANK', align:'left'},
			{header: 'NO REKENING', width: 145, sortable: true, dataIndex: 'REKENING_NO', align:'left'},
			{header: 'NAMA REKENING', width: 145, sortable: true, dataIndex: 'REKENING_NAMA', align:'left'},
			{text:'NILAI', columns:[
				{text:'PI', width:85, sortable:true, align:'center', dataIndex:'NILAI_PI'},
				{text:'SKI', width:75, sortable:true, align:'center', dataIndex:'NILAI_SKI'},
				{text:'TOTAL', width:75, sortable:true, align:'center', dataIndex:'NILAI_TOTAL'},
				{text:'KATEGORI', width:75, sortable:true, align:'center', dataIndex:'NILAI_KATEGORI'}
			]},
			{header: 'JUMLAH BONUS', width: 115, sortable: true, dataIndex: 'JUMLAH_BONUS', align:'right', 
				renderer: function(n) {
		            return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		        }
			},
			{header: 'PPH (%)', width: 55, sortable: true, dataIndex: 'PPH_PERSEN', align:'right'},
			{header: 'JUMLAH PPH', width: 85, sortable: true, dataIndex: 'PPH_NILAI', align:'right', 
				renderer: function(n) {
		            return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		        }
		   	},
			{header: 'JUMLAH DIBAYAR', width: 165, sortable: true, dataIndex: 'JUMLAH_DIBAYAR', align:'right', 
				renderer: function(n) {
		            return n.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		        }
		    },
		],
		stripeRows: true, id :'gridd', title:'',
		viewConfig: {
			getRowClass: function(record, index) {
				if( record.get('PEGAWAI_ID') == '0') return 'bg_telat';
				else if( record.get('PEGAWAI_ID') == '1') return 'bg_telat';
				else return '';
			}
		},
		selType: 'rowmodel',
		dockedItems: 
		[{  dock: 'top', xtype: 'toolbar',
            items:[{
				id: 'tombol_export', text:'Download Excell', tooltip:'Download Excell', iconCls:'ikon_excell'	
			},{
				xtype: 'tbseparator'
			},{
				id: 'tombol_slip', text:'Cetak Slip', tooltip:'Cetak Slip', iconCls:'ikon_excell'	
			},{
				xtype: 'tbseparator'
			},{ 
				xtype: 'tbtext', text: 'Periode : '
			},combo_pilihan_periode,{
				xtype: 'tbseparator'
			},{ 
				xtype: 'tbtext', text: 'Departemen : '
			},combo_pilihan_departemen,{
				xtype: 'tbseparator'
			},{ 
				xtype: 'tbtext', text: 'Jenis Pegawai: '
			},combo_pilihan_jenis,{
				xtype: 'tbseparator'
			},{
                width: 200,fieldLabel: 'Cari',labelWidth:25, emptyText:'Cari pegawai...', xtype: 'searchfield', store: data_bonus, params:{reqPeriode:combo_pilihan_periode.getValue(), reqJenis:combo_pilihan_jenis.getValue()}
            }]
        },{
			xtype: 'pagingtoolbar',store: data_bonus, 
			dock: 'bottom',displayInfo: true
		}]
	});
	gridku.setHeight(Ext.get('panel_utama').getHeight() - 37);
	gridku.render('window_utama');

	var tombol_export = Ext.get('tombol_export');
	tombol_export.on('click', function(){
		newWindow = window.open('bonus_tahunan_excell.php?reqDepartemen=' + combo_pilihan_departemen.getValue() + '&reqPeriode=' + combo_pilihan_periode.getValue() + '&reqJenis=' +  combo_pilihan_jenis.getValue(), 'Cetak');
		newWindow.focus();

	});	
	
	var tombol_slip = Ext.get('tombol_slip');
	tombol_slip.on('click', function(){
		newWindow = window.open('slip_bonus_new.php?reqDepartemen=' + combo_pilihan_departemen.getValue() + '&reqPeriode=' + combo_pilihan_periode.getValue() + '&reqJenis=' +  combo_pilihan_jenis.getValue(), 'Cetak');
		newWindow.focus();

	});	
	
	
});
</script>
</head>
<body>
<div id="window_tambah"></div>
</body>
<script type="text/javascript">
		$(document).ready( function () {
			
		});
	</script>
</html>