<?PHP
require_once ("include/fg_membersite.php"); 

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('olga.hol.es');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('markareno@gmail.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'mysql.hostinger.ru',  
                      /*username*/'u468914271_olga',
                      /*password*/'Power2013',
                      /*database name*/'u468914271_demo',
                      /*table name*/'main');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('qSRcVS6DrTzrPvr');


?>