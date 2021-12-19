<div id="shoutbox">
    <!-- nagivation -->
    <h2>Admin: Manage Shouts</h2>
    <div class="nav">
        <div class="left">
            <a href="<?=$admin_url?>" class="special">Back to the Admin Menu</a>
        </div>
        <div class="right">
            <?=$current_page > 2 ? '<a href="' . $newest_url . '" class="special">&lt;&lt;Newest</a>' : '' ?>
            <?=$current_page > 1 ? '<a href="' . $newer_url . '" class="special">&lt;Newer</a>' : ''?>
            (<strong><?=$start?></strong>-<strong><?=$end?></strong> of <strong><?=$total?></strong>)
            <?=$current_page < $total_pages ? '<a href="' . $older_url . '" class="special">Older&gt;</a>' : ''?>
            <?=$total_pages - $current_page > 1 ? '<a href="' . $oldest_url . '" class="special">Oldest&gt;&gt;</a>' : ''?>
        </div>
        <div style="clear:both;"></div>
    </div>

    <!-- the shouts -->
    <?php if ( count ( $shouts ) ) :  ?>
    <form method="post" action="<?=$form_url?>">
        <table style="width:100%;text-align:center" cellspacing="0" cellpadding="0" class="rowlines">
            <tr class="header">
                <td style="width:15px">#</td>
                <td>&nbsp;</td>
                <td style="text-align:left">Poster</td>
                <td>IP Address</td>
                <td>Post time</td>
                <td>Actions</td>
                <td><input type="checkbox" class="check_box2" onclick="checkAll(this.form, 'sb_shoutids[]', this.checked);" /></td>
            </tr>
            <?php reset ( $shouts ); $num = 0; while ( list ( , $shout ) = each ( $shouts ) ) : ?>
            <tr style="background-color:<?=$num&1?'#fcfcfc':'#fff'?>">
                <td><?=$shout['position']?></td>
                <td><?=$shout['private']?'<span class="private">P</span>':''?></td>
                <td style="text-align:left"><?=$shout['name']?></td>
                <td><?=$shout['ip']?></td>
                <td><?=$shout['time']?></td>
                <td style="color:#ddd">
                    <a href="<?=$shout['edit_url']?>" class="special">Edit</a> |
                    <a href="<?=$shout['delete_url']?>" class="special" onclick="return confirmDeleteShout();">Del</a>
                </td>
                <td><input type="checkbox" name="sb_shoutids[]" value="<?=$shout['id']?>" class="check_box" /></td>
            </tr>
            <?php $num++; endwhile; ?>
        </table>
        <div class="menu1">
            <p class="left">
                <input type="submit" name="sb_action[delete_by_age]" value="Delete posts older than" onclick="return confirm('Delete old posts?');"/>
                <input type="text" name="sb_age" value="30" size="3" /> days old.
            </p>
            <p class="right">
                <input type="submit" name="sb_action[delete_shout]" value="Delete selected" onclick="return confirm('Delete seletected posts?');" />
            </p>
            <div class="spacer"></div>
        </div>
    </form>
    <?php else: ?>
    <p>No shouts found</p>
    <?php endif; ?>
</div>

<script type="text/javascript">
function confirmDeleteShout()
{
    return confirm('Are you sure you want to delete this post?');
}

function checkAll(form, name, checked)
{
    for ( var i = 0; i < form.elements.length; ++i )
        if ( form.elements[i].type == 'checkbox' && form.elements[i].name == name )
            form.elements[i].checked = checked;
}
</script>