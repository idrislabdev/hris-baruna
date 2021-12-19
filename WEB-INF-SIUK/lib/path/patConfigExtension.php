<?PHP
/**
*	patConfigExtension
*	Base class for extensions for patConfiguration
*	$Id: patConfigExtension.php,v 1.2 2001/06/20 11:44:35 schst Exp $
*	$Log: patConfigExtension.php,v $
*	Revision 1.2  2001/06/20 11:44:35  schst
*	extensions can now contain any other values, not only strings
*	
*	Revision 1.1  2001/06/17 11:37:36  schst
*	added extension mechanism using namespaces
*	added dbc extension
*	
*
*	@access	public
*	@version	$Revision: 1.2 $
*	@author		Stephan Schmidt <schst@php-tools.de>
*	@package	patConfiguration
*/
	class	patConfigExtension
{
/**
*	default namespace for this extension
*
*	@var	string	$defaultNS
*/
	var	$defaultNS	=	"ext";

/**
*	reference to the main configuration object
*
*	@var	object	$config
*/
	var	$config;

/**
*	get the default namespace for this extension
*
*	@access	public
*	@return	string	$defaultNS	default	namespace
*/
	function	getDefaultNS()
	{
		return	$this->defaultNS;
	}

/**
*	store reference to patConfiguration object
*
*	@access	public
*	@param	object patConfiguration	&$config	patConfiguration object
*/
	function	setConfigReference( &$config )
	{
		$this->config	=	&$config;
	}
	
/**
*	handle start element
*	overload this method
*	
*	@param	int		$parser		resource id of the current parser
*	@param	string	$name		name of the element
*	@param	array	$attributes	array containg all attributes of the element
*/
	function	startElement( $parser, $name, $attributes )
	{
	}

/**
*	handle end element
*	overload this method
*	
*	@param	int		$parser		resource id of the current parser
*	@param	string	$name		name of the element
*/
	function	endElement( $parser, $name )
	{
	}
}
?>