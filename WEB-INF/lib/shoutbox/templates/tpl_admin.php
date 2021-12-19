<div id="shoutbox">
    <h2>Shoutbox Admin</h2>
    <div class="nav">
        <a href="<?=$back_url?>" class="special">Back to the Shoutbox</a>
    </div>
    <div id="sb_content">
        <h3>Statistics</h3>
        <table style="width:100%" class="rowlines">
            <tr>
                <td>Total shouts</td>
                <td><?=number_format($total_shouts)?></td>
            </tr>
            <tr>
                <td>Post file size</td>
                <td><?=number_format(round($total_size,1), 1)?> KB total</td>
            </tr>
            <tr>
                <td>Index size</td>
                <td><?=number_format(round($index_size,1), 1)?> KB</td>
            </tr>
            <tr>
                <td>Block IP Addresses</td>
                <td><?=number_format($banned_ip,0)?></td>
            </tr>
        </table>
        </p>
        <h3>Actions</h3>
        <ul class="admin_menu">
            <li><a href="<?=$manage_shout_url?>" class="special">Manage posted shouts</a></li>
            <li><a href="<?=$ip_block_url?>" class="special">Block/Unblock IP</a></li>
            <li><a href="<?=$logout_url?>" class="special">Logout</a></li>
        </ul>
    </div>
</div>