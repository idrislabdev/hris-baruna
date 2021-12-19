<div id="shoutbox">
    <!-- nagivation -->
    
	<a href="javascript:showPopup('<?=$help_url?>', '300', '400')" class="special">Help</a>
			<?=$current_page > 2 ? '<a href="' . $newest_url . '" class="special">&laquo;</a> - ' : '' ?>
            <?=$current_page > 1 ? '<a href="' . $newer_url . '" class="special"><</a>' : ''?>
            (Shout <strong><?=$start?></strong>-<strong><?=$end?></strong> of <strong><?=$total?></strong>)
            <?=$current_page < $total_pages ? '<a href="' . $older_url . '" class="special">></a>' : ''?>
            <?=$total_pages - $current_page > 1 ? ' - <a href="' . $oldest_url . '" class="special">&raquo;</a>' : ''?>
			
    <!-- the shouts -->
    <?php if ( count ( $shouts ) ) : reset ( $shouts ); while ( list ( $i , $shout ) = each ( $shouts ) ) : ?>
    <div class="shout">
        <div class="top">
            <div class="left">
                <div class="right">
                    <p class="poster poster_<?=$i&1?'even':'odd'?>">
                        <span class="name"><?=$shout['link']!=''?'<a href="'.$shout['link'].'" class="special">'.$shout['name'].'</a>':$shout['name']?></span>
                        <span class="time">
                            Posted <?=$shout['time']?> from <?=$shout['ip']?>
                            <?=$shout['private']?'<span class="private">This post is private</span>':''?>
                        </span>
                    </p>
                    <p class="message"><?=$shout['message']?></p>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="left"></div>
            <div class="right"></div>
        </div>
    </div>
    <?php endwhile; else: ?>
    <p>No shouts found. Be the first to post!</p>
    <?php endif; ?>

    <?php /* Admin only? */ if ( $posting_type != 'admin' || ($posting_type == 'admin' && $admin_logged_in) ) : ?>
    <!-- the form -->
    <div id="sb_form" style="display:none;">
        <a name="shoutbox_form"></a>
        <h1>Leave a message</h1>

        <?php if ( count ( $error_codes ) ) : ?>
        <div class="sb_post_error">
            <p>The following errors were found with your post:</p>
            <ul>
                <?php while ( list ( , $error_code ) = each ( $error_codes ) ) : ?>
                <?php if ( $error_code == 'no_name' ) : ?><li>Please enter your name.</li><?php endif; ?>
                <?php if ( $error_code == 'long_name' ) : ?><li>Your name is too long. Please shorten it.</li><?php endif; ?>
                <?php if ( $error_code == 'no_message' ) : ?><li>Please enter a message.</li><?php endif; ?>
                <?php if ( $error_code == 'long_message' ) : ?><li>Your message is too long. Please shorten it.</li><?php endif; ?>
                <?php if ( $error_code == 'flood_post' ) : ?><li>Please wait a while before making another post.</li><?php endif; ?>
                <?php if ( $error_code == 'banned' ) : ?><li>You have been banned from posting.</li><?php endif; ?>
                <?php if ( $error_code == 'wrong_password' ) : ?><li>Invalid username and/or password. Please try again.</li><?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="post" action="<?=$form_action?>">
            <input type="hidden" name="sb_action" value="add" />
            <table cellspacing="3">
                <?php /* user posting only AND user is logged in */ if ( $posting_type == 'user' &&  $user_logged_in ) : ?>
                <tr>
                    <td>Logged in as</td>
                    <td>
                        <?=@Shoutbox::entities($sb_shout['name'])?>
                        (<a href="<?=$user_logout_url?>" class="special">Log out</a>)
                        <input type="hidden" name="sb_shout[name]" value="<?=@Shoutbox::entities($sb_shout['name'])?>" />
                    </td>
                </tr>
                <?php /* user not logged in */ else: ?>
                <tr>
                    <td>Nama</td>
                    <td><input type="text" name="sb_shout[name]" size="20" value="<?=@Shoutbox::entities($sb_shout['name'])?>" /></td>
                </tr>
                <?php if ( $posting_type == 'user' ) : ?>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="sb_shout[password]" size="20" /></td>
                </tr>
                <?php endif; ?>
                <?php endif; ?>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="sb_shout[email]" size="35" value="<?=@Shoutbox::entities($sb_shout['email'])?>" /> (Optional)</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td><input type="text" name="sb_shout[url]" size="35" value="<?=@Shoutbox::entities($sb_shout['url'])?>" /> (Optional)</td>
                </tr>
                <tr>
                    <td>Options</td>
                    <td>
                        <input type="checkbox" name="sb_shout[remember]" id="sb_remember" value="1" class="check_box" checked="checked" />
                        <label for="sb_remember">Remember my name<?=$posting_type=='user'?', password':''?> and contact info</label>
                        <br />
                        <input type="checkbox" name="sb_shout[private]" id="sb_private" value="1" class="check_box" />
                        <label for="sb_private">Make this post private, only the admin can view it.</label>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;padding-top:5px">Message</td>
                    <td><textarea name="sb_shout[message]" id="sb_shout_message" rows="4" cols="20"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Post message" /></td>
                </tr>
            </table>
        </form>
    </div>
    <?php /* Posting type */ endif; ?>
</div>

<script type="text/javascript">
function sb_post_validate ( )
{
    var message = document.getElementById ( 'sb_shout_message' );
    if ( !message ) return false;
    if ( message.value == '' )
    {
        alert ( 'Please enter a message.' );
        return false;
    }
    return true;
}
</script>