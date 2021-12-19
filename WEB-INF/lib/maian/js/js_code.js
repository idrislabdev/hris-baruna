function highlight()
{
    document.CODE.html.focus();
    document.CODE.html.select();
 }
function submit_confirm()

{

  var confirmSub = confirm("Are you sure?");
  if (confirmSub) { return true; } else { return false; }

}
function selectAll()
{
	for (var i=0;i<document.MyForm.elements.length;i++)
        {
        	var e = document.MyForm.elements[i];
                if ((e.name != 'log') && (e.type=='checkbox'))
                {
                	e.checked = document.MyForm.log.checked;
                }
        }
}
function add_url_link()
{
	var nme=prompt( "Enter Website Name:", "" );
        if (nme=="") 
        {
        	return
        }
        if (nme==null) 
        {
        	return
        }
        var lnk=prompt( "Enter URL:", "http://" );
        if (lnk=="")
        {
        	return
        }
        if (lnk==null) 
        {
        	return
        }
        if (lnk=="http://") 
        {
        	return
        }
        var txt=document.MyForm.comments.value+" [url="+lnk+"]"+nme+"[/url] ";
        document.MyForm.comments.value=txt;
}
function add_mail_link()
{
	var mal=prompt( "Enter Email Address:", "" );
        if (mal==null)
        {
        	return
        }
        if (mal=="")
        {
        	return
        }
        var txt=document.MyForm.comments.value+" [email]"+mal+"[/email] ";
        document.MyForm.comments.value=txt;
}
function add_img_tag()
{
	var mal=prompt( "Enter Path to Image:", "http://" );
        if (mal==null) 
        {
        	return
        }
        if (mal=="") 
        {
        	return
        }
        var txt=document.MyForm.comments.value+" [img]"+mal+"[/img] ";
        document.MyForm.comments.value=txt;
}
function add_bb_code(gbookCode)
{
	var gbookCode;
        var newMessage;
        var oldMessage = document.MyForm.comments.value;
        newMessage = oldMessage+gbookCode;
        document.MyForm.comments.value=newMessage;
        document.MyForm.comments.focus();
        return;
}

