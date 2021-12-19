<?PHP
/**
*	patConfiguration
*	Class to read XML config files
*
*	@access		public
*	@version	1.6
*	@author		Stephan Schmidt <schst@php-tools.de>
*	@package	patConfiguration
*/
	class	patConfiguration
{
/**
*	information about the project
*	@var	array	$systemVars
*/
	var	$systemVars		=	array(
									"appName"		=>	"patConfiguration",
									"appVersion"	=>	"1.6",
									"author"		=>	array(
															"Stephan Schmidt <schst@php-tools.de>"
															)
								);

/**
*	table used for translation of xml special chars
*	@var	array	$xmlSpecialchars
*/
	var	$xmlSpecialchars	=	array(
										"&"		=>	"&amp;",
										"'"		=>	"&apos;",
										"\""	=>	"&quot;",
										"<"		=>	"&lt;",
										">"		=>	"&gt;"
									);
/**
*	current path as array
*	@var	array	$path
*/
	var	$path		=	array();

/**
*	array that stores configuration
*	@var	array	$conf
*/
	var	$conf		=	array();

/**
*	array that stores configuration from the current file
*	@var	array	$currentConf
*/
	var	$currentConf=	array();

/**
*	array that stores extensions
*	@var	array	$extensions
*/
	var	$extensions	=	array();

/**
*	array that stores all xml parsers
*	@var	array	$parsers
*/
	var	$parsers	=	array();

/**
*	stack of the namespaces
*	@var	array	$nsStack
*/
	var	$nsStack	=	array();

/**
*	stack for tags that have been found
*	@var	array	$tagStack
*/
	var	$tagStack	=	array();

/**
*	stack of values
*	@var	array	$valStack
*/
	var	$valStack	=	array();

/**
*	current depth of the stored values, i.e. array depth
*	@var	int	$valDepth
*/
	var	$valDepth	=	1;

/**
*	current CDATA found
*	@var	string	$data
*/
	var	$data		=	array();
	
/**
*	directory where include files are located
*	@var	string	$includeDir
*/
	var	$includeDir		=	"";
	
/**
*	directory where cache files are located
*	@var	string	$cacheDir
*/
	var	$cacheDir		=	"cache";
	
/**
*	list of all files that were needed
*	@var	array	$externalFiles
*/
	var	$externalFiles		=	array();
	
/**
*	all open files
*	@var	array	$xmlFiles
*/
	var	$xmlFiles			=	array();
	
/**
*	treatment of whitespace
*	@var	string	$whitespace
*/
	var	$whitespace			=	array( "default" );

/**
*	error handling: return|die|trigger_error
*	@var	string	$errorHandling
*/
	var	$errorHandling		=	"return";

/**
*	errors that occured while processing
*	@var	array	$errors
*/
	var	$errors				=	array();

/**
*	encoding of the XML files
*	@var	string	$encoding	
*/
	var	$encoding	=	"ISO-8859-1";
	
/**
*	list of defined tags
*	@var	array	$definedTags
*/	
	var	$definedTags		=	array();

/**
*	current namespace for define
*	@var	string	$currentNamespace
*/	
	var	$currentNamespace	=	"_none";

/**
*	current tag for define
*	@var	string	$currentTag
*/	
	var	$currentTag			=	false;

/**
*	stack for define tags
*	@var	array	$defineStack
*/
	var	$defineStack		=	array();
	
/**
*	constructor
*
*	@access	public
*	@param	array	$options
*/
	function	patConfiguration( $options = array() )
	{
		$this->_construct( $options );
	}
	
/**
*	constructor for PHP 5
*
*	@access	public
*	@param	array	$options
*/
	function	_construct( $options = array() )
	{
		if( isset( $options["configDir"] ) )
			$this->setConfigDir( $options["configDir"] );

		if( isset( $options["includeDir"] ) )
			$this->setIncludeDir( $options["includeDir"] );

		if( isset( $options["cacheDir"] ) )
			$this->setCacheDir( $options["cacheDir"] );

		if( isset( $options["errorHandling"] ) )
			$this->setErrorHandling( $options["errorHandling"] );

		if( isset( $options["encoding"] ) )
			$this->setEncoding( $options["encoding"] );

		if( isset( $options["definedTags"] ) )
			$this->setDefinedTags( $options["definedTags"] );
	}
	
/**
*	set the error handling
*
*	@access	public
*	@param	string	$errorHandling	trigger_error|die|return
*	@param	mixed	$options		not yet implemented
*/
	function	setErrorHandling( $errorHandling, $options = NULL )
	{
		$this->errorHandling	=	$errorHandling;
	}
	
/**
*	set the XML encoding
*
*	@access	public
*	@param	string	$encoding
*/
	function	setEncoding( $encoding )
	{
		$this->encoding	=	$encoding;
	}
	
/**
*	set defined tags
*
*	@access	public
*	@param	array	$definedTags
*/
	function	setDefinedTags( $tags, $ns = NULL )
	{
		if( $ns == NULL )
			$this->definedTags	=	$tags;
		else
			$this->definedTags[$ns]	=	$tags;
	}
	
/**
*	set the directory, where all xml config files are stored
*
*	@access	public
*	@param	string	$configDir	name of the directory
*/
	function	setConfigDir( $configDir )
	{
		$this->configDir	=	$configDir;
	}
	
/**
*	set the directory, where all extensions are stored
*
*	@access	public
*	@param	string	$includeDir	name of the directory
*/
	function	setIncludeDir( $includeDir )
	{
		$this->includeDir	=	$includeDir;
	}

/**
*	set the directory, where all cache files are stored
*
*	@access	public
*	@param	string	$cacheDir	name of the directory
*/
	function	setCacheDir( $cacheDir )
	{
		$this->cacheDir	=	$cacheDir;
	}
	
/**
*	load a configuration from a cache
*	if cache is not valid, it will be updated automatically
*
*	@access	public
*	@param	string	$file	name of config file
*	@param	string	$mode	mode of the parsing ( "w" = overwrite old config, "a" = append to config )
*/	
	function	loadCachedConfig( $file, $mode = "w" )
	{
		$this->currentConf		=	array();
		$this->externalFiles	=	array();

		//	clear old values
		if( $mode == "w" )
			$this->conf		=	array();

		//	get full path
		$file	=	( $this->configDir!="" ) ? $this->configDir."/".$file : $file; 

		if( $result	=	$this->loadFromCache( $file ) )
		{
			$this->conf		=	array_merge( $this->conf, $result );
		}
		else
		{
			if( !$this->parseXMLFile( $file ) )
			{
				return	false;
			}

			$this->writeCache( $file, $this->currentConf, $this->externalFiles );
		}
		return	true;
	}

/**
*	parse a configuration file
*
*	@access	public
*	@param	string	$file	name of the configuration file
*	@param	string	$mode	mode of the parsing ( "w" = overwrite old config, "a" = append to config )
*/	
	function	parseConfigFile( $file, $mode = "w" )
	{
		$this->path				=	array();
		$this->externalFiles	=	array();
		$this->currentConf		=	array();

		if( $mode == "w" )
			$this->conf		=	array();

		$file			=	( $this->configDir!="" ) ? $this->configDir."/".$file : $file; 

		if( !$this->parseXMLFile( $file ) )
			return	false;

		return	true;
	}

/**
*	load cache
*
*	@access	private
*	@param	string	$file	filename
*	@return	mixed	$result	config on success, false otherwise
*/
	function	loadFromCache( $file )
	{
		$cacheFile	=	$this->cacheDir . "/" . md5( $file ) . ".cache";

		if( !file_exists( $cacheFile ) )
			return	false;

		$cacheTime		=	filemtime( $cacheFile );

		if( filemtime( $file ) > $cacheTime )
			return	false;

		if( !$fp = @fopen( $cacheFile, "r" ) )
			return	false;
			
		$result		=	false;
		flock( $fp, LOCK_SH );
		while( !feof( $fp ) )
		{
			$line	=	trim( fgets( $fp, 4096 ) );
			list( $action, $param )	=	explode( "=", $line, 2 );

			switch( $action )
			{
				case	"checkFile":
					if( filemtime( $param ) > $cacheTime )
					{
						flock( $fp, LOCK_UN );
						fclose( $fp );
						return	false;
					}
					break;
				case	"startCache":
					$result		=	unserialize( fread( $fp, filesize( $cacheFile ) ) );
					break 2;
				default:
					flock( $fp, LOCK_UN );
					fclose( $fp );
					return	false;
					break;
			}
		}
		flock( $fp, LOCK_UN );
		fclose( $fp );
		return	$result;
	}
	
/**
*	write cache
*
*	@access	private
*	@param	string	$file	filename
*	@param	array	$config	configuration
*	@param	array	$externalFiles	list of files used
*/
	function	writeCache( $file, $config, $externalFiles )
	{
		$cacheData	=	serialize( $config );
		$cacheFile	=	$this->cacheDir . "/" . md5( $file ) . ".cache";
		
		$fp			=	@fopen( $cacheFile, "w" );
		if( !$fp )
		{
			$this->_raiseError( "writeCache", "Could not write cache file in cache directory {$this->cacheDir}." );
			return	false;
		}
		flock( $fp, LOCK_EX );

		$cntFiles	=	count( $externalFiles );
		for( $i = 0; $i < $cntFiles; $i++ )
			fputs( $fp, "checkFile=".$externalFiles[$i]."\n" );

		fputs( $fp, "startCache=yes"."\n" );
		fwrite( $fp, $cacheData );
		flock( $fp, LOCK_UN );
		fclose( $fp );
		
		$oldMask	=	umask( 0000 );
		chmod( $cacheFile, 0666 );
		umask( $oldMask );
		
		return	true;
	}
	
/**
*	write a configfile
*	format may be php or xml
*
*	@access	public
*	@param	string	$filename	name of the configfile
*	@param	string	$format		format of the config file (xml or php)
*	@param	array	$options	available options for php: varname => anyString ; available options for xml: mode => pretty
*/
	function	writeConfigFile( $filename, $format = "xml", $options = array() )
	{
		switch( $format )
		{
			case	"php":
				$content	=	$this->buildPHPConfigFile( $options );
				break;
			default:
				$content	=	$this->buildXMLConfigFile( $options );
				break;
		}
		if( $content )
		{
			$file	=	( $this->configDir!="" ) ? $this->configDir."/".$filename : $filename; 
			$fp		=	fopen( $file, "w" );
			if( $fp )
			{
				flock( $fp, LOCK_EX );
				fputs( $fp, $content );
				flock( $fp, LOCK_UN );
				fclose( $fp );
				$oldMask	=	umask( 0000 );
				chmod( $file, 0666 );
				umask( $oldMask );
			}
		}
	}

/**
*	create an xml representation of the current config
*
*	@access	private
*	@return	string	$xml	xml representation
*/
	function	buildXMLConfigFile( $options )
	{
		$this->openTags		=	array();

		$config				=	$this->conf;
		ksort( $config );
		reset( $config );
		
		if( $options["mode"] == "pretty" )
			$options["nl"]		=	"\n";
		else
			$options["nl"]		=	"";

		$options["depth"]		=	0;
		
		$xml		=	"<?xml version=\"1.0\" encoding=\"{$this->encoding}\"?>\n";
		$xml		.=	"<configuration>".$options["nl"];
		$options["depth"]++;
		
		while( list( $key, $value ) = each( $config ) )
		{
			$path	=	explode( ".", $key );

			switch( count( $path ) )
			{
				case	0:
					$this->_raiseError( "buildXMLConfigFile", "configValue without name found!" );
					break;
				default:
					$openNew		=	array();
					$tag			=	array_pop( $path );
					$start			=	max( count( $path ), count( $this->openTags ) );
					
					for( $i=( $start-1 ); $i>=0; $i-- )
					{
						if( !isset( $this->openTags[$i] ) || $path[$i] != $this->openTags[$i] )
						{
							if( count( $this->openTags ) > 0 )
							{
								array_pop( $this->openTags );
								$options["depth"]--;
								if( $options["mode"] == "pretty" )
									$xml	.=	str_repeat( "\t", $options["depth"] );
								$xml	.=	"</path>".$options["nl"];
							}
								
							if( isset( $path[$i] ) )
							{
								array_push( $openNew, $path[$i] );
							}

						}
						
					}
							
					while( $path = array_pop( $openNew ) )
					{
						array_push( $this->openTags, $path );
						$xml	.=	str_repeat( "\t", $options["depth"] );
						$xml	.=	"<path name=\"".$path."\">".$options["nl"];
						$options["depth"]++;
					}

					$xml	.=	$this->createTag( $tag, $value, $options );
					
					break;
			}
		}

		//	close all open tags
		while( $open = array_pop( $this->openTags ) )
		{
			$options["depth"]--;
			$xml	.=	str_repeat( "\t", $options["depth"] );
			$xml	.=	"</path>".$options["nl"];
		}
		$xml		.=	"</configuration>";

		return	$xml;
	}

/**
*	create configValue tag
*
*	@access	private
*	@param	string	$name 	name attribute of the tag
*	@param	mixed	$value 	value of the tag
*	@return	string	$tag	xml representation of the tag
*/
	function	createTag( $name, $value, $options )
	{
		$atts	=	array();
		if( $name !== NULL )
			$atts["name"]	=	$name;

		if( is_bool( $value ) )
		{
			$atts["type"]	=	"bool";
			$value			=	$value ? "true" : "false";
		}
		elseif( is_float( $value ) )
			$atts["type"]	=	"float";
		elseif( is_int( $value ) )
			$atts["type"]	=	"int";
		elseif( is_array( $value ) )
			$atts["type"]	=	"array";
		elseif( is_string( $value ) )
			$atts["type"]	=	"string";

		$tag	=	"";
		if( $options["mode"] == "pretty" )
			$tag	.=	str_repeat( "\t", $options["depth"] );
		$tag	.=	"<configValue";

		if( is_array( $atts ) )
		{
			reset( $atts );
			while( list( $att, $val ) = each( $atts ) )
				$tag	.=	" ".$att."=\"".$val."\"";
		}
		
		if( !$value )
		{
			$tag	.=	"/>".$options["nl"];
		}
		else
		{
			$tag	.=	">";

			if( is_array( $value ) )
			{
				$options["depth"]++;

				reset( $value );
				$tag	.=	$options["nl"];
				foreach( $value as $key => $val )
				{
					if( is_int( $key ) )
						$key	=	NULL;
						
					$tag	.=	$this->createTag( $key, $val, $options );
				}

				$options["depth"]--;
				if( $options["mode"] == "pretty" )
					$tag	.=	str_repeat( "\t", $options["depth"] );
			}
			else
				$tag	.=	$this->replaceXMLSpecialchars( $value );

			$tag	.=	"</configValue>".$options["nl"];
		}
		return	$tag;
	}

/**
*	create a php representation of the current config
*
*	@access	private
*	@return	string	$php	php representation
*/
	function	buildPHPConfigFile( $options )
	{
		$varname			=	isset( $options["varname"] ) ? $options["varname"] : "config";

		$config				=	$this->conf;
		ksort( $config );
		reset( $config );

		$php		=	"<?PHP\n// Configuration generated by patConfiguration v".$this->systemVars["appVersion"]."\n";
		$php		.=	"// (c) ".implode( ",", $this->systemVars["author"] )."\n";
		$php		.=	"// download at http://www.php-tools.net\n\n";
		$php		.=	"\$".$varname." = array();\n";
		
		while( list( $key, $value ) = each( $config ) )
		{
			$php	.=	$this->getPHPConfigLine( "\$".$varname."[\"".$key."\"]", $value );
		}

		$php		.=	"?>";
		return	$php;
	}

/**
*	build one line in the php config file
*
*	@access	private
*	@param	string	$prefix		variable name and array index
*	@param	mixed	$value		value of the config option
*	@return	string	$line		on line of php code
*/
	function	getPHPConfigLine( $prefix, $value )
	{
		if( is_bool( $value ) )
			$value			=	$value ? "true" : "false";
		elseif( is_string( $value ) )
			$value			=	"\"".addslashes( $value )."\"";

		if( is_array( $value ) )
		{
			$line		=	$prefix." = array();\n";;
			reset( $value );
			while( list( $key, $val ) = each( $value ) )
			{
				if( !is_int( $key ) )
					$key	=	"\"".$key."\"";
				$line	.=	$this->getPHPConfigLine( $prefix."[".$key."]", $val );
			}
			return	$line;
		}
		else
			return	$prefix." = ".$value.";\n";
	}
	
/**
*	add an extension
*
*	@access	public
*	@param	object patConfigExtension	&$ext	extension that should be added
*	@param	string						$ns		namespace for this extension (if differs from default ns)
*/	
	function	addExtension( &$ext, $ns = "" )
	{
		if( $ns == "" )
			$ns	=	$ext->getDefaultNS();

		$ext->setConfigReference( $this );
			
		$this->extensions[$ns]	=	&$ext;
	}

/**
*	handle start element
*	if the start element contains a namespace calls the eppropriate handler
*	
*	@param	int		$parser		resource id of the current parser
*	@param	string	$name		name of the element
*	@param	array	$attributes	array containg all attributes of the element
*/
	function	startElement( $parser, $name, $attributes )
	{
		//	separate namespace and local name
		$tag	=	explode( ":", $name, 2 );

		if( count( $tag ) == 2 )
		{
			list( $ns, $name )	=	$tag;
		}
		else
			$ns					=	false;
		
		array_push( $this->tagStack, $name );
		array_push( $this->nsStack, $ns );
		
		$tagDepth				=	count( $this->tagStack );
		$this->data[$tagDepth]	=	NULL;
		
		//	inherit whitespace treatment
		if( !isset( $attributes["xml:space"] ) )
			$attributes["xml:space"]	=	$this->whitespace[( count( $this->whitespace ) - 1 )];

		//	store whitespace treatment
		array_push( $this->whitespace, $attributes["xml:space"] );
		
		//	check if namespace exists and an extension for the ns exists
		if( $ns !== false && isset( $this->extensions[$ns] ) )
		{
			$this->extensions[$ns]->startElement( $parser, $name, $attributes );
		}
		//	No namespace, or no extension set => handle internally
		else
		{
			switch( strtolower( $name ) )
			{
				//	configuration
				case	"configuration":
					break;

				//	define
				case	"define":
					//	type = string is default
					if( !isset( $attributes["type"] ) )
						$attributes["type"]		=	"string";

					//	use 'ns' or 'namespace'
					if( isset( $attributes["ns"] ) )
						$this->_defineNamespace( $attributes["ns"] );
					elseif( isset( $attributes["namespace"] ) )
						$this->_defineNamespace( $attributes["namespace"] );
						
					//	define a new tag
					elseif( isset( $attributes["tag"] ) )
						$this->_defineTag( $attributes );
					elseif( isset( $attributes["attribute"] ) )
						$this->_defineAttribute( $attributes );					
					break;

				case	"getconfigvalue":
					$this->appendData( $this->getConfigValue( $attributes["path"] ) );
					break;
					
				//	extension
				case	"extension":
					if( isset( $attributes["file"] ) )
					{
						$fpath	=	( $this->includeDir ) ? $this->includeDir."/".$attributes["file"] : $attributes["file"];
						if( !file_exists( $fpath ) )
						{
							$this->_raiseError( "startElement", "Could not include PHP file $fpath." );
						}
						else
							include_once( $fpath );
					}
					if( isset( $attributes["name"] ) )
					{
						if( class_exists( $attributes["name"] ) )
						{
							//	create new extension
							$ext	=	new	$attributes["name"];
	
							//	get namespace
							if( isset( $attributes["ns"] ) )
								$ns	=	$attributes["ns"];
							else
								$ns	=	$ext->getDefaultNS();
					
							//	add extension
							$ext->setConfigReference( $this );
							$this->extensions[$ns]	=	$ext;
						}
						else
							$this->_raiseError( "startElement", "Could not instantiate extension class for ".$attributes["name"]."." );
					}
					break;

				case	"xinc":
					$this->_xInclude( $attributes );					
					break;

				//	path
				case	"path":
					$this->addToPath( $attributes["name"] );
					break;

				//	Config Value Tag found
				case	"configvalue":
					//	store name and type of value
					$val	=	@array(	"type"		=>	$attributes["type"],
										"name"		=>	$attributes["name"] );
										
					$this->valDepth	=	array_push( $this->valStack, $val );
					break;

				//	any other tag found
				default:
					//	use default namespace, if no namespace is given
					if( $ns === false )
						$ns	=	"_none";
					
					//	check, whether the namespace has been defined.						
					if( !isset( $this->definedTags[$ns] ) )
					{
						$this->addToPath( $name );
						break;
					}

					//	check whether the tag has been defined 					
					if( !isset( $this->definedTags[$ns][$name] ) )
					{
						$this->addToPath( $name );
						break;
					}
	
					$def		=	$this->definedTags[$ns][$name];
					$type		=	$def["type"];
					$tagName	=	$def["name"];
					
					if( $tagName == "_attribute" )
					{
						$tagName	=	$attributes[$def["nameAttribute"]];
					}
						
					//	store name and type of value
					$val	=	array(	"type"		=>	$type,
										"name"		=>	$tagName
									);
					
					//	check for attributes
					if( isset( $def["attributes"] ) && is_array( $def["attributes"] ) )
					{
						//	value must be an array
						$value	=	array();
						//	check, which attributes exist
						foreach( $def["attributes"] as $name => $attDef )
						{
							if( isset( $attributes[$name] ) )
								$value[$name]	=	$this->convertValue( $attributes[$name], $attDef["type"] );
							elseif( isset( $attDef["default"] ) )
								$value[$name]	=	$this->convertValue( $attDef["default"], $attDef["type"] );
						}
						$val["value"]	=	$value;
					}
					
					$this->valDepth	=	array_push( $this->valStack, $val );
					break;
			}
		}
	}

/**
*	include an xml file or directory
*
*	@access	private
*	@param	array	$options
*/
	function	_xInclude( $options )
	{
		//	include a single file
		if( isset( $options["href"] ) )
		{
			$file		=	$this->getFullPath( $options["href"] );
			if( $file === false )
				return	false;
			array_push( $this->externalFiles, $file );
			$this->parseXMLFile( $file );
		}
		//	include a directory
		elseif( isset( $options["dir"] ) )
		{
			if( !isset( $options["extension"] ) )
				$options["extension"]	=	"xml";

			$dir		=	$this->getFullPath( $options["dir"] );
			if( $dir === false )
				return 	false;
			$files		=	$this->getFilesInDir( $dir, $options["extension"] );
			reset( $files );
			foreach( $files as $file )
			{
				array_push( $this->externalFiles, $file );
				$this->parseXMLFile( $file );
			}
		}
		return	true;
	}
		
/**
*	define a new namespace
*
*	@access	private
*	@param	string	$namespace
*/
	function	_defineNamespace( $namespace )
	{
		array_push( $this->defineStack, "ns" );
		if( isset( $this->definedTags[$namespace] ) )
		{
			$line	=	$this->_getCurrentLine();
			$file	=	$this->_getCurrentFile();
			$this->_raiseError( "_defineNamespace", "Cannot redefine namespace '$namespace' on line $line in $file." );
			$this->currentNamespace		=	false;
			return	false;
		}
		$this->definedTags[$namespace]	=	array();
		$this->currentNamespace			=	$namespace;
		return	true;
	}
	
/**
*	define a new tag
*
*	@access	private
*	@param	array	$attributes
*/
	function	_defineTag( $attributes )
	{
		array_push( $this->defineStack, "tag" );
		if( $this->currentNamespace === false )
			return	false;

		$ns		=	$this->currentNamespace;

		$tag	=	$attributes["tag"];
		if( !isset( $attributes["name"] ) )
		{
			$tagName		=	$attributes["tag"];
			$nameAttribute	=	NULL;
		}
		else
		{
			switch( $attributes["name"] )
			{
				case	"_none":
					$tagName		=	NULL;
					$nameAttribute	=	NULL;
					break;
				case	"_attribute":
					$tagName		=	"_attribute";
					$nameAttribute	=	$attributes["attribute"];
					break;
				default:
					$tagName		=	$attributes["name"];
					$nameAttribute	=	NULL;
					break;
			}
		}

		$this->definedTags[$this->currentNamespace][$tag]		=	array(
																		"type"	=>	$attributes["type"],
																		"name"	=>	$tagName
																		);
		if( $nameAttribute != NULL )
			$this->definedTags[$this->currentNamespace][$tag]["nameAttribute"]	=	$nameAttribute;

		$this->currentTag	=	$tag;
		return	true;
	}

/**
*	define a new attribute
*
*	@access	private
*	@param	array	$attributes
*/
	function	_defineAttribute( $attributes )
	{
		array_push( $this->defineStack, "attribute" );
		if( $this->currentNamespace === false )
			return	false;
		if( $this->currentTag === false )
		{
			$line	=	$this->_getCurrentLine();
			$file	=	$this->_getCurrentFile();
			$this->_raiseError( "_defineAttribute", "Cannot define attribute outside a tag on line $line in $file." );
			$this->currentNamespace		=	false;
			return	false;
		}

		$ns		=	$this->currentNamespace;
		$tag	=	$this->currentTag;
		
		if( !isset( $this->definedTags[$ns][$tag]["attributes"] ) )
			$this->definedTags[$ns][$tag]["attributes"]	=	array();
						
		$this->definedTags[$ns][$tag]["attributes"][$attributes["attribute"]]	=	array(
																							"type"	=>	$attributes["type"]
																						);

		if( isset( $attributes["default"] ) )
			$this->definedTags[$ns][$tag]["attributes"][$attributes["attribute"]]["default"]		=	$attributes["default"];

		return	true;
	}
	
/**
*	handle end element
*	if the end element contains a namespace calls the eppropriate handler
*	
*	@param	int		$parser		resource id of the current parser
*	@param	string	$name		name of the element
*/
	function	endElement( $parser, $name )
	{
		//	remove whitespace treatment from stack
		$whitespace			=	array_pop( $this->whitespace );

		//	get the data of the current tag
		$tagDepth			=	count( $this->tagStack );

		$this->currentData	=	$this->data[$tagDepth];
		
		switch( $whitespace )
		{
			case	"preserve":
				break;
			case	"strip":
				$this->currentData	=	trim( preg_replace( "/\s\s*/", " ", $this->currentData ) );
				break;
			case	"default":
			default:
				$this->currentData	=	trim( $this->currentData );
				break;
		}
		
		//	delete the data before returning it
		$this->data[$tagDepth]	=	"";

		//	remove namespace from stack
		$ns				=	array_pop( $this->nsStack );
		//	remove tag from stack
		$name			=	array_pop( $this->tagStack );
		
		//	check if namespace exists and an extension for the ns exists
		if( $ns !== false && isset( $this->extensions[$ns] ) )
		{
			$this->extensions[$ns]->endElement( $parser, $name );
		}
		//	No namespace => handle internally
		else
		{
			switch( strtolower( $name ) )
			{
				//	configuration / extension
				case	"configuration":
				case	"getconfigvalue":
				case	"extension":
					break;

				case	"define":
					$mode	=	array_pop( $this->defineStack );
					switch( $mode )
					{
						case	"ns":
							$this->currentNamespace	=	"_none";
							break;
						case	"tag":
							$this->currentTag		=	false;
							break;	
					}
					break;

				//	path
				case	"path":
					$this->removeLastFromPath();
					break;

				//	config value
				case	"configvalue":
					//	get last name and type
					$val	=	array_pop( $this->valStack );
									
					//	decrement depth, as one tag was removed from
					//	stack
					$this->valDepth--;

					//	if no value was found (e.g. other tags inside)
					//	use CDATA that was found between the tags
					if( !isset( $val["value"] ) )
						$val["value"]	=	$this->getData();
						
					$this->setTypeValue( $val["value"], $val["type"], $val["name"] );
					break;

				//	Any other tag
				default:
					//	use default namespace, if no namespace is given
					if( $ns === false )
						$ns	=	"_none";
					
					//	check, whether the namespace has been defined.						
					if( !isset( $this->definedTags[$ns] ) )
					{
						//	if data was found => store it
						if( $data = $this->getData() )
							$this->setTypeValue( $data );

						//	shorten path
						$this->removeLastFromPath();
						break;
					}

					//	check whether the tag has been defined 					
					if( !isset( $this->definedTags[$ns][$name] ) )
					{
						//	if data was found => store it
						if( $data = $this->getData() )
							$this->setTypeValue( $data );

						//	shorten path
						$this->removeLastFromPath();
						break;
					}
	
					//	get last name and type
					$val	=	array_pop( $this->valStack );
										
					//	decrement depth, as one tag was removed from
					//	stack
					$this->valDepth--;
	
					//	if no value was found (e.g. other tags inside)
					//	use CDATA that was found between the tags
					if( !isset( $val["value"] ) )
						$val["value"]	=	$this->getData();
							
					$this->setTypeValue( $val["value"], $val["type"], $val["name"] );
					break;		
			}
		}
	}
	
/**
*	handle character data
*	if the character data was found between tags using namespaces, the appropriate namesapce handler will be called
*	
*	@param	int		$parser		resource id of the current parser
*	@param	string	$data		character data, that was found		
*/
	function	characterData( $parser, $data )
	{
		$tagDepth	=	count( $this->tagStack ); 	

		if( !isset( $this->data[$tagDepth] ) )
			$this->data[$tagDepth]	=	"";
			
		$this->data[$tagDepth]	.=	$data;
	}

/**
*	add element to path
*
*	@access	private
*	@param	string	$key	element that should be appended to path
*/
	function	addToPath( $key )
	{
		array_push( $this->path, $key );
	}
	
/**
*	remove last element from path
*
*	@access	private
*/
	function	removeLastFromPath()
	{
		array_pop( $this->path );
	}

/**
*	set value for the current path
*
*	@access	private
*	@param	mixed	$value	value that should be set
*/
	function	setValue( $value )
	{
		$string	=	implode( ".", $this->path );
		$this->conf[$string]			=	$value;

		$this->currentConf[$string]		=	$value;
	}

/**
*	returns the current data between the open tags
*	data can be anything, from strings, to arrays or objects
*
*	@access	private
*	@return	mixed	$value	data between text
*/
	function	getData( $whitespace = "preserve" )
	{
		return	$this->currentData;
	}

/**
*	append Data to the current data
*
*	@param	mixed	$data	data to be appended
*/
	function	appendData( $data ) 
	{
		$tagDepth	=	count( $this->tagStack ) - 1;
		if( !isset( $this->data[$tagDepth] ) )
			$this->data[$tagDepth]	=	"";
		if( is_string( $this->data[$tagDepth] ) )
		{
			//	append string
			if( is_string( $data ) )
				$this->data[$tagDepth]		.=		$data;
			else
				$this->data[$tagDepth]		=		array( $this->data[$tagDepth], $data );
		}
		elseif( is_array( $this->data[$tagDepth] ) )
		{
			//	append string
			if( is_array( $data ) )
				$this->data[$tagDepth]	=	array_merge( $this->data[$tagDepth], $data );
			else
				array_push( $this->data[$tagDepth], $data );
		}
		else
			$this->data[$tagDepth]			=		$data;	
	}
	
/**
*	convert a value to a certain type ans set it for the current path
*
*	@access	private
*	@param	mixed	$value	value that should be set
*	@param	string	$type	type of the value (string, bool, integer, double)
*/
	function	setTypeValue( $value, $type = "leave", $name = "" )
	{
		//	convert value
		$value	=	$this->convertValue( $value, $type );

		//	check, if there are parent values
		//	insert current value into parent array
		if( count( $this->valStack ) > 0 )
		{
			if( $name )
				$this->valStack[($this->valDepth-1)]["value"][$name]	=	$value;
			else
				$this->valStack[($this->valDepth-1)]["value"][]			=	$value;
		}

		//	No valuestack
		else
		{
			if( $this->nsStack[( count( $this->nsStack )-1 )] )
				$this->appendData( $value );
			else
			{
				if( $name )
					$this->addToPath( $name );
	
				$this->setValue( $value );
	
				if( $name )
					$this->removeLastFromPath();
			}
		}
	}

/**
*	convert a string variable to any type
*
*	@access	private
*	@param	string	$value	value that should be converted
*	@param	string	$type	type of the value (string, bool, integer, double)
*	@return	mixed	$value
*/	
	function	convertValue( $value, $type = "string" )
	{
		switch( $type )
		{
			//	string
			case	"string":
				settype( $value, "string" );
				break;

			//	boolean
			case	"boolean":
			case	"bool":
				if( $value == "true" || $value == "yes" || $value == "on" )
					$value	=	true;
				else
					$value	=	false;
				break;

			//	integer
			case	"integer":
			case	"int":
				settype( $value, "integer" );
				break;

			//	double
			case	"float":
			case	"double":
				settype( $value, "double" );
				break;

			//	array
			case	"array":
				if( !is_array( $value ) )
				{
					if( trim( $value ) )
						$value	=	array( $value );
					else
						$value	=	array();
				}
				break;
		}
		return	$value;
	}
	
/**
*	returns a configuration value
*	if no path is given, all config values will be returnded in an array
*
*	@access	public
*	@param	string	$path	path, where the value is stored
*	@return	mixed	$value	value
*/
	function	getConfigValue( $path = "" )
	{
		if( $path == "" )
			return	$this->conf;

		if( strstr( $path, "*" ) )
		{
			$path		=	str_replace( ".", "\.", $path )."$";
			$path		=	"^".str_replace( "*", ".*", $path )."$";
			$values		=	array();
			reset( $this->conf );
			while( list( $key, $value ) = each( $this->conf ) )
			{
				if( eregi( $path, $key ) )
					$values[$key]	=	$value;
			}
			return	$values;
		}

		//	check wether a value of an array was requested
		if( $index	= strrchr( $path, "[" ) )
		{
			$path		=	substr( $path, 0, strrpos( $path, "[" ) );
			$index		=	substr( $index, 1, ( strlen( $index ) - 2 ) );
			$tmp		=	$this->getConfigValue( $path );
			
			return	$tmp[$index];
		}
		
		if( isset( $this->conf[$path] ) )
			return	$this->conf[$path];
		
		return	false;
	}
	
/**
*	set a config value
*	*
*	@access	public
*	@param	string	$path	path, where the value will be stored
*	@param	mixed	$value	value to store
*/
	function	setConfigValue( $path, $value, $type = "leave" )
	{
		$this->conf[$path]			=	$this->convertValue( $value, $type );
		$this->currentConf[$path]	=	$this->convertValue( $value, $type );
	}
	
/**
*	sets several config values
*
*	@access	public
*	@param	array	$values		assoc array containg paths and values
*/
	function	setConfigValues( $values )
	{
		if( !is_array( $values ) )
			return	false;
		reset( $values );
		while( list( $path, $value ) = each( $values ) )
			$this->setConfigValue( $path, $value );
	}
	
/**
*	clears a config value
*	if no path is given, the complete config will be cleared
*
*	@access	public
*	@param	string	$path	path, where the value is stored
*/
	function	clearConfigValue( $path = "" )
	{
		if( $path == "" )
		{
			$this->conf		=	array();
			return	true;
		}
		
		if( strstr( $path, "*" ) )
		{
			$path		=	str_replace( ".", "\.", $path )."$";
			$path		=	"^".str_replace( "*", ".*", $path )."$";
			$values		=	array();
			reset( $this->conf );
			while( list( $key, $value ) = each( $this->conf ) )
			{
				if( eregi( $path, $key ) )
					unset( $this->conf[$key] );
			}
			return	true;
		}

		if( !isset( $this->conf[$path] ) )
			return	false;
			
		unset( $this->conf[$path] );
		return	true;
	}


/*
*	parse an external entity
*
*	@param	int		$parser				resource id of the current parser
*	@param	string	$openEntityNames	space-separated list of the names of the entities that are open for the parse of this entity (including the name of the referenced entity)
*	@param	string	$base				currently empty string
*	@param	string	$systemId			system identifier as specified in the entity declaration
*	@param	string	$publicId			publicId, is the public identifier as specified in the entity declaration, or an empty string if none was specified; the whitespace in the public identifier will have been normalized as required by the XML spec
*/

	function	externalEntity( $parser, $openEntityNames, $base, $systemId, $publicId )
	{
		if( $systemId )
		{
			$file	=	( $this->configDir!="" ) ? $this->configDir."/".$systemId : $systemId; 
			array_push( $this->externalFiles, $file );
			$this->parseXMLFile( $file );
		}
		return	true;
	}

/**
*	calculates the full path of a file that should be included
*
*	@access	private
*	@param	string	$path
*	@return	string	$fullPath
*/
	function	getFullPath( $path )
	{
		if( strncmp( $path, "/", 1 ) != 0 )
		{
			if( !empty( $this->xmlFiles ) )
			{
				$currentFile	=	$this->xmlFiles[( count( $this->xmlFiles ) - 1 )];
				$fullPath		=	dirname( $currentFile ) . "/" . $path;
			}
		}
		//	absolute path
		else
		{
			$path		=	substr( $path, 1 );

			if( !empty( $this->configDir ) )
				$fullPath	=	$this->configDir."/". $path;
			else
				$fullPath	=	$path;
		}
		
		$realPath	=	realpath( $fullPath );
		if( empty( $realPath ) )
		{
			$this->_raiseError( "getFullPath", "Could not resolve full path for path: '".$path."' - please check the path syntax." );
			return	false;
		}
		
		return	$realPath;
	}

/**
*	get all files in a directory
*
*	@access	private
*	@param	string	$dir
*	@param	string	$ext	file extension
*/
	function	getFilesInDir( $dir, $ext )
	{
		$files	=	array();
		if( !$dh = dir( $dir ) )
			return	$files;
			
		while( $entry = $dh->read() )
		{
			if( $entry == "." || $entry == ".." )
				continue;
			if( is_dir( $dir . "/" . $entry ) )
				continue;
			if( strtolower( strrchr( $entry, "." ) ) != ".".$ext )
				continue;
			array_push( $files, $dir. "/" . $entry );
		}

		return	$files;
	}
	
/**
*	parse an external xml file
*
*	@param	string	$file	filename, without dirname
*/

	function	parseXMLFile( $file )
	{
		$parserCount					=	count( $this->parsers );
		$this->parsers[$parserCount]	=	$this->createParser();
		
		if( !( $fp = @fopen( $file, "r" ) ) )
		{
			$this->_raiseError( "parseXMLFile", "Could not open XML file '".$file."'." );
			return	false;
		}

		array_push( $this->xmlFiles, $file );

		flock( $fp, LOCK_SH );

		while( $data = fread( $fp, 4096 ) )
		{
		    if ( !xml_parse( $this->parsers[$parserCount], $data, feof( $fp ) ) )
			{
				$message	=	sprintf(	"XML error: %s at line %d in file $file",
											xml_error_string( xml_get_error_code( $this->parsers[$parserCount] ) ),
											xml_get_current_line_number( $this->parsers[$parserCount] ) );

				array_pop( $this->xmlFiles );
		
				flock( $fp, LOCK_UN );
				xml_parser_free( $this->parsers[$parserCount] );

				$this->_raiseError( "parseXMLFile", $message );
				return	false;
    		}
		}

		array_pop( $this->xmlFiles );
		
		flock( $fp, LOCK_UN );
		xml_parser_free( $this->parsers[$parserCount] );
		return	true;
	}

/**
*	get the current xml parser object
*
*	@access	private
*	@return	resource	$parser
*/
	function	&_getCurrentParser()
	{
		$parserCount					=	count( $this->parsers ) - 1;
		return	$this->parsers[$parserCount];
	}
	
/**
*	get the current line number
*
*	@access	private
*	@return	int	$line
*/
	function	_getCurrentLine()
	{
		$parser	=	&$this->_getCurrentParser();
		$line	=	xml_get_current_line_number( $parser );
		return	$line;
	}

/**
*	get the current file
*
*	@access	private
*	@return	string $file
*/
	function	_getCurrentFile()
	{
		$file	=	$this->xmlFiles[( count( $this->xmlFiles )-1 )];
		return	$file;
	}

/**
*	create a parser
*
*	@return	object	$parser
*/
	function	createParser()
	{
		//	init XML Parser
		$parser	=	xml_parser_create( $this->encoding );
		xml_set_object( $parser, $this );
		xml_set_element_handler( $parser, "startElement", "endElement" );
		xml_set_character_data_handler( $parser, "characterData" );
		xml_set_external_entity_ref_handler( $parser, "externalEntity" );

		xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, false );

		return	$parser;
	}
	
	
/**
*	replace XML special chars
*
*	@param	string	$string		string, where special chars should be replaced
*	@param	array	$table		table used for replacing
*	@return	string	$string		string with replaced chars
*/

	function	replaceXMLSpecialchars( $string, $table = array() )
	{
		if( empty( $table ) )
			$table	=	&$this->xmlSpecialchars;

		$string		=	strtr( $string, $table );

		return	$string;
	}

/**
*	trigger an internal error
*
*	@access	private
*	@param	string	$method 	method in which the error occured
*	@param	string	$message	error message
*/
	function	_raiseError( $method, $message, $type = E_USER_ERROR )
	{
		switch( $this->errorHandling )
		{
			case	"trigger_error":
				trigger_error( "Error (patConfiguration::$method): $message", $type );
				break;
			case	"die":
				die( "Error (patConfiguration::$method): $message" );
				break;
			case	"nice_die":
				$this->niceDie( $method, $message );
				break;
			case	"return":
				if( function_exists( "debug_backtrace" ) )
				{
					$debug	=	debug_backtrace();
				}
				else
				{
					$debug	=	"n/a";
				}
				array_push( $this->errors, array(
													"method"	=>	$method,
													"message"	=>	$message,
													"debug"		=>	$debug
												 )
						);
				break;
		}
		return	false;
	}

/**
*	returns error codes that happened while processing
*
*	@access	public
*	@return	array	$errors
*/
	function	getErrors()
	{
		$errors			=	$this->errors;
		$this->errors	=	array();
		return	$errors;
	}

/**
*	generates a "nice" variant of die() with a few more interesting infos
*
*	@param	string	$method		method in which the error occurred
*	@param	string	$message	the error message to display
*/
	function	niceDie( $method, $message )
	{
		echo '<html><head><style>.text{font-family:verdana;color:#000000;font-size:12px;letter-spacing:-1px;}</style></head><body class="text">';
		echo '<b class="text">patConfiguration Error:</b><p>';
		echo '<table cellpadding="1" cellspacing="0" border="0">';
		echo '	<tr>';
		echo '		<td class="text"><b>Function</b></td>';
		echo '		<td class="text">&nbsp;:&nbsp;</td>';
		echo '		<td class="text">'.$method.'</td>';
		echo '	</tr>';
		echo '	<tr valign="top">';
		echo '		<td class="text"><b>Error</b></td>';
		echo '		<td class="text">&nbsp;:&nbsp;</td>';
		echo '		<td class="text">'.$message.'</td>';
		echo '	</tr>';
		echo '</table>';
		echo '</div></body></html>';
		exit;
	}
	
}
?>