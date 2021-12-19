<?PHP
/**
*	patConfigUser
*	Configuration of User
*	$Id: patConfigUser.php,v 1.1 2001/06/20 14:44:11 schst Exp $
*	$Log: patConfigUser.php,v $
*	Revision 1.1  2001/06/20 14:44:11  schst
*	added <getConfigValue>
*	added user extension
*	
*
*	@access	public
*	@version	$Revision: 1.1 $
*	@author		Stephan Schmidt <schst@php-tools.de>
*	@package	patConfiguration
*/
	class	patConfigUser extends patConfigExtension
{
/**
*	default namespace for this extension
*
*	@var	string	$defaultNS
*/
	var	$defaultNS	=	"user";

/**
*	array containing all connections
*	@var	array	$dbcs
*/
	var	$users	=	array();

/**
*	stack for all attributes
*	@var	array	$attStack
*/
	var	$attStack	=	array();
	
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
			case	"user":
				$this->currentName	=	$attributes["name"];
				break;

			case	"timestamp":
				$this->users[$this->currentName]["lifetime"]		=	$attributes["lifetime"];
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
			case	"user":
				$this->users[$this->currentName][user]			=	new	patUser( $this->users[$this->currentName][dbc] );

				if( $this->users[$this->currentName][tablename] )
					$this->users[$this->currentName][user]->setTable( $this->users[$this->currentName][tablename] );
				
				if( $this->users[$this->currentName][primary] )
					$this->users[$this->currentName][user]->setPrimary( $this->users[$this->currentName][primary] );
				
				if( $this->users[$this->currentName][timestamp] )
					$this->users[$this->currentName][user]->setTimestamp( $this->users[$this->currentName][timestamp], $this->users[$this->currentName]["lifetime"] );

				$this->config->setTypeValue( $this->users[$this->currentName][user], "leave", $this->currentName );
				break;

			default:
				$this->users[$this->currentName][$name]	=	$this->config->getData();
				break;
		}
	}
}
?>