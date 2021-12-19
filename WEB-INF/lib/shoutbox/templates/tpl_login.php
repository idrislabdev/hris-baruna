<div id="shoutbox">
    <h2>Admin Login</h2>
    <?php if ( $sb_login_failed ) : ?>
    <div class="sb_post_error">
        <p>Incorrect password!</p>
    </div>
    <?php endif; ?>
    <form method="post" action="<?=$form_url?>">
        <input type="hidden" name="sb_action" value="login" />
        <p>
            Admin password:
            <input type="password" id="sb_password_input" name="sb_password" size="20" />
            <input type="submit" value="Proceed" />
        </p>
    </form>
</div>
<script type="text/javascript">
document.getElementById('sb_password_input').focus();
</script>