<?php
$this->_configs = array
(
	// Change this! Chose a strong random password. Example: JtX2953@105bC
	'admin_password'	=> 'password',

        // Posting type:
        // any => anyone can post messages
        // users => only users listed below can post.
        // admin => only the admin can post (must be logged in)
        'posting_type'          => 'any',

        // An array of users and their passwords. This is ignored if the posting type is NOT 'users'.
        // The format is:
        // 'username'           => 'password',
        // Use lower case names. User name checking is NOT case sensitive. Password checking is CASE SENSITIVE.
        'posting_users'         => array
        (
            'user'              => 'test',
        ),

	// The URL where the shoutbox can be viewed.
	// If you've included the shoutbox into another page, use the URL to THAT page.
        // No trailing slash required.
        // Example: http://yoursite.com/shoutbox
        // Example: http://yoursite.com/index.php?page=shoutbox
	'base_url'		=> 'index.php',

	// The FULL URL to shoutbox.php.
        // This URL must be correct or else your visitors will not be able to post.
	'shoutbox_url'		=> 'shoutbox.php',

        // The FULL URL to the directory where shoutbox.php is located. This
        // is basically the URL from above minus "shoutbox.php"
        'shoutbox_dir_url'      => '',

        // Time format. See http://us2.php.net/manual/en/function.date.php for more info.
        'time_format'           => 'M d, Y',

        // Timezone adjustment. Enter the hour difference between where you live and where the server is located.
        // Value must be an integer and can be negative.
        'timezone_adjust'       => 0,

        // Language filter. Replace bad words with asterisks.
        'language_filter_on'    => 1,

        // allow HTML? NOT RECOMMENDED unless the posting type is user or admin.
        'allow_html'            => 0,

        // Parse UBB codes?
        'parse_bb'              => 1,

        // Allow [IMG] BB tags in message? Ignored if parse_bb is disabled.
        'parse_img_bb'          => 0,

        // Comma seperated list of bad words.
        'bad_words'             => 'shit,fuck,asshole,cunt,nigger,jew,jap,chink,nip,shit,pussy,faggot',

        // Enable flood filter to limit how long user must wait before making another post.
        'flood_filter_enabled'  => 0,

        // Flood filter wait time. User must wait this long before making another post. Value is in seconds.
        'flood_filter_timeout'  => 30,

        // 'asc' => Newest posts on top. 'desc' => Oldest posts on top.
        'shouts_order'		=> 'asc',

        // Number of shouts to display per page.
        'shouts_per_page'	=> 10,

        // Max number of characters in a poster's name.
        'max_name_length'	=> 50,

        // Max number of characters in a poster's message.
        'max_post_length'	=> 5000,

        // Parse smilies?
        'parse_smilies'         => 1,

        // List of smilies.
        'smilies_table'         => array
        (
            ':)'            => 'smile.gif',
            ':('            => 'frown.gif',
            ':D'            => 'biggrin.gif',
            '=D'            => 'biggrin.gif',
            ';)'            => 'wink.gif',
            ':-/'           => 'rolleyes.gif',
            '8-)'           => 'cool.gif',
            ':cool:'        => 'cool.gif',
            ':tard:'        => 'tard.gif',
            ':mad:'         => 'mad.gif',
            ':o'            => 'eek.gif',
            ':eek:'         => 'eek.gif',
            ':confused:'    => 'confused.gif',
            ':lol:'         => 'lol.gif',
            ':google:'      => 'google.gif',
        ),
);
?>