<?PHP
/**
*	patConfigTemplate
*	Configuration of patTemplate
*	$Id: patConfigTemplate.php,v 1.2 2001/06/20 11:44:35 schst Exp $
*	$Log: patConfigTemplate.php,v $
*	Revision 1.2  2001/06/20 11:44:35  schst
*	extensions can now contain any other values, not only strings
*	
*	Revision 1.1  2001/06/19 23:44:31  schst
*	internal cleanup
*	added template extension
*	added dynamic loading functions (extenstions & other files)
*	
*
*	@access	public
*	@version	$Revision: 1.2 $
*	@author		Stephan Schmidt <schst@php-tools.de>
*	@package	patConfiguration
*/
	class	patConfigTemplate extends patConfigExtension
{
/**
*	default namespace for this extension
*
*	@var	string	$defaultNS
*/
	var	$defaultNS	=	"tmpl";

/**
*	array containing all templates
*	@var	array	$templates
*/
	var	$templates	=	array();

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
		//	store all attributes as they are needed by endElement
		array_push( $this->attStack, $attributes );
		
		switch( strtolower( $name ) )
		{
			case	"template":
				$this->currentName	=	$attributes["name"];
				$this->templates[$this->currentName]	=	new	patTemplate();
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
		//	get Attributes from stack
		$attributes	=	array_pop( $this->attStack );
		
		$name	=	strtolower( $name );
		switch( $name )
		{
			case	"template":
				$this->config->setTypeValue( $this->templates[$this->currentName], "leave", $this->currentName );
				break;

			//	set basedir
			case	"basedir":
				$this->templates[$this->currentName]->setBaseDir( $this->config->getData() );
				break;

			//	add template
			case	"addtemplate":
				$this->templates[$this->currentName]->addTemplate( $attributes["name"], $this->config->getData() );
				break;

			//	add local variable
			case	"addvar":
				$this->templates[$this->currentName]->addVar( $attributes["template"], $attributes["name"], $this->config->getData() );
				break;

			//	add global variable
			case	"addglobal":
				$this->templates[$this->currentName]->addGlobalVar( $attributes["name"], $this->config->getData() );
				break;

			//	read from file
			case	"readfromfile":
				$this->templates[$this->currentName]->readTemplatesFromFile( $this->config->getData() );
				break;
		}
	}
}
?>