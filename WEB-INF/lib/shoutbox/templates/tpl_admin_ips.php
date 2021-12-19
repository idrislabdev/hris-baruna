<div id="shoutbox">
    <!-- nagivation -->
    <h2>Admin: Blocked IP Addresses</h2>
    <div class="nav">
        <a href="<?=$admin_url?>" class="special">Back to the Admin Menu</a>
    </div>
    <div id="sb_content">
        <p>Below are blocked IP addresses. Blocked addresses are not allowed to post on the shoutbox. Enter all addresses in the list below, seperate addresses
        with a comma.</p>

        <form method="post" action="<?=$form_url?>">
            <p>
                <textarea name="ip_addresses" rows="5" cols="70"><?=$addresses?></textarea>
                <br />
                <input type="submit" value="Update list" />
                <input type="reset" value="Reset list" onclick="return confirm('Confirm reset list?');" />
            </p>
        </form>
    <div>
</div>