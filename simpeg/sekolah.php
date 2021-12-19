<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Data Sekolah</title>
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
	Ext.define('DATA_SEKOLAH', {
        extend: 'Ext.data.Model', idProperty: 'SEKOLAH_ID',
        fields: ['SEKOLAH_ID','NAMA','TELPON', 'EMAIL', 'WEBSITE', 'ALAMAT','FAX','REKOMENDASI_N','REKOMENDASI_T','SERTIFIKAT','TGL_SERTIFIKAT', 'TEXT_TGL_SERTIFIKAT', 'APPROVAL_DESC','KOTA']
    });
	var data_sekolah =  Ext.create('Ext.data.Store', {
		model: 'DATA_SEKOLAH', pageSize: perpage,
		proxy: {
			type: 'ajax', url: '../json-simpeg/sekolah_json.php',
            reader: {root: 'ISI_DATA', totalProperty: 'TOTAL' }, 
			actionMethods: {read: 'POST'}
		}
	});
	data_sekolah.load();

		/* SET TAMPILAN */
    var viewport = Ext.create('Ext.Viewport', {
		layout: {type: 'border',padding:0},
		items: 
		[{
			xtype: 'box', region: 'north', html:'<div id="window_header"><h1>Data Sekolah Pelayaran</h1></div>', height: 65,
		},{
			id: 'panel_box', region:'center', layout: {type: 'border',padding:0},
			items: [{
				autoScroll:true,title:'Data Sekolah',id:'panel_utama', region:'center', margins:'5 0 5 5', html:'<div id="window_utama"></div>',  bodyPadding:'5', split:true
			}]
		}],
		renderTo: Ext.getBody()
	});
	var gridku = Ext.create('Ext.grid.GridPanel', {
		store: data_sekolah, 
		loadMask:true, columnLines:true,
		columns: [
			new Ext.grid.RowNumberer({text:'No', width:30 , locked:true }),
			{id:'SEKOLAH_ID',header: 'Nama Sekolah', width: 150, sortable: true, dataIndex: 'NAMA', align:'left', locked:true},
			{header: 'Kota', width: 125, sortable: true, dataIndex: 'KOTA', align:'center'},
			{header: 'Telpon', width: 125, sortable: true, dataIndex: 'TELPON', align:'center'},
			{header: 'Email', width: 125, sortable: true, dataIndex: 'EMAIL', align:'center'},
			{header: 'Website', width: 125, sortable: true, dataIndex: 'WEBSITE', align:'center'},
			{header: 'Fax', width: 125, sortable: true, dataIndex: 'FAX', align:'center'},
			{header: 'Alamat', width: 255, sortable: true, dataIndex: 'ALAMAT', align:'left'},
			{text:'Rekomendasi', columns:[
				{text:'N', width:45, sortable:true, align:'center', dataIndex:'REKOMENDASI_N'},
				{text:'T', width:45, sortable:true, align:'center', dataIndex:'REKOMENDASI_T'},
			]},
			{text:'Sertifikat', columns:[
				{text:'No', width:155, sortable:true, align:'center', dataIndex:'SERTIFIKAT'},
				{text:'Tanggal', width:95, sortable:true, align:'center', dataIndex:'TEXT_TGL_SERTIFIKAT'},
			]},
			{header: 'Approval', width: 105, sortable: true, dataIndex: 'APPROVAL_DESC', align:'center'}
		],
		stripeRows: true, id :'gridd', title:'',
		viewConfig: {
			getRowClass: function(record, index) {
				if( record.get('SEKOLAH_ID') == '0') return 'bg_telat';
				else if( record.get('SEKOLAH_ID') == '1') return 'bg_telat';
				else return '';
			}
		},
		selType: 'rowmodel',
		dockedItems: 
		[{  dock: 'top', xtype: 'toolbar',
            items:[{
                width: 300,fieldLabel: 'Cari',labelWidth:25,xtype: 'searchfield', store: data_sekolah
            },{
				id: 'tombol_tambah', text:'Tambah Data', tooltip:'Tambah Data', iconCls:'ikon_add_data'				
			},{
				id: 'tombol_edit', text:'Edit Data', tooltip:'Edit Data', iconCls:'ikon_edit_data'
			}]
        },{
			xtype: 'pagingtoolbar',store: data_sekolah, 
			dock: 'bottom',displayInfo: true
		}]
	});
	gridku.setHeight(Ext.get('panel_utama').getHeight() - 37);
	gridku.render('window_utama');

	var form_edit = Ext.create('Ext.form.FormPanel', {
	    id: 'form_edit', frame: true, labelAlign: 'left', title: '', bodyPadding:'5', buttonAlign:'center', waitMsgTarget:true, 
	    url : '../json-simpeg/sekolah_add.php', defaultType: 'textfield',
		fieldDefaults: {allowBlank:false, labelWidth:155, width:420}, 
		items: 
			[{
	          	fieldLabel: '', name: 'SEKOLAH_ID', hidden:true, hideLabel: true, allowBlank: true
	        },{
	            fieldLabel: 'NAMA', name: 'NAMA'
	        },{
	            fieldLabel: 'TELPON', name: 'TELPON', allowBlank: true
	        },{
	            fieldLabel: 'FAX', name: 'FAX', allowBlank: true
	        },{
	            fieldLabel: 'EMAIL', name: 'EMAIL', allowBlank: true
	        },{
	            fieldLabel: 'WEBSITE', name: 'WEBSITE', allowBlank: true
	        },{
	            fieldLabel: 'KOTA', name: 'KOTA', allowBlank: true
			},{
	            fieldLabel: 'ALAMAT', name: 'ALAMAT', allowBlank: true
			},{
	            fieldLabel: 'REKOMENDASI N', name: 'REKOMENDASI_N', allowBlank: true
			},{
	            fieldLabel: 'REKOMENDASI T', name: 'REKOMENDASI_T', allowBlank: true
			},{
	            fieldLabel: 'SERTIFIKAT', name: 'SERTIFIKAT', xtype: 'textarea', allowBlank: true
			},{
	            fieldLabel: 'TGL SERTIFIKAT', name: 'TGL_SERTIFIKAT', xtype:'datefield', format:'d-m-Y', allowBlank: true
			},{
	            fieldLabel: 'APPROVAL DESC', name: 'APPROVAL_DESC', allowBlank: true
			}],
		buttons: [{
			text: 'Save',
			handler  : function(){
				var w = this.up('.window');
				if(form_edit.getForm().isValid()){
					//var idsimp1 = formmul.findField('id_simp_temp');
					form_edit.getForm().submit({
						url: this.url,
						waitMsg: 'Proses penyimpanan data...',
						success: function(){form_edit.getForm().reset(); w.close(); data_sekolah.load({params:{start:0, limit:perpage}}); },
						failure: function(){form_edit.getForm().reset(); w.close(); data_sekolah.load({params:{start:0, limit:perpage}}); }
					});
				}
				else {Ext.Msg.alert('ERROR', 'Ada kesalahan inputan, silahkan diperiksa lagi');}
			}
		},{
			text: 'Cancel',
			handler  : function(){
				form_edit.getForm().reset();
				this.up('.window').close();
			}
		}]
	});
	
	var tbl_tambah = Ext.get('tombol_tambah');
	tbl_tambah.on('click', function(){
		form_edit.getForm().reset();
		if(!window_tambah){
			window_tambah = new Ext.Window({
				applyTo     : 'window_tambah',layout : 'anchor',title : 'Tambah / Edit Data',
				width       : 650, height : 470, closeAction :'hide',
				scrollAble : true, plain : true, items : form_edit
			});
		}
		window_tambah.show();
	});

	var tbl_edit = Ext.get('tombol_edit');
	tbl_edit.on('click', function(){		
		/*var selected_id = '';
		for (var i = 0; i < sels.length; i++){
			selected_id += sels[i].get('SEKOLAH_ID') + ',';
		}*/
		if (gridku.getSelectionModel().hasSelection()) {
			var sels = gridku.getSelectionModel().getSelection()[0];
			form_edit.getForm().reset();
			form_edit.getForm().loadRecord(sels); 
			if(!window_tambah){
				window_tambah = new Ext.Window({
					applyTo     : 'window_tambah',layout : 'anchor',title : 'Tambah / Edit Data',
					width       : 650, height : 470, closeAction :'hide',
					scrollAble : true, plain : true, items : form_edit
				});
			}
			window_tambah.show();
		} else {
			Ext.Msg.alert('ERROR', 'Pilih salah satu data dulu!');
		}
	});
	
	Ext.EventManager.onWindowResize(function(w, h){
		/*gridku.setHeight(Ext.get('panel_utama').getHeight() - 37); gridku.getView().refresh();*/
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