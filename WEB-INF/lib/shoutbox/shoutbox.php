<?php
@ignore_user_abort(true);
@set_magic_quotes_runtime(0);

define ( 'SHOUTBOX_ROOT', 	str_replace ( '\\', '/', dirname(__FILE__) ) );
define ( 'SHOUTBOX_TPLDIR', 	SHOUTBOX_ROOT . '/templates/' );
define ( 'SHOUTBOX_DATA', 	SHOUTBOX_ROOT . '/data/' );

class ShoutboxTemplate
{
	var$_t='';var$_v=array();var$_par=false;
	function ShoutboxTemplate($t){if(!is_file($t))exit("The template file '$t' does not exist.");$this->_t=$t;}
	function set($n,$v='',$d=0){if(is_array($n))while(list($a,$b)=each($n))$this->_v[$a]=$b;else$this->_v[$n]=$v;if($d)$this->display();}
	function setr($n,&$v,$d=0){$this->_v[$n]=&$v;if($d)$this->display();}
	function display($r=0){while(list($k,)=each($this->_v))if(is_object($this->_v[$k]))$$k=$this->_v[$k]->display(1);else$$k=&$this->_v[$k];if($r){ob_start();include($this->_t);$x=ob_get_contents();ob_end_clean();return$x;}include$this->_t;}
}

class ShoutboxDB
{
	var$_d;var$_f;var$_p;
	function ShoutboxDB(){$this->_d=array();$this->_f='';$p=false;}
	function open($f,$c=false){if(!is_file($f)){return$c?$this->create($f):0;}$this->_p=@fopen($f,'ab+');if(!$this->_p||!flock($this->_p,LOCK_SH))return 0;include$f;$this->_f=$f;@set_file_buffer($this->_p,0);return 1;}
	function create($f){if(!touch($f))return 0;chmod($f,0777);return 1;}
	function remove($f){if(is_file($f)){return@unlink($f);}return 1;}
	function uset($f){unset($this->_d[$f]);}
	function set($f,$v=0){if(is_array($f)){if($v){$this->_d=$f;}else{while(list($k,$v)=each($f))$this->set($k,$v);}}else$this->_d[$f]=$v;}
	function append($v){$this->_d[]=$v;}
	function prepend($v){array_unshift($this->_d,$v);}
	function get($f){return isset($this->_d[$f])?$this->_d[$f]:exit("Field '$f' does not exist in ".$this->_f);}
	function all(){return $this->_d;}
	function count(){return count($this->_d);}
	function close(){if($this->_p)@fclose($this->_p);$this->ShoutboxDB();}
	function save(){$p=&$this->_p;if(!$p)exit("Can't save, no file opened.");$buf=sprintf("<?php \n\$this->_d=%s;\n?>",var_export($this->_d,1));if($p&&flock($p,LOCK_EX)){ftruncate($p,0);fseek($p,0);fwrite($p,$buf);fflush($p);fclose($p);}else exit ( 'Could not open ' . $this->_f . ' for writting.');}
}

class Shoutbox
{
	var $__GET;
	var $__POST;
	var $__COOKIE;
	var $_db;
	var $_configs;
	var $_admin_login;

	function Shoutbox ( $get, $post, $cookie )
	{
		// Load settings
		require_once SHOUTBOX_ROOT . '/configs.php';

		$this->__GET = $get;
		$this->__POST = $post;
		$this->__COOKIE = $cookie;

		$this->_db = new ShoutboxDB;
		// make sure required files exist, if not create
		if ( !file_exists ( SHOUTBOX_DATA . 'shouts_index.php' ) && !$this->_db->create ( SHOUTBOX_DATA . 'shouts_index.php' ) )
			return print 'Error creating the shouts index file.';
		if ( !file_exists ( SHOUTBOX_DATA . 'shouts_banned.php' ) && !$this->_db->create ( SHOUTBOX_DATA . 'shouts_banned.php' ) )
			return print 'Error creating the banned IP address file.';

		// get action and run
		$action = $this->gpc ( 'sb_action', 'GP', '' );

		// admin logged in?
		$password = $this->gpc ( 'shoutbox_admin_password', 'C', '' );
		$this->_admin_login = $password == md5 ( $this->_configs['admin_password'] );

		// catch action and execute
		if ( is_array ( $action ) )
			list ( $action, ) = each ( $action );

		switch ( $action )
		{
			default: $this->displayShouts(); break;
			case 'add': $this->addShout(); break;
			case 'help': $this->showHelp(); break;
			case 'admin': $this->showAdminMenu(); break;
			case 'login': $this->showLoginForm(); break;
			case 'dologin': $this->doLogin(); break;
			case 'manage_shouts': $this->adminListShouts(); break;
			case 'edit_shout': $this->editShout(); break;
			case 'delete_shout': $this->deleteShout(); break;
			case 'delete_by_age': $this->deleteShoutByAge(); break;
			case 'block_ip': $this->showBlockedIPs(); break;
			case 'update_ips': $this->updateBlockedIPList(); break;
			case 'logout':
			{
				setcookie ( 'shoutbox_admin_password', '', time() - 100000, '/' );
				header ( 'Location: ' . $this->_configs['base_url'] );
			}
			break;
			case 'user_logout':
			{
				setcookie ( 'shoutbox_user', '', time() - 100000, '/' );
				setcookie ( 'shoutbox_password', '', time() - 100000, '/' );
				header ( 'Location: ' . $this->_configs['base_url'] );
			}
			break;
		}
	}

	function addShout()
	{
		// init
		$this->_db->close();
		$db = &$this->_db;
		$errors = array();

		// user banned from posting?
		$ip = isset ( $_SERVER['X_FORWARDED_FOR'] ) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		$db->open ( SHOUTBOX_DATA . 'shouts_banned.php' );
		$banned_ips = $db->all();
		$db->close();

		// read input
		$shout = $this->gpc ( 'sb_shout', 'P', array() );
		$return_url = $this->gpc ( 'sb_return_url', 'GP', $this->_configs['base_url'] );

		if ( !is_array ( $shout ) ) exit ( 'Shoutbox::addShout: Submitted data is not valid.' );
		$shout['name'] = isset ( $shout['name'] ) ? trim ( strip_tags ( $shout['name'] ) ) : '';
		$shout['password'] = isset ( $shout['password'] ) ? $shout['password'] : '';
		$shout['password'] = $shout['password'] == '' ? $this->gpc('shoutbox_password', 'C', md5(uniqid('',true))) : md5($shout['password']);
		$shout['email'] = isset ( $shout['email'] ) ? trim ( strip_tags ( $shout['email'] ) ) : '';
		$shout['url'] = isset ( $shout['url'] ) ? trim ( strip_tags ( $shout['url'] ) ) : '';
		$shout['message'] = isset ( $shout['message'] ) ? trim ( $shout['message'] ) : '';
		$shout['remember'] = isset ( $shout['remember'] ) ? (bool)$shout['remember'] : false;
		$shout['private'] = isset ( $shout['private'] ) ? (bool)$shout['private'] : false;

		// additional checking
		if ( in_array ( $ip, $banned_ips ) )
			$errors[] = 'banned';
		elseif ( $this->_configs['posting_type'] == 'admin' && !$this->_admin_login )
		{
			header ( 'Location: ' . $this->make_url(array()) );
			exit;
		}
		elseif ( $this->_configs['posting_type'] == 'user' && !$this->userCheck( $shout['name'], $shout['password'] ) )
		{
			$errors[] = 'wrong_password';
		}
		else
		{
			// Check flooding
			if ( $this->_configs['flood_filter_enabled'] )
			{
				$last_post_time = (int)$this->gpc ( 'shoutbox_last_post', 'C', 0 );
				$time_out = time() - $last_post_time;
				if ( $time_out < $this->_configs['flood_filter_timeout'] )
					$errors[] = 'flood_post';
			}

			// check name
			if ( $shout['name'] == '' )
				$errors[] = 'no_name';
			elseif ( strlen ( $shout['name'] ) > $this->_configs['max_name_length'] )
				$errors[] = 'long_name';

			// check message
			if ( $shout['message'] == '' )
				$errors[] = 'no_message';
			elseif ( strlen ( $shout['message'] ) > $this->_configs['max_post_length'] )
				$errors[] = 'no_message';

			// check url
			if ( preg_match ( '#^(((ht|f)tp(s?))\://([0-9a-z\-]+\.)+[a-z]{2,6}(\:[0-9]+)?(/\S*)?)$#i', $shout['url'], $match ) )
				$shout['url'] = $match[1];
			elseif ( preg_match ( '#^(((www|ftp|news))(\.[^\s\n\r\t\<\>\*\[\]\"\']{3,})\.[a-z0-9\.]{3,6})#i', $shout['url'], $match ) )
				$shout['url'] = 'http://' . $match[1];
			else $shout['url'] = '';

			// check email address
			if ( preg_match ( '#^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,9})$#i', $shout['email'], $match ) )
				$shout['email'] = $match[1];
			else $shout['email'] = '';
		}

		// any errors?
		if ( count ( $errors ) )
		{
			header ( 'Location: ' . $this->make_url ( array ( 'sb_errors' => implode ( '-', $errors ), '{anchor:0}' => 'shoutbox_form' ), '&' ) );
			exit;
		}
		else
		{
			// generate unique id that will also be the name of the shout file.
			do
			{
				clearstatcache();
				$shout_id = Shoutbox::gen_id();
				$shout_file = SHOUTBOX_DATA . $shout_id . '.php';
			}
			while ( is_file ( $shout_file ) );

			$new_shout = array
			(
				'id'		=> $shout_id,
				'name'		=> $shout['name'],
				'email'		=> $shout['email'],
				'url'		=> $shout['url'] != 'http://' ? $shout['url'] : '',
				'message'	=> $shout['message'],
				'ip'		=> isset ( $_SERVER['X_FORWARDED_FOR'] ) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'],
				'time'		=> time(),
				'private'	=> $shout['private']
			);

			// save post
			if ( !$db->create ( $shout_file ) ) exit ( 'Could not create shout file in "' . SHOUTBOX_DATA . '". Make sure this directory has Read and Write permission.' );
			$db->open ( $shout_file );
			$db->set ( $new_shout, true );
			$db->save();
			$db->close();

			// update index
			if ( !$db->open ( SHOUTBOX_DATA . 'shouts_index.php' ) ) exit ( 'Could not open the shoutbox index. Verify that it exists and has Read and Write permission.' );
			$db->prepend ( $shout_id );
			$db->save();

			// remember?
			$expire = $shout['remember'] ? time() + 2592000 : time() - 2592000;
			setcookie ( 'shoutbox_name', $shout['name'], $expire, '/' );
			setcookie ( 'shoutbox_password', $shout['password'], $expire, '/' );
			setcookie ( 'shoutbox_email', $shout['email'], $expire, '/' );
			setcookie ( 'shoutbox_url', $shout['url'], $expire, '/' );
			setcookie ( 'shoutbox_last_post', time(), time() + 2592000, '/' );
		}

		// return to shoutbox
		header ( 'Location: ' . $return_url );
	}

	function displayShouts()
	{
		$this->_db->close();
		$db = &$this->_db;
		$tpl_display = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_display.php' );
		$tpl_display->set ( 'sb_configs', $this->_configs );
		$current_page = (int)$this->gpc ( 'sb_page', 'G', 1 );
		$shouts = array();

		// load shouts index
		if ( !$db->open ( SHOUTBOX_DATA . 'shouts_index.php' ) )
			return print 'Error opening the shouts index file.';

		$index = $db->all();
		if ( !is_array ( $index ) )
			return print 'The shouts index file is corrupted.';

		// pagination
		$per_page = $this->_configs['shouts_per_page'];
		$total_shouts = $index_count = count ( $index );
		$total_pages = ceil ( $total_shouts / $per_page );
		if ( $current_page < 1 ) $current_page = 1;
		elseif ( $current_page > $total_pages ) $current_page = $total_pages;

		$older_url = $this->make_url ( array ( 'sb_page' => min ( $total_pages, $current_page + 1 ) ), '&amp;' );
		$oldest_url = $this->make_url ( array ( 'sb_page' => $total_pages ), '&amp;' );
		$newer_url = $this->make_url ( array ( 'sb_page' => max ( 1, abs($current_page-1) ) ), '&amp;' );
		$newest_url = $this->make_url ( array ( 'sb_page' => 1 ), '&amp;' );

		if ( $index_count > $per_page )
			$index = array_slice ( $index, ($current_page-1) * $per_page, $per_page );

		if ( $this->_configs['shouts_order'] != 'asc' )
			$index = array_reverse ( $index );

		// process shouts
		$index_count = count ( $index );
		for ( $i = 0; $i < $index_count; ++$i )
		{
			if ( $db->open ( SHOUTBOX_DATA . $index[$i] . '.php' ) )
			{
				$shout = $db->all();
				$db->close();

				$ip_parts = explode ( '.', $shout['ip'] );
				array_shift ( $ip_parts );
				array_shift ( $ip_parts );
				$shout['ip'] = 'x.x.' . implode ( '.', $ip_parts );

				if ( $shout['url'] != '' && ( preg_match ( '#^http://([^\s\n\r\t\<\>\*\[\]\"\']{3,})$#is', $shout['url'] ) ) )
					$shout['link'] = Shoutbox::entities ( $shout['url'] );
				elseif ( $shout['email'] != '' && preg_match ( '#.+?\@.+?#', $shout['email'] ) )
					$shout['link'] = 'mailto:' . Shoutbox::entities ( $shout['email'] );
				else
					$shout['link'] = '';

				$shout['position'] = (($current_page-1) * $this->_configs['shouts_per_page'] + $i + 1);
				$shout['name'] = Shoutbox::entities ( $shout['name'] );
				$shout['time'] = Shoutbox::get_date( $this->_configs['time_format'], $shout['time'] + ( $this->_configs['timezone_adjust'] * 3600 ) );
				$shout['message'] = ( $shout['private'] && !$this->_admin_login ) ? 'This post is private. If you are the Admin, login to view this post.' : $this->parse_message ( $shout['message'] );
				$shouts[] = $shout;
			}
		}
		$start = ($current_page-1) * $per_page + 1;
		$end = $start + $index_count - 1;

        	// no shouts, these are negative
		if ( $start < 0  ) $start = 0;
		if ( $end < 0 ) $end = 0;

		// default shout
		$username = $this->gpc ( 'shoutbox_name', 'C', 'Anonymouse' );
		$password = $this->gpc ( 'shoutbox_password', 'C', md5(uniqid('',true)) );
		$default_shout = array
		(
			'name' 	=> $username,
			'email' => isset ( $_COOKIE['shoutbox_email'] ) ? $_COOKIE['shoutbox_email'] : '',
			'url' 	=> isset ( $_COOKIE['shoutbox_url'] ) ? $_COOKIE['shoutbox_url'] : 'http://',
		);

		// user logged in?
		$user_logged_in = $this->userCheck ( $username, $password );
		$error_str = trim ( $this->gpc ( 'sb_errors', 'GP', '' ) );
		$error_codes = $error_str != '' ? explode ( '-', $error_str ) : array();

		// display
		$tpl_vars = array
		(
			'error_codes'	=> &$error_codes,
			'sb_shout'		=> $default_shout,
			'shouts'		=> &$shouts,
			'form_action'	=> $this->_configs['shoutbox_url'],
			'newer_url'		=> $newer_url,
			'newest_url'	=> $newest_url,
			'older_url' 	=> $older_url,
			'oldest_url'	=> $oldest_url,
			'start'			=> $start,
			'end'			=> $end,
			'total'			=> $total_shouts,
			'current_page'	=> $current_page,
			'total_pages'	=> $total_pages,
			'posting_type'	=> $this->_configs['posting_type'],
			'admin_logged_in' => $this->_admin_login,
			'user_logged_in' => $user_logged_in,
			'user_logout_url' => $this->make_direct_url ( array ( 'sb_action' => 'user_logout' ) ),
			'admin_url'		=> $this->make_url ( array ( 'sb_action' => 'admin' ) ),
			'help_url'		=> $this->make_url ( array ( 'sb_action' => 'help' ) ),
		);

		$tpl_display->set ( $tpl_vars );
		$tpl_display->display();
	}

	function adminListShouts()
	{
		$this->adminCheck();

		$this->_db->close();
		$db = &$this->_db;
		$tpl_display = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_admin_display.php' );
		$current_page = (int)$this->gpc ( 'sb_page', 'G', 1 );
		$shouts = array();

		// load shouts index
		if ( !$db->open ( SHOUTBOX_DATA . 'shouts_index.php' ) )
			return print 'Error opening the shouts index file.';

		$index = $db->all();
		if ( !is_array ( $index ) )
			return print 'The shouts index file is corrupted.';

		// pagination
		$per_page = 15;
		$total_shouts = $index_count = count ( $index );
		$total_pages = ceil ( $total_shouts / $per_page );
		if ( $current_page < 1 ) $current_page = 1;
		elseif ( $current_page > $total_pages ) $current_page = $total_pages;

		$older_url = $this->make_url ( array ( 'sb_action' => 'manage_shouts', 'sb_page' => min ( $total_pages, $current_page + 1 ) ), '&amp;' );
		$oldest_url = $this->make_url ( array ( 'sb_action' => 'manage_shouts', 'sb_page' => $total_pages ), '&amp;' );
		$newer_url = $this->make_url ( array ( 'sb_action' => 'manage_shouts', 'sb_page' => max ( 1, abs($current_page-1) ) ), '&amp;' );
		$newest_url = $this->make_url ( array ( 'sb_action' => 'manage_shouts', 'sb_page' => 1 ), '&amp;' );

		if ( $index_count > $per_page )
			$index = array_slice ( $index, ($current_page-1) * $per_page, $per_page );

		if ( $this->_configs['shouts_order'] != 'asc' )
			$index = array_reverse ( $index );

		// process shouts
		$index_count = count ( $index );
		for ( $i = 0; $i < $index_count; ++$i )
		{
			if ( $db->open ( SHOUTBOX_DATA . $index[$i] . '.php' ) )
			{
				$shout = $db->all();
				$db->close();

				$shout['position'] = (($current_page-1) * $this->_configs['shouts_per_page'] + $i + 1);
				$shout['name'] = Shoutbox::entities ( $shout['name'] );
				$shout['time'] = Shoutbox::get_date( $this->_configs['time_format'], $shout['time'] + ( $this->_configs['timezone_adjust'] * 3600 ) );
				$shout['view_url'] = $this->make_url ( array ( 'sb_action' => 'view_shout', 'sb_shoutid' => $shout['id'] ) );
				$shout['edit_url'] = $this->make_url ( array ( 'sb_action' => 'edit_shout', 'sb_shoutid' => $shout['id'] ) );
				$shout['delete_url'] = $this->make_url ( array ( 'sb_action' => 'delete_shout', 'sb_shoutids[]' => $shout['id'] ) );
				$shouts[] = $shout;
			}
		}
		$start = ($current_page-1) * $per_page + 1;
		$end = $start + $index_count - 1;

        // no shouts, these are negative
		if ( $start < 0  ) $start = 0;
		if ( $end < 0 ) $end = 0;

		// display
		$tpl_vars = array
		(
			'shouts'		=> &$shouts,
			'form_url'	=> $this->_configs['shoutbox_url'],
			'newer_url'		=> $newer_url,
			'newest_url'	=> $newest_url,
			'older_url' 	=> $older_url,
			'oldest_url'	=> $oldest_url,
			'start'			=> $start,
			'end'			=> $end,
			'total'			=> $total_shouts,
			'current_page'	=> $current_page,
			'total_pages'	=> $total_pages,
			'admin_url'		=> $this->make_url ( array ( 'sb_action' => 'admin' ) ),
			'help_url'		=> $this->make_url ( array ( 'sb_action' => 'help' ) ),
		);

		$tpl_display->set ( $tpl_vars );
		$tpl_display->display();
	}


	function deleteShout()
	{
		$this->adminCheck();
		$this->_db->close();
		$db = &$this->_db;
		$shout_ids = $this->gpc ( 'sb_shoutids', 'GP', array() );

		if ( is_array ( $shout_ids ) && count ( $shout_ids ) )
		{
			if ( !$db->open ( SHOUTBOX_DATA . 'shouts_index.php' ) ) exit ( 'Error opening shout index' );
			$index = $db->all();
			$count = count ( $shout_ids );

			for ( $i = 0; $i < $count; ++$i )
			{
				$key = array_search ( $shout_ids[$i], $index );

				if ( $key !== false )
				{
					unset ( $index[$key] );
					unlink ( SHOUTBOX_DATA . $shout_ids[$i] . '.php' );
				}
			}
			$index = array_values ( $index );
			$db->set ( $index, true );
			$db->save();
		}
		header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'manage_shouts' ), '&' ) );
	}

	function deleteShoutByAge()
	{
		$this->adminCheck();
		$this->_db->close();
		$db = &$this->_db;
		if ( !$db->open ( SHOUTBOX_DATA . 'shouts_index.php' ) ) exit ( 'Error opening shout index' );
		$index = $db->all();
		$age = (float)$this->gpc ( 'sb_age', 'P', 0 );

		if ( $age > 0 )
		{
			$time_limit = time() - ( $age * 86400 );
			while ( list ( $key, $time ) = each ( $index ) )
			{
				if ( (float)$time < $time_limit )
				{
					unset ( $index[$key] );
					unlink ( SHOUTBOX_DATA . $time . '.php' );
				}
			}
		}
		$index = array_values ( $index );
		$db->set ( $index, true );
		$db->save();
		header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'manage_shouts' ), '&' ) );
	}

	function editShout()
	{
		$this->adminCheck();
		$shout_id = $this->gpc ( 'sb_shoutid', 'GP', '' );
		$task = $this->gpc ( 'sb_task', 'GP', '' );
		$tpl_edit = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_editshout.php' );
		$tpl_edit->set ( 'cancel_url',  $this->make_url ( array ( 'sb_action' => 'manage_shouts' ) ) );

		$this->_db->close();
		$db = &$this->_db;
		if ( $db->open ( SHOUTBOX_DATA . $shout_id . '.php' ) )
		{
			if ( $task == 'save' )
			{
				$shout = $this->gpc ( 'sb_shout', 'P', array() );

				$db->set ( 'name', $shout['name'] );
				$db->set ( 'email', $shout['email'] );
				$db->set ( 'url', $shout['url'] );
				$db->set ( 'private', $shout['private'] );
				$db->set ( 'message', $shout['message'] );
				$db->save();
				header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'manage_shouts' ), '&' ) );
			}
			else
			{
				$shout = $db->all();
				$db->close();

				$shout['name'] = Shoutbox::entities($shout['name']);
				$shout['email'] = Shoutbox::entities($shout['email']);
				$shout['url'] = Shoutbox::entities($shout['url']);
				$shout['message'] = Shoutbox::entities($shout['message']);

				$tpl_edit->set ( 'shout', $shout );
				$tpl_edit->set ( 'form_url', $this->make_direct_url ( array ( 'sb_action' => 'edit_shout' ) ) );
				$tpl_edit->display();
			}
		}
		else header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'manage_shouts' ), '&' ) );
	}

	function showHelp()
	{
		$tpl_help = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_help.php' );
		$tpl_help->set ( 'shoutbox_url', $this->_configs['base_url'] );
		$smilies_table = $this->_configs['smilies_table'];
		while ( list ( $text, $icon ) = each ( $smilies_table ) )
			$smilies_table[$text] = $this->_configs['shoutbox_dir_url'] . 'templates/smilies/' . $icon;
		reset ( $smilies_table );
		$tpl_help->set ( 'admin_url', $this->make_url ( array ( 'sb_action' => 'admin' ) ) );
		$tpl_help->set ( 'smilies_table', $smilies_table );
		$tpl_help->display();
	}

	function showAdminMenu()
	{
		$this->adminCheck();
		$tpl_admin = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_admin.php' );

		$total_size = 0;
		$index_size = filesize ( SHOUTBOX_DATA . 'shouts_index.php' );
		$ban_list_size = filesize ( SHOUTBOX_DATA . 'shouts_banned.php' );
		$h = opendir ( SHOUTBOX_DATA );
		while ( false !== ( $f = readdir ( $h ) ) )
		{
			if ( $f == '.' || $f == '..' ) continue;
			$total_size += filesize ( SHOUTBOX_DATA . $f );
		}
		$total_size -= ( $index_size + $ban_list_size );

		// number of shouts
		$this->_db->close();
		$db = &$this->_db;
		$db->open ( SHOUTBOX_DATA . 'shouts_index.php' );
		$total_shouts = $db->count();
		$db->close();

		// banned ips
		$db->open ( SHOUTBOX_DATA . 'shouts_banned.php' );
		$banned_ip_count = $db->count();
		$db->close();

		$tpl_admin->set ( 'total_size', $total_size / 1024 );
		$tpl_admin->set ( 'index_size', $index_size / 1024 );
		$tpl_admin->set ( 'total_shouts', $total_shouts );
		$tpl_admin->set ( 'banned_ip', $banned_ip_count );
		$tpl_admin->set ( 'manage_shout_url', $this->make_url ( array ( 'sb_action' => 'manage_shouts') ) );
		$tpl_admin->set ( 'ip_block_url', $this->make_url ( array ( 'sb_action' => 'block_ip' ) ) );
		$tpl_admin->set ( 'logout_url', $this->make_direct_url ( array ( 'sb_action' => 'logout' ) ) );
		$tpl_admin->set ( 'back_url', $this->_configs['base_url'] );
		$tpl_admin->display();
	}

	function showBlockedIPs()
	{
		$this->adminCheck();
		$this->_db->close();
		$db = &$this->_db;
		$db->open ( SHOUTBOX_DATA . 'shouts_banned.php' );
		$ip_addresses = $db->all();
		$db->close();

		$tpl_ips = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_admin_ips.php' );
		$tpl_ips->set ( 'form_url', $this->make_direct_url ( array ( 'sb_action' => 'update_ips' ) ) );
		$tpl_ips->set ( 'addresses', implode ( ', ', $ip_addresses ) );
		$tpl_ips->set ( 'admin_url', $this->make_url ( array ( 'sb_action' => 'admin' ) ) );
		$tpl_ips->display();
	}

	function updateBlockedIPList()
	{
		$this->adminCheck();
		$ip_address_str = $this->gpc ( 'ip_addresses', 'P', '' );
		$ip_address_array = array();

		$ips = explode ( ',', $ip_address_str );
		$count = count ( $ips );

		for ( $i = 0; $i < $count; ++$i )
		{
			$ip = trim ( $ips[$i] );
			if ( preg_match ( '#^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$#', $ip ) )
			{
				$ip_address_array[] = $ip;
			}
		}

		// save list
		$this->_db->close();
		$db = &$this->_db;
		$db->open ( SHOUTBOX_DATA . 'shouts_banned.php' );
		$db->set ( $ip_address_array, true );
		$db->save();

		header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'block_ip' ), '&' ) );
	}

	function showLoginForm()
	{
		$tpl_login = new ShoutboxTemplate ( SHOUTBOX_TPLDIR . 'tpl_login.php' );
		$tpl_login->set ( 'form_url', $this->make_direct_url( array('sb_action' => 'dologin') ) );
		$tpl_login->set ( 'sb_login_failed', $this->gpc ( 'sb_login_failed', 'G', false ) );
		$tpl_login->display();
	}

	function doLogin()
	{
		$password = $this->gpc ( 'sb_password', 'P', '' );
		if ( $password == $this->_configs['admin_password'] )
		{
			setcookie ( 'shoutbox_admin_password', md5 ( $password ), time() + 100000, '/' );
			header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'admin' ), '&' ) );
		}
		else header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'login', 'sb_login_failed' => 'true' ), '&' ) );
	}

	function adminCheck()
	{
		if ( !$this->_admin_login )
		{
			$this->showLoginForm();
			header ( 'Location: ' . $this->make_url ( array ( 'sb_action' => 'login' ), '&' ) );
			exit;
		}
	}

	function userCheck ( $username, $password_md5 )
	{
		$username = strtolower ( $username );

		if ( isset ( $this->_configs['posting_users'][$username] ) )
		{
			return md5($this->_configs['posting_users'][$username]) == $password_md5;
		}
		return false;
	}

	function gpc($n,$w='GPC',$d=''){for($i=0;$i<strlen($w);$i++){if($w[$i]=='G'&&isset($this->__GET[$n]))return$this->__GET[$n];if($w[$i]=='P'&&isset($this->__POST[$n]))return$this->__POST[$n];if($w[$i]=='C'&&isset($this->__COOKIE[$n]))return$this->__COOKIE[$n];}return$d;}
	function strip_gpc($v){if(is_array($v)){while(list($k,$x)=each($v))$v[$k]=Shoutbox::strip_gpc($x);return$v;}return stripslashes($v);}
	function makeurl($base,$queries=array(),$sep='&amp;'){if(!count($queries))return$base;$tmp=parse_url($base);$vars=array();while(list($k,$v)=each($queries))$vars[]=(substr($k,1,6)=='anchor'?'#':urlencode($k).'=').urlencode($v);$qstr=implode($sep,$vars);return$base.((isset($tmp['query'])&&$tmp['query']!='')?$sep:'?').$qstr;}
	function gen_id(){list($ms,$s)=explode(' ',microtime());return (string)((float)$s+(float)$ms);}
	function get_date($f,$t){$s=time()-$t;if($s<60)return'moments ago';$m=$s/60;if($m<60)return floor($m).' minutes ago';$h=$m/60;if($h<24)return floor($h).' hours ago';$d=$h/24;if($d<2)return 'Yesterday, '.date('h:iA',$t);if($d<=7)return floor($d).' days ago';return date($f,$t);}
	function entities($s,$q=ENT_QUOTES){return htmlentities($s,$q,'UTF-8');}
	function str_slice($s,$l){return strlen($s)>$l?substr($s,0,$l/2-1).'...'.substr($s,-($l/2-2)):$s;}

	function make_url ( $queries, $sep = '&amp;' )
	{
		return $this->makeurl ( $this->_configs['base_url'], $queries, $sep );
	}

	function make_direct_url ( $queries, $sep = '&amp;' )
	{
		return $this->makeurl ( $this->_configs['shoutbox_url'], $queries, $sep );
	}

	function parse_bb ( $str, $enable_img = true, $slice = 50 )
	{
		$search = array
		(
			'#\[B\](.+?)\[\/B\]#mis',
			'#\[I\](.+?)\[\/I\]#mis',
			'#\[U\](.+?)\[\/U\]#mis',
			'#\[QUOTE\](.+)\[\/QUOTE\]#mise',
			'#\[COLOR\=(.+?)\](.+?)\[\/COLOR\]#mis',
			'#\[H\](.+?)\[\/H\]#mis',
			'#(^|\s+)((www|ftp|news))(\.[^\s\n\r\t\<\>\*\[\]\"\']{3,})#mise', // B
			'#(^|\s+)((https?|ftp|news)://)([^\s\n\r\t\<\>\*\[\]\"\']{3,})#mise', // A
			'#\[IMG\](((https?|ftp|news)://)([^\s\n\r\t\<\>\*\[\]\"\']{3,}))\[\/IMG\]#mise'
		);

		$replace = array
		(
			'<strong>$1</strong>',
			'<span style="font-style:italic;">$1</span>',
			'<span style="text-decoration:underline;">$1</span>',
			'"<span class=\"blockquote\">".trim($this->parse_bb("$1"))."</span>"',
			'<span style="color:$1;">$2</span>',
			'<span style="color:#f0f0f0;background-color:#f0f0f0" onmouseover="this.style.color=\'\';this.style.backgroundColor=\'\'" onmouseout="this.style.color=\'#f0f0f0\';this.style.backgroundColor=\'#f0f0f0\'">$1</span>',
			"'$1<a href=\"'.('$2'=='www'?'http':'$2').'://$2$4\">'.Shoutbox::str_slice('$0',$slice).'</a>'",  // B
			"'$1<a href=\"'.Shoutbox::entities('$2$4').'\">'.Shoutbox::str_slice('$0',$slice).'</a>'",  // A
			$enable_img ? "'<img src=\"$1\" alt=\"image\" />'" : "'<a href=\"'.Shoutbox::entities('$1',ENT_QUOTES).'\">'.Shoutbox::str_slice('$1',$slice).'</a>'"
		);
		$count = 0;

		return preg_replace ( $search, $replace, $str );
	}

	function word_wrap ( $str, $len, $break = "<wbr />" )
	{
		$str = preg_replace ( "#([^\s\t\r\n\<\>]{" . $len . "})#ms", "$1$break", $str );
		$str = preg_replace ( '#(src|href)="(.+?)"#mise', "stripslashes(str_replace('$break','','$0'))", $str );
		return $str;
	}

	function parse_message ( $str, $wordwrap = 50 )
	{
		if ( $this->_configs['language_filter_on'] )
		{
			$words = explode ( ',', $this->_configs['bad_words'] );
			$count = count ( $words );
			for ( $i = 0; $i < $count; ++$i )
				$str = str_replace ( $words[$i], str_repeat ( '*', strlen ( $words[$i] ) ), $str );
		}

		if ( !$this->_configs['allow_html'] )
			$str = Shoutbox::entities ( $str, ENT_QUOTES );

		$str = str_replace ( "\t", '    ', $str );
		//$str = str_replace ( "\n ", '&nbsp;', $str );
		$str = str_replace ( '  ', ' &nbsp;', $str );

		if ( $this->_configs['parse_bb'] )
			$str = Shoutbox::parse_bb ( $str, $this->_configs['parse_img_bb'], $wordwrap );
		$str = Shoutbox::word_wrap ( $str, $wordwrap );
		$str = nl2br ( $str );

		if ( $this->_configs['parse_smilies'] )
		{
			$smilies_tbl = $this->_configs['smilies_table'];
			$text = array_keys ( $smilies_tbl );
			$face = array_values ( $smilies_tbl );
			for ( $i = 0; $i < count ( $face ); ++$i )
				$face[$i] = '<img src="' . $this->_configs['shoutbox_dir_url'] . 'templates/smilies/' . $face[$i] . '" alt="" />';
			$str = str_replace ( $text, $face, $str );
		}
		return $str;
	}
}


// Run!
$shoutbox = new Shoutbox
(
	get_magic_quotes_gpc() ? Shoutbox::strip_gpc($_GET) : $_GET,
	get_magic_quotes_gpc() ? Shoutbox::strip_gpc($_POST) : $_POST,
	get_magic_quotes_gpc() ? Shoutbox::strip_gpc($_COOKIE) : $_COOKIE
);
?>