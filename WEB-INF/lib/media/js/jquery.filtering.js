jQuery.fn.dataTableExt.oApi.fnSetFilteringPressEnter = function (oSettings) {
	/*
	* Type:        Plugin for DataTables (www.datatables.net) JQuery plugin.
	* Name:        dataTableExt.oApi.fnSetFilteringPressEnter
	* Version:     2.2.1
	* Description: Enables filtration to be triggered by pressing the enter key instead of keyup or delay.
	* Inputs:      object:oSettings - dataTables settings object
	*             
	* Returns:     JQuery
	* Usage:       $('#example').dataTable().fnSetFilteringPressEnter();
	* Requires:   DataTables 1.6.0+
	*
	* Author:      Jon Ranes (www.mvccms.com)
	* Created:     4/17/2011
	* Language:    Javascript
	* License:     GPL v2 or BSD 3 point style
	* Contact:     jranes /AT\ mvccms.com
	*/
	var _that = this;
 
	this.each(function (i) {
		$.fn.dataTableExt.iApiIndex = i;
		var $this = this;
		var anControl = $('input', _that.fnSettings().aanFeatures.f);
		anControl.unbind('keyup').bind('keypress', function (e) {
			if (e.which == 13) {
				$.fn.dataTableExt.iApiIndex = i;
				_that.fnFilter(anControl.val());
			}
		});
		return this;
	});
	return this;
}