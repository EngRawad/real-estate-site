####################
# About the script #
####################

PHP Newsletter is a universal script for sending e-mail messages from your website containing any information. 
The script is manageable, easy to install and handle, cross-functional and uses minimum of hosting requirements. 
The script uses PHP software programming language and includes a lot of handy functions and attributes such as creation of mailing lists with category sorting, sample letter visual editing, sending e-mails with attachments, e-mailing via SMTP server, ability to use the script as an auto responder, import/export of e-mail address database etc.

###########
# version #
###########

3.5.6

##############
# Requirement #
##############

- PHP 5.1.0 or later;
- MySQL Data Base 4.1.0 or later;
- mail() support.

#################
# Possibilities #
#################

- Sending mail Via smtp server (using sockets), or via a standard function mail();
- opt-in e-mails with ability to unsubscribe;
- selection of mailing mode (plain and html);
- support most of famous character;
- sending e-mails with an unrestricted number of attachments;
- letter personalization;
- notification that the letter has been read;
- setting message priority for sending;
- scheduled e-mail sending and using script as an auto responder*;
- all-purpose administration panel;
- limitless mailing lists;
- category sorting;
- subscriber categorization;
- database backup;
- import of e-mail addresses from text files;
- export of e-mail address data base into a text file;
- logging of sent e-mails;
- New Subscriber Notifications;
- open source code.

*Such an ability is provided if your hosting provider runs Cron. In order to fulfill scheduled mailing, specify the path to script at Cron settings: http://your_site/path_to_script_folder/admin/auto_responder.php
Contact your hosting provider for more detailed information on Cron adjustment.

################
# Installation #
################

Unpack the archive and copy its contents into any folder at your web server ("sendmail" for instance), install the database having linked to

http://your_site/folder_with_script/install.php

After the database installation is over, remove install.php file! If you didn’t manage to install the script via web browser because of some reasons, install it manually. Open admin/lib/connect.inc file in a notepad or any other text editor. Specify the connection settings (data base host or IP, data base name, login and password). Arrange the data base tables MySQL SQL-request from SENDMAIL.spl file. Insert html form code into your web page. Below the html form code is shown:

PHP code:

$url = 'http://your_site/forder_of_script/form.php';

$get_content = @file($url);
$get_content = @implode($get_content, "\r\n");

preg_match("/<div class=\"form\">(.*)<\/div>/isU", $get_content, $out);

echo $out[1];


HTNL code:

<form action=sendmail.php method="post">
<table cellpadding="0" cellspacing="6">
<tr><td><p>Èìÿ</td><td><input size=40 type=text name=name></td></tr>
<tr><td><p>E-mail</td><td><input size=40 type=text name=email></td></tr>
<tr><td></td><td><input type=submit value="Ïîäïèñàòüñÿ"></td></tr>
<input type=hidden name=action value=post>
</form>
</table>


Set permissions (CHMOD) for the following files: addsend.php, editsend.php, import.php and backup.php - 644** and for the following folders: 755**
Open the administration panel and enter the password 1111. Specify the necessary settings.

** Some of the hosting providers may require another permissions (CHMOD) (see FAQ of your hosting provider).


######################
# Commercial version #
######################

According to the customer’s choice I can adapt the script to particular conditions. Different extra function can be added.

########
# NOTE #
########

The script PHP Newsletter, further on "program", is totally free. You can freely distribute, copy, introduce changes in the open source code of the program, only if you preserve the author’s copyright.
Using the program PHP Newsletter for commercial purposes without the author’s permission is prohibited.
You use this program at your own risk. The author bears no responsibility for the program operability, as well as for the losses and damage a data or anything else connected with the usage and work of the program.

(C) 2006-2013 Alexander Yanitsky
Website: http://janicky.com
E-mail: janickiy@mail.ru 
icq: 305-972                 


