<?php

define("TITLE","FAQ");
define("TEXT","<p><b>1) How to do a schedule emails and use the script as autoresponder?</b></p>
<p>To use the script as an autoresponder you need to specify in cron
the following path: http://your_website/sendmail/admin/auto_responder.php</p>
<p><b>2) Can I make personalized mails?</b></p>
<p>Yes, you can. To do this put %NAME% in a template of the letter. Each time of mailing it will be replaced on the name of a subscriber.</p>
<p><b>3) The mails don't come to the mailboxes of Gmail, although they are delivered to the mailboxes of other services. What's wrong?</b></p>
<p>Most likely the address of your post server is brought by Gmail in
black list. Try to contact your hosting provider.</p>
<p><b>4) The script writes that sent 300 mails but only half of them were delivered.
Why?</b></p>
<p>One of the reasons it's the problem with SMPT server of your hosting provider connected with technical problems and failures.<br>Try to contact your hosting provider.</p>
<p><b>5) I can not send a mails through SMTP server. Display the following error:
&quot;Server connection is failed!&quot; What's wrong?</b></p>
<p>The reasons can be several. Perhaps you have incorrectly entered in the settings
address of smtp server or port.<br>Other reason can be that access to the SMTP server is closed by a firewall, 
or SMTP server is temporarily unavailable.</p>
<p><b>6) The picture in HTML format letters isn't displayed.</b></p>
<p>Most e-mail clients and also free e-mail service block any external source's images by default for security reasons
<br>It is easier to make, creating an html template in Outlook
</span>or in others e-mail client</p>
<p><b>7)&nbsp; What is the smtp server?</b></p>
<p>SMTP (Simple Mail Transfer Protocol) - is the server in a network, global or
local which accepts e-mail on further transfer,<br>and also
accepts e-mail from other servers for his local users.</p>
<p><b>8) Attachments aren't displayed in the sent letters. How to fix it?</b></p>
<p>Check the write permissions for the files &quot;admin/addsend.php&quot; and
&quot;admin/editsend.php&quot;, also folder &quot;attach&quot;
must be writable.
</p>");

?>