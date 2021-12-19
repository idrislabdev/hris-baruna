<div id="shoutbox">
    <!-- nagivation -->
    <h2>Shoutbox Help</h2>
    <div class="nav">
        <a href="<?=$shoutbox_url?>" class="special">Return to the shoutbox</a> -
        <a href="<?=$admin_url?>" class="special">Shoutbox Admin</a>
    </div>

    <div style="padding:3px">
        <h3>URL Parsing &amp; BB Codes</h3>
        <p>
            All recognized URLs will be made into clickable links. The following standard BB Codes are available:
        </p>
        <ul class="text">
            <li>[b]Bold text[/b]</li>
            <li>[i]Emphasized text[/i]</li>
            <li>[u]Underlined text[/u]</li>
            <li>[quote]Quoted text[/quote]</li>
            <li>[h]Hidden text that is revealed when the mouse cursor hovers over it[/h]</li>
            <li>[color=green]Colored text, you can use hex value or color name[/color]</li>
        </ul>
    </div>

    <div style="padding:3px">
        <h3>Smilies</h3>
        <p>
            <input type="text" id="sb_smily_code_container" size="8" style="text-align:center" /><br />
            <?php reset ( $smilies_table ); $i = 0; while ( list ( $text, $icon ) = each ( $smilies_table ) ) : $i++; $even = $i & 1; ?>
            <img src="<?=$icon?>" alt="<?=$text?>" title="<?=$text?>" onmouseover="showSmilyCode('<?=$text?>');" />&nbsp;
            <?php endwhile; ?>
            <br />
            Hover over the smilies to see the corresponding smily code.
        </p>
    </div>

    <div style="padding:3px">
        <h3>About this Shoutbox</h3>
        <p>
            Shoutbox v2.0 &copy; <a href="http://celerondude.com" class="special">www.celerondude.com</a>
        </p>
    </div>
</div>

<script type="text/javascript">
function showSmilyCode(code)
{
    var textbox = document.getElementById('sb_smily_code_container');
    if ( !textbox ) return;
    textbox.value = code;
}
</script>