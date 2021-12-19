<?PHP
/**
*	patConfigDbc
*	Configuration of DBC
*	$Id: patConfigDbc.php,v 1.6 2001/09/26 17:48:11 schst Exp $
*	$Log: patConfigDbc.php,v $
*	Revision 1.6  2001/09/26 17:48:11  schst
*	writeConfigFile() implemented (only XML Files)
*	
*	Revision 1.5  2001/06/20 11:44:35  schst
*	extensions can now contain any other values, not only strings
*	
*	Revision 1.4  2001/06/19 23:44:31  schst
*	internal cleanup
*	added template extension
*	added dynamic loading functions (extenstions & other files)
*	
*	Revision 1.3  2001/06/19 21:45:50  schst
*	now supporting type="array"
*	
*	Revision 1.2  2001/06/19 09:49:00  schst
*	removed path bug from dbc extension
*	added new way to define config path by element names
*	
*	Revision 1.1  2001/06/17 11:37:36  schst
*	added extension mechanism using namespaces
*	added dbc extension
*	
*
*	@access	public
*	@version	$Revision: 1.6 $
*	@author		Stephan Schmidt <schst@php-tools.de>
*	@package	patConfiguration
*/

class	patConfigDbc extends patConfigExtension
{
/**
*	default namespace for this extension
*
*	@var	string	$defaultNS
*/
	var	$defaultNS	=	"dbc";

/**
*	array containing all connections
*	@var	array	$dbcs
*/
	var	$dbcs	=	array();

/**
*	array containing all attributes of the current tag
*	@var	array	$currentAttributes
*/
	var	$currentAttributes	=	array();

	
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
		switch( strtolower( $name ) )
		{
			case	"connection":
				$this->currentName	=	$attributes["name"];
				break;
			case	"result":
				$this->currentAttributes	=	$attributes;
				break;
		}
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
		$name	=	strtolower( $name );
		switch( $name )
		{
			case	"connection":
				switch( $this->dbcs[$this->currentName]["type"] )
				{
					case	"mysql":
						$this->dbcs[$this->currentName][dbc]	=	new	patMySqlDbc( $this->dbcs[$this->currentName][host], $this->dbcs[$this->currentName][db], $this->dbcs[$this->currentName][user], $this->dbcs[$this->currentName][pass] );

						$this->config->setTypeValue( $this->dbcs[$this->currentName][dbc], "leave", $this->currentName );
						break;
				}
				break;
			case	"result":
				if( !$this->dbcs[$this->currentAttributes["dbc"]][dbc] )
					return	false;

				$result		=	$this->dbcs[$this->currentAttributes["dbc"]][dbc]->query( $this->config->getData() );
				switch( $this->currentAttributes["mode"] )
				{
					case	"array":
						$data	=	$result->get_result();
						$this->config->setTypeValue( $data, "leave", $this->currentAttributes["name"] );

						$result->free();
						break;
				}
				break;

			default:
				$this->dbcs[$this->currentName][$name]	=	$this->config->getData();
				unset( $this->data );
				break;
		}
	}
}
?>