<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

class Mail
{
	public $sendto = array();
	public $acc = array();
	public $abcc = array();
	public $aattach = array();
	public $xheaders = array();
	public $priorities = array( '1 (Highest)', '2 (High)', '3 (Normal)', '4 (Low)', '5 (Lowest)' );
	public $charset = "windows-1251";
	public $ctencoding = "8bit";
	public $receipt = 0;
	public $text_html="text/plain";
	public $smtp_on=false;
	public $names_email = array();

	public function __construct($charset="")
    {
		$this->boundary= "--" . md5( uniqid("myboundary") );

		if( $charset != "" ) {
			$this->charset = strtolower($charset);
			if( $this->charset == "us-ascii" )
			$this->ctencoding = "7bit";
		}
	}
	
	public function check_lat($str)
	{
		if(preg_match('/^[a-z0-9,\.\/`@#\$\&\^\-_\+\*\\\'\"\s\[\]\?\:\;\!%<>\|\(\)]+$/i', $str))
		{ 
			return false;
		}
		else
		{
			return true;
		}
	}

	public function Subject($subject)
	{
		if($this->check_lat($subject) == true) $subject = "=?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $subject, "\r\n" , "  " ))))."?=";
		return $this->xheaders['Subject'] = $subject;
	}

	public function From($from)
	{
		if( ! is_string($from)) {
			return false;
		}

		$temp_mass=explode(';',$from);

		if(count($temp_mass)==2)
		{
			$this->names_email['from']=$temp_mass[0];
			$this->xheaders['From'] = $temp_mass[1];
		}
		else
		{
			$this->names_email['from']='';
			$this->xheaders['From'] = $from;
		}
	}

	public function ReplyTo($address)
	{
		if( ! is_string($address))
		return false;

		$temp_mass=explode(';',$address);

		if(count($temp_mass)==2)
		{
			$this->names_email['Reply-To']=$temp_mass[0];
			$this->xheaders['Reply-To'] = $temp_mass[1];
		}
		else
		{
			$this->names_email['Reply-To']='';
			$this->xheaders['Reply-To'] = $address;
		}
	}

	public function Receipt()
	{
		return $this->receipt = 1;
	}
	
	public function Smtp_aut()
	{
		return $this->smtp_aut = 1;
	}

	public function To($to)
	{
		$temp_mass=explode(';',$to);

		if(count($temp_mass)==2)
		{
			unset($this->sendto);

			$this->sendto[] = $temp_mass[1];
			$this->smtpsendto[$temp_mass[1]] = $temp_mass[1];
			$this->names_email['To'][$temp_mass[1]]=$temp_mass[0];
		}
		else
		{
			unset($this->sendto);

			$this->sendto[] = $to;
			$this->smtpsendto[$to] = $to;
			$this->names_email['To'][$to]='';
		}
    }

	public function Cc($cc)
	{
		if(is_array($cc))
		{
			$this->acc= $cc;

			foreach ($cc as $key => $value)
			{
				$this->smtpsendto[$value] = $value;
			}
		}
		else
		{
			$this->acc[]= $cc;
			$this->smtpsendto[$cc] = $cc;
		}
	}

	public function Bcc($bcc)
	{
		if(is_array($bcc))
		{
			$this->abcc = $bcc;
			foreach ($bcc as $key => $value)
			{
				$this->smtpsendto[$value] = $value;
			}
		}
		else
		{
			$this->abcc[]= $bcc;
			$this->smtpsendto[$bcc] = $bcc;
		}
	}

	public function Body( $body, $text_html="" )
	{
		$this->body = $body;

		if( $text_html == "html" ) $this->text_html = "text/html";
	}

	public function Organization($org)
	{
		if(trim( $org != "" ))
		{
			if($this->check_lat($org) == true) $org = "=?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr($org, "\r\n" , "  "))))."?=";
			$this->xheaders['Organization'] = $org;
		}
	}

	public function Priority($priority)
	{
		if( ! intval( $priority ) )
		return false;

		if( ! isset( $this->priorities[$priority-1]) )
		return false;

		$this->xheaders["X-Priority"] = $this->priorities[$priority-1];

		return true;
	}
	
	public function additionalHeaders($header, $value)
	{
		if(!empty($header) and !empty($value)) $this->xheaders[$header] = $value;
	}

	public function Attach( $filename, $attach_filename="", $filetype = "", $disposition = "inline" )
	{
		if($filetype == "" )
		$filetype = "application/x-unknown-content-type";

		if($this->check_lat($attach_filename) == true) $attach_filename = "=?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $attach_filename, "\r\n" , "  " ))))."?=";
		
		$this->aattach[] = $filename;
		$this->attach_filename[] = $attach_filename;
		$this->actype[] = $filetype;
		$this->adispo[] = $disposition;
	}

	public function BuildMail()
	{
	    global $version;

		$this->headers = "";

        foreach ($this->sendto as $key => $value)
        {
        	if(strlen($this->names_email['To'][$value])) 
			{
				if($this->check_lat($this->names_email['To'][$value]) == true) $temp_mass[]="=?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $this->names_email['To'][$value], "\r\n" , "  " ))))."?= <".$value.">";
				else $temp_mass[]="".strtr($this->names_email['To'][$value], "\r\n" , "  ")." <".$value.">";
			}
        	else $temp_mass[]=$value;
        }

		$this->xheaders['To'] = implode( ", ", $temp_mass );

		if(count($this->acc) > 0 ) $this->xheaders['CC'] = implode( ", ", $this->acc );

		if(count($this->abcc) > 0 ) $this->xheaders['BCC'] = implode( ", ", $this->abcc );

		if( $this->receipt ) {
			if(isset($this->xheaders["Reply-To"])) $this->xheaders["Disposition-Notification-To"] = $this->xheaders["Reply-To"];
			else $this->xheaders["Disposition-Notification-To"] = $this->xheaders['From'];
		}

		if($this->charset != "") {
			$this->xheaders["Mime-Version"] = "1.0";
			$this->xheaders["Content-Type"] = $this->text_html."; charset=$this->charset";
			$this->xheaders["Content-Transfer-Encoding"] = $this->ctencoding;
		}

		$this->xheaders["X-Mailer"] = "PHP Newsletter v $version";

		if(count( $this->aattach ) > 0) {
			$this->_build_attachement();
		} else {
			$this->fullBody = $this->body;
		}

		if($this->smtp_on)
		{
			$user_domen=explode('@',$this->xheaders['From']);

			$this->headers = "Date: ".date("D, j M Y G:i:s")." +0700\r\n";
			$this->headers .= "Message-ID: <".rand().".".date("YmjHis")."@".$user_domen[1].">\r\n";

			reset($this->xheaders);
			while( list( $hdr,$value ) = each( $this->xheaders )  ) {
				if( $hdr == "From" and strlen($this->names_email['from'])) 
				{
					if($this->check_lat($this->names_email['from']) == true) $this->headers .= $hdr.": =?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $this->names_email['from'], "\r\n" , "  " ))))."?= <".$value.">\r\n";
					else $this->headers .= $hdr.": ".strtr( $this->names_email['from'], "\r\n" , "  " )." <".$value.">\r\n";
				}
				elseif( $hdr == "Reply-To" and strlen($this->names_email['Reply-To'])) 
				{
					if($this->check_lat($this->names_email['Reply-To']) == true) $this->headers .= $hdr.": =?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $this->names_email['Reply-To'], "\r\n" , "  " ))))."?= <".$value.">\r\n";
					else $this->headers .= $hdr.": ".strtr( $this->names_email['Reply-To'], "\r\n" , "  " )." <".$value.">\r\n";
				}
				elseif( $hdr != "BCC") $this->headers .= $hdr.": ".$value."\r\n";
			}
		}
		else
		{
			reset($this->xheaders);
			while( list( $hdr,$value ) = each( $this->xheaders )  ) {
				if( $hdr == "From" and strlen($this->names_email['from']))
				{ 
					if($this->check_lat($this->names_email['from']) == true) $this->headers .= $hdr.": =?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $this->names_email['from'], "\r\n" , "  " ))))."?= <".$value.">\r\n";
					else $this->headers .= $hdr.": ".strtr( $this->names_email['from'], "\r\n" , "  " )." <".$value.">\r\n";
				}
				elseif( $hdr == "Reply-To" and strlen($this->names_email['Reply-To'])) 
				{
					if($this->check_lat($this->names_email['Reply-To']) == true) $this->headers .= $hdr.": =?".$this->charset."?Q?".str_replace("+","_",str_replace("%","=",urlencode(strtr( $this->names_email['Reply-To'], "\r\n" , "  " ))))."?= <".$value.">\r\n";
					else $this->headers .= $hdr.": ".strtr( $this->names_email['Reply-To'], "\r\n" , "  " )." <".$value.">\r\n";
				}
				elseif( $hdr != "Subject" and $hdr != "To") $this->headers .= "$hdr: $value\n";
			}
		}
	}

	public function smtp_on($smtp_serv, $login, $pass, $port=25,$timeout=5)
	{
		$this->smtp_on=true;
		$this->smtp_serv=$smtp_serv;
		$this->smtp_login=$login;
		$this->smtp_pass=$pass;
		$this->smtp_port=$port;
		$this->smtp_timeout=$timeout;
	}

	public function get_data($smtp_conn)
	{
		$data="";
		while($str = fgets($smtp_conn,515))
		{
			$data .= $str;
			if(substr($str,3,1) == " ") { break; }
		}
		return $data;
	}

	public function Send()
	{
		$this->BuildMail();
		$this->strTo = implode( ", ", $this->sendto );

    	if(!$this->smtp_on)
		{
			$res = @mail( $this->strTo, $this->xheaders['Subject'], $this->fullBody, $this->headers );
			if (!$res) return false;
			else return true;
		}
		else
		{
			if(!$this->smtp_serv OR !$this->smtp_login OR !$this->smtp_pass OR !$this->smtp_port) return false;

			$user_domen=explode('@',$this->xheaders['From']);

			$this->smtp_log='';
			$this->error='';
			$smtp_conn = fsockopen($this->smtp_serv, $this->smtp_port, $errno, $errstr, $this->smtp_timeout);
			if(!$smtp_conn) { $this->error .= "code:000\n"; fclose($smtp_conn); return false; }

			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

			fputs($smtp_conn,"EHLO ".$user_domen[0]."\r\n");
			$this->smtp_log .= "ME: EHLO ".$user_domen[0]."\n";
			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";
			$code = substr($data,0,3);

			if($code != 250) { $this->error .= "code:250\n"; fclose($smtp_conn); return false; }

            if($this->smtp_aut)
			{
				fputs($smtp_conn,"AUTH CRAM-MD5\r\n");
				$this->smtp_log .= "ME: AUTH CRAM-MD5\n";
				$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";
				$code = substr($data,0,3);

				if($code != 334) {$this->error .= "code:334\n"; fclose($smtp_conn); return false;}

				$challenge = trim($this->get_challenge($data));
				$cram_md5_hash = trim($this->cram_md5_response($this->smtp_login, $this->smtp_pass, $challenge, ""));

				fputs($smtp_conn,"$cram_md5_hash\r\n");

				$this->smtp_log .="ME: pass\n";
				$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

				$code = substr($data,0,3);

				if($code != 235) {$this->error .= "code:235\n"; fclose($smtp_conn); return  false;}
			}
			else
			{
				fputs($smtp_conn,"AUTH LOGIN\r\n");
				$this->smtp_log .= "ME: AUTH LOGIN\n";
				$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";
				$code = substr($data,0,3);

				if($code != 334) {$this->error .= "code:334\n"; fclose($smtp_conn); return false;}

				fputs($smtp_conn,base64_encode($this->smtp_login)."\r\n");
				$this->smtp_log .= "ME: ".base64_encode($this->smtp_login)."\n";
				$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

				$code = substr($data,0,3);
				if($code != 334) {$this->error .= "code:335\n"; fclose($smtp_conn); return  false;}

				fputs($smtp_conn,base64_encode($this->smtp_pass)."\r\n");
				$this->smtp_log .="ME: pass\n";
				$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

				$code = substr($data,0,3);
				if($code != 235) {$this->error .= "code:235\n"; fclose($smtp_conn); return  false;}
			}

			fputs($smtp_conn,"MAIL FROM:<".$this->xheaders['From']."> SIZE=".strlen($this->headers."\r\n".$this->fullBody)."\r\n");
			$this->smtp_log .= "ME: MAIL FROM:<".$this->xheaders['From']."> SIZE=".strlen($this->headers."\r\n".$this->fullBody)."\n";
			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

			$code = substr($data,0,3);
			if($code != 250) {$this->error .= "code:252\n"; fclose($smtp_conn); return  false;}

			$this->strTo = implode( ", ", $this->sendto );

			fputs($smtp_conn,"RCPT TO:<".$this->strTo.">\r\n");
			$this->smtp_log .= "ME: RCPT TO:<".$valuemail.">\n";
			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";
			$code = substr($data,0,3);
			if($code != 250 AND $code != 251) {$this->error .= "code:251\n"; fclose($smtp_conn); return  false;}

			fputs($smtp_conn,"DATA\r\n");
			$this->smtp_log .="ME: DATA\n";
			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

			$code = substr($data,0,3);
			if($code != 354) {$this->error .= "code:354\n"; fclose($smtp_conn); return  false;}

			fputs($smtp_conn,$this->headers."\r\n".$this->fullBody."\r\n.\r\n");
			$this->smtp_log .= "ME: ".$this->headers."\r\n".$this->fullBody."\r\n.\r\n";

			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";

			$code = substr($data,0,3);
			if($code != 250) {$this->error .= "code:253\n"; fclose($smtp_conn); return  false;}

			fputs($smtp_conn,"QUIT\r\n");
			$this->smtp_log .="QUIT\r\n";
			$this->smtp_log .= $data = $this->get_data($smtp_conn)."\n";
			fclose($smtp_conn);
            return true;
		}
	}

	public function Get()
	{
		if(isset($this->smtp_log))
		{
			if($this->smtp_log)
			{
				return $this->smtp_log;
			}
		}

		$this->BuildMail();
		$mail = $this->headers . "\n\n";
		return $mail;
	}

	public function Show_error()
	{
		if(isset($this->error))
		{
			if($this->error)
			{
				return $this->error;
			}
		}
	}

	public function _build_attachement()
	{
		$this->xheaders["Content-Type"] = "multipart/mixed;\n boundary=\"$this->boundary\"";

		$this->fullBody = "This is a multi-part message in MIME format.\n--$this->boundary\n";
		$this->fullBody .= "Content-Type: ".$this->text_html."; charset=$this->charset\nContent-Transfer-Encoding: $this->ctencoding\n\n" . $this->body ."\n";

		$sep= chr(13) . chr(10);

		$ata= array();
		$k=0;

		for( $i=0; $i < count( $this->aattach); $i++ ) {

			$filename = $this->aattach[$i];

			$attach_filename =$this->attach_filename[$i];
			if(strlen($attach_filename)) $basename=basename($attach_filename);
			else $basename = basename($filename);

			$ctype = $this->actype[$i];
			$disposition = $this->adispo[$i];

			if( ! file_exists( $filename) ) {
				echo "Error attaching file : file $filename does not exist!"; exit;
			}
			$subhdr= "--$this->boundary\nContent-type: $ctype;\n name=\"$basename\"\nContent-Transfer-Encoding: base64\nContent-Disposition: $disposition;\n  filename=\"$basename\"\n";
			$ata[$k++] = $subhdr;

			$linesz= filesize( $filename)+1;
			$fp= fopen( $filename, 'r' );
			$ata[$k++] = chunk_split(base64_encode(fread( $fp, $linesz)));
			fclose($fp);
		}
		$this->fullBody .= implode($sep, $ata);
	}

	public function get_challenge($answer)
    {
		preg_match_all('/334\s+(.*)/', $answer, $out);
		return $out[1][0];
    }

    public function cram_md5_response ($username, $password, $challenge, $EOL)
    {
		$challenge = base64_decode($challenge);
		$hash = bin2hex($this->hmac_md5($challenge, $password));
		$response = base64_encode($username . " " . $hash) . "$EOL";
		return $response;
    }

    public function hmac_md5($data, $key='')
    {
		if(extension_loaded('mhash'))
		{
			if($key == '') { $mhash = mhash(MHASH_MD5,$data); }
			else { $mhash = mhash(MHASH_MD5,$data,$key); }
			return $mhash;
		}

		if(!$key)
		{
			return pack('H*',md5($data));
		}

		$key = str_pad($key,64,chr(0x00));

		if(strlen($key) > 64)
		{
			$key = pack("H*",md5($key));
		}

		$k_ipad = $key ^ str_repeat(chr(0x36), 64);
		$k_opad = $key ^ str_repeat(chr(0x5c), 64);
		$hmac = hmac_md5($k_opad . pack("H*",md5($k_ipad . $data)) );

		return $hmac;
	}   
} 

?>