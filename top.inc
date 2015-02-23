<? $query="SELECT * FROM  `homenumbers` WHERE `whereuse`='home' ";
   $result = mysql_query($query) or die('MySql Error' . mysql_error());
   $row1=mysql_fetch_array($result);?>

<div class="wrap_fullwidth" id='head'>
	<div class='center'>
		<div style="float:left" id="google_translate_element"></div><div style="float:right" align="right"><table><tr><td><span style="font-size:15px">Тел: <?=$row1[phone]?></span></td><td width="10px"></td><td><span style="font-size:15px"><?=$row1[email]?></span></td><td width="10px"></td><td><div style="height:20px"><a class="modalbox fancybox.iframe"  href="message.php"><img class="noborder" src="images/soobshenie.png" alt="" /> </a></div></td><td width="15px"></td>
            <td ><a href="skype:<?=$row1[skype]?>?chat"><img src="http://mystatus.skype.com/smallclassic/<?=$row1[skype]?>" style="border: none;" width="114" height="20" alt="My status" /></a></td>
</tr></table></div>
	</div>
</div>