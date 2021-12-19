<div id="shoutbox">
    <h2>Edit Post</h2>
    <form method="post" action="<?=$form_url?>">
        <input type="hidden" name="sb_action" value="edit_shout" />
        <input type="hidden" name="sb_shoutid" value="<?=$shout['id']?>" />
        <input type="hidden" name="sb_task" value="save" />
        <table cellspacing="3">
            <tr>
                <td>Poster's Name</td>
                <td><input type="text" name="sb_shout[name]" value="<?=$shout['name']?>" size="20" /> (IP: <?=$shout['ip']?>)</td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td><input type="text" name="sb_shout[email]" value="<?=$shout['email']?>" size="35" /></td>
            </tr>
            <tr>
                <td>Website URL</td>
                <td><input type="text" name="sb_shout[url]" value="<?=$shout['url']?>" size="35" /></td>
            </tr>
            <tr>
                <td>Privacy</td>
                <td>
                    <select name="sb_shout[private]">
                        <option value="1" <?=$shout['private']?'selected="selected"':''?>>Private</option>
                        <option value="0" <?=!$shout['private']?'selected="selected"':''?>>Public</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Message</td>
                <td><textarea name="sb_shout[message]" rows="4" cols="60"><?=$shout['message']?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="window.location='<?=$cancel_url?>'" /></td>
            </tr>
        </table>
    </form>
</div>