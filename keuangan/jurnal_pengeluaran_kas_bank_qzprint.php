<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqNoBukti = httpFilterGet("reqNoBukti");
?>
<html>
<!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE -->
<head><title>QZ Print Plugin</title>
<script type="text/javascript" src="../WEB-INF/lib/qzprint/js/deployJava.js"></script>
<script type="text/javascript">
	/**
	* Optionally used to deploy multiple versions of the applet for mixed
	* environments.  Oracle uses document.write(), which puts the applet at the
	* top of the page, bumping all HTML content down.
	*/
	deployQZ();
	
	/**
	* Deploys different versions of the applet depending on Java version.
	* Useful for removing warning dialogs for Java 6.  This function is optional
	* however, if used, should replace the <applet> method.  Needed to address 
	* MANIFEST.MF TrustedLibrary=true discrepency between JRE6 and JRE7.
	*/
	function deployQZ() {
		var attributes = {id: "qz", code:'qz.PrintApplet.class', 
			archive:'../WEB-INF/lib/qzprint/qz-print.jar', width:1, height:1};
		var parameters = {jnlp_href: '../WEB-INF/lib/qzprint/qz-print_jnlp.jnlp', 
			cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			attributes['archive'] = '../WEB-INF/lib/qzprint/jre6/qz-print.jar';
			parameters['jnlp_href'] = '../WEB-INF/lib/qzprint/jre6/qz-print_jnlp.jnlp';
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
	
	/**
	* Automatically gets called when applet has loaded.
	*/
	function qzReady() {
		// Setup our global qz object
		window["qz"] = document.getElementById('qz');
		var title = document.getElementById("title");
		if (qz) {
			try {
				title.innerHTML = title.innerHTML + " " + qz.getVersion();
				document.getElementById("content").style.background = "#F0F0F0";
			} catch(err) { // LiveConnect error, display a detailed meesage
				document.getElementById("content").style.background = "#F5A9A9";
				alert("ERROR:  \nThe applet did not load correctly.  Communication to the " + 
					"applet has failed, likely caused by Java Security Settings.  \n\n" + 
					"CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " + 
					"once Oracle has marked that version as outdated, which " + 
					"is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " + 
					"Java version \n          (or)\n  2. Lower the security " + 
					"settings from the Java Control Panel.");
		  }
	  }
	}
	
	/**
	* Returns whether or not the applet is not ready to print.
	* Displays an alert if not ready.
	*/
	function notReady() {
		// If applet is not loaded, display an error
		if (!isLoaded()) {
			return true;
		}
		// If a printer hasn't been selected, display a message.
		else if (!qz.getPrinter()) {
			alert('Please select a printer first by using the "Detect Printer" button.');
			return true;
		}
		return false;
	}
	
	/**
	* Returns is the applet is not loaded properly
	*/
	function isLoaded() {
		if (!qz) {
			alert('Error:\n\n\tPrint plugin is NOT loaded!');
			return false;
		} else {
			try {
				if (!qz.isActive()) {
					alert('Error:\n\n\tPrint plugin is loaded but NOT active!');
					return false;
				}
			} catch (err) {
				alert('Error:\n\n\tPrint plugin is NOT loaded properly!');
				return false;
			}
		}
		return true;
	}
	
	/**
	* Automatically gets called when "qz.print()" is finished.
	*/
	function qzDonePrinting() {
		// Alert error, if any
		if (qz.getException()) {
			alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
			qz.clearException();
			return; 
		}
		
		// Alert success message
		alert('Successfully sent print data to "' + qz.getPrinter() + '" queue.');
	}
	
	/***************************************************************************
	* Prototype function for finding the "default printer" on the system
	* Usage:
	*    qz.findPrinter();
	*    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
	***************************************************************************/
	function useDefaultPrinter() {
		if (isLoaded()) {
			// Searches for default printer
			qz.findPrinter();
			
			// Automatically gets called when "qz.findPrinter()" is finished.
			window['qzDoneFinding'] = function() {
				// Alert the printer name to user
				var printer = qz.getPrinter();
				/*alert(printer !== null ? 'Default printer found: "' + printer + '"':
					'Default printer ' + 'not found');*/
				
				// Remove reference to this function
				window['qzDoneFinding'] = null;
			};
		}
	}
	
	
	/***************************************************************************
	* Prototype function for printing a text or binary file containing raw 
	* print commands.
	* Usage:
	*    qz.appendFile('/path/to/file.txt');
	*    window['qzDoneAppending'] = function() { qz.print(); };
	***************************************************************************/ 
	function printWeb(file) {
		
		useDefaultPrinter();
		
		// Append raw or binary text file containing raw print commands
		qz.appendFile(file);
		
		// Automatically gets called when "qz.appendFile()" is finished.
		window['qzDoneAppending'] = function() {
			qz.setPaperSize("9.5in", "11.0in");  // US Letter
            qz.setAutoSize(true);
			qz.print();
			
			// Remove reference to this function
			window['qzDoneAppending'] = null;
		};
	}
	
	printWeb('http://192.168.88.98:8080/jasperserver/flow.html?_flowId=viewReportFlow&reportUnit=%2Freports%2FJURNAL_PENGELUARAN_KAS_BANK&standAlone=true&j_acegi_security_check&j_username=jasperadmin&j_password=jasperadmin&output=txt&NOTA_IN_PARAM=<?=$reqNoBukti?>');
    
</script>
</head>
</html>