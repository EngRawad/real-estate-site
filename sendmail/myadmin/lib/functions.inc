<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

function getRandomCod ()
{
	$maxcount = 32;
	$rand37 = "0123456789abcdef";
	srand((double)microtime()*1000000);
	$RandCod = "";
	for($count = 0; $count < $maxcount; $count++)
	$RandCod .= substr($rand37, rand(1, 15), 1);

	return $RandCod;
}

function error($msg)
{
	echo "<html><head>";
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
	echo "</head><body>";
	echo "<p>".$msg."</p>";
	echo "<p><a href=javascript:history.go(-1);>".BACK."</a></p>";
	echo "</body></html>";
	exit();
}

function root()
{
	if(dirname($_SERVER['SCRIPT_NAME']) == '/' | dirname($_SERVER['SCRIPT_NAME']) == '\\') return '/';
	else return dirname($_SERVER['SCRIPT_NAME']) . '/';
}

function remove_dir($f, $msg)
{
	$dir = opendir($f);
	$msg = str_replace('%DIR%', $f, $msg);

	while(($file = readdir($dir)))
	{
		if(is_file($f."/".$file)) @unlink($f."/".$file);
		else if(is_dir ($f."/".$file) && ($file != ".") && ($file != ".."))
		{
			remove_dir($f."/".$file, $msg);
		}
	}

	closedir($dir);
	rmdir($f);

	echo $msg;
}

function redirect($msg,$redirect,$delay)
{
	echo "<html><head>";
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='$delay; URL=$redirect'>";
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
	echo "</head><body>";
	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style.css\">";
	echo '<div class="block-on-center">';
	echo "$msg";
	echo '</div>';
	echo "</body></html>";
	exit();
}

function check_email ($email)
{
	if(!preg_match("/^[-0-9a-z_\.]+@[-0-9a-z_]+\.([-0-9a-z_\.]+\.)*(?:com|edu|gov|int|mil|net|org|biz|pro|info|tel|travel|museum|coop|name|aero|mobi|[a-z][a-z])$/i", $email))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function charsetlist ($str)
{
	$str = preg_replace("/^utf\-8$/i", CHARUTF8, $str);
	$str = preg_replace("/^iso\-8859\-1$/i", ISO88591, $str);
	$str = preg_replace("/^iso\-8859\-2$/i", ISO88592, $str);
	$str = preg_replace("/^iso\-8859\-3$/i", ISO88593, $str);
	$str = preg_replace("/^iso\-8859\-4$/i", ISO88594, $str);
	$str = preg_replace("/^iso\-8859\-5$/i", ISO88595, $str);
	$str = preg_replace("/^koi8\-r$/i", KOI8R, $str);
	$str = preg_replace("/^koi8\-u$/i", KOI8U, $str);
	$str = preg_replace("/^iso\-8859\-6$/i", ISO88596, $str);
	$str = preg_replace("/^iso\-8859\-8$/i", ISO88598, $str);
	$str = preg_replace("/^iso\-8859\-7$/i", ISO88597, $str);
	$str = preg_replace("/^iso\-8859\-9$/i", ISO88599, $str);
	$str = preg_replace("/^iso\-8859\-10$/i", ISO885910, $str);
	$str = preg_replace("/^iso\-8859\-13$/i", ISO885913, $str);
	$str = preg_replace("/^iso\-8859\-14$/i", ISO885914, $str);
	$str = preg_replace("/^iso\-8859\-15$/i", ISO885915, $str);
	$str = preg_replace("/^iso\-8859\-16$/i", ISO885916, $str);
	$str = preg_replace("/^windows\-1250$/i", WINDOWS1250, $str);
	$str = preg_replace("/^windows\-1251$/i", WINDOWS1251, $str);
	$str = preg_replace("/^windows\-1252$/i", WINDOWS1252, $str);
	$str = preg_replace("/^windows\-1253$/i", WINDOWS1253, $str);
	$str = preg_replace("/^windows\-1254$/i", WINDOWS1254, $str);
	$str = preg_replace("/^windows\-1255$/i", WINDOWS1255, $str);
	$str = preg_replace("/^windows\-1256$/i", WINDOWS1256, $str);
	$str = preg_replace("/^windows\-1257$/i", WINDOWS1257, $str);
	$str = preg_replace("/^windows\-1258$/i", WINDOWS1258, $str);
	$str = preg_replace("/^gb2312$/i", GB2312, $str);
	$str = preg_replace("/^big5$/i", BIG5, $str);
	$str = preg_replace("/^iso-2022\-jp$/i", ISO2022JP, $str);
	$str = preg_replace("/^ks_c_5601\-1987$/i", KSC56011987, $str);
	$str = preg_replace("/^euc\-kr$/i", EUCKR, $str);
	$str = preg_replace("/^windows\-874$/i", WINDOWS874, $str);

	return $str;
}

function get_mime_type($ext) {
	 $mimetypes = Array (
		  ".123" => "application/vnd.lotus-1-2-3",
		  ".3ds" => "image/x-3ds",
		  ".669" => "audio/x-mod",
		  ".a" => "application/x-archive",
		  ".abw" => "application/x-abiword",
		  ".ac3" => "audio/ac3",
		  ".adb" => "text/x-adasrc",
		  ".ads" => "text/x-adasrc",
		  ".afm" => "application/x-font-afm",
		  ".ag" => "image/x-applix-graphics",
		  ".ai" => "application/illustrator",
		  ".aif" => "audio/x-aiff",
		  ".aifc" => "audio/x-aiff",
		  ".aiff" => "audio/x-aiff",
		  ".al" => "application/x-perl",
		  ".arj" => "application/x-arj",
		  ".as" => "application/x-applix-spreadsheet",
		  ".asc" => "text/plain",
		  ".asf" => "video/x-ms-asf",
		  ".asp" => "application/x-asp",
		  ".asx" => "video/x-ms-asf",
		  ".au" => "audio/basic",
		  ".avi" => "video/x-msvideo",
		  ".aw" => "application/x-applix-word",
		  ".bak" => "application/x-trash",
		  ".bcpio" => "application/x-bcpio",
		  ".bdf" => "application/x-font-bdf",
		  ".bib" => "text/x-bibtex",
		  ".bin" => "application/octet-stream",
		  ".blend" => "application/x-blender",
		  ".blender" => "application/x-blender",
		  ".bmp" => "image/bmp",
		  ".bz" => "application/x-bzip",
		  ".bz2" => "application/x-bzip",
		  ".c" => "text/x-csrc",
		  ".c++" => "text/x-c++src",
		  ".cc" => "text/x-c++src",
		  ".cdf" => "application/x-netcdf",
		  ".cdr" => "application/vnd.corel-draw",
		  ".cer" => "application/x-x509-ca-cert",
		  ".cert" => "application/x-x509-ca-cert",
		  ".cgi" => "application/x-cgi",
		  ".cgm" => "image/cgm",
		  ".chrt" => "application/x-kchart",
		  ".class" => "application/x-java",
		  ".cls" => "text/x-tex",
		  ".cpio" => "application/x-cpio",
		  ".cpp" => "text/x-c++src",
		  ".crt" => "application/x-x509-ca-cert",
		  ".cs" => "text/x-csharp",
		  ".csh" => "application/x-shellscript",
		  ".css" => "text/css",
		  ".cssl" => "text/css",
		  ".csv" => "text/x-comma-separated-values",
		  ".cur" => "image/x-win-bitmap",
		  ".cxx" => "text/x-c++src",
		  ".dat" => "video/mpeg",
		  ".dbf" => "application/x-dbase",
		  ".dc" => "application/x-dc-rom",
		  ".dcl" => "text/x-dcl",
		  ".dcm" => "image/x-dcm",
		  ".deb" => "application/x-deb",
		  ".der" => "application/x-x509-ca-cert",
		  ".desktop" => "application/x-desktop",
		  ".dia" => "application/x-dia-diagram",
		  ".diff" => "text/x-patch",
		  ".djv" => "image/vnd.djvu",
		  ".djvu" => "image/vnd.djvu",
		  ".doc" => "application/vnd.ms-word",
		  ".dsl" => "text/x-dsl",
		  ".dtd" => "text/x-dtd",
		  ".dvi" => "application/x-dvi",
		  ".dwg" => "image/vnd.dwg",
		  ".dxf" => "image/vnd.dxf",
		  ".egon" => "application/x-egon",
		  ".el" => "text/x-emacs-lisp",
		  ".eps" => "image/x-eps",
		  ".epsf" => "image/x-eps",
		  ".epsi" => "image/x-eps",
		  ".etheme" => "application/x-e-theme",
		  ".etx" => "text/x-setext",
		  ".exe" => "application/x-ms-dos-executable",
		  ".ez" => "application/andrew-inset",
		  ".f" => "text/x-fortran",
		  ".fig" => "image/x-xfig",
		  ".fits" => "image/x-fits",
		  ".flac" => "audio/x-flac",
		  ".flc" => "video/x-flic",
		  ".fli" => "video/x-flic",
		  ".flw" => "application/x-kivio",
		  ".fo" => "text/x-xslfo",
		  ".g3" => "image/fax-g3",
		  ".gb" => "application/x-gameboy-rom",
		  ".gcrd" => "text/x-vcard",
		  ".gen" => "application/x-genesis-rom",
		  ".gg" => "application/x-sms-rom",
		  ".gif" => "image/gif",
		  ".glade" => "application/x-glade",
		  ".gmo" => "application/x-gettext-translation",
		  ".gnc" => "application/x-gnucash",
		  ".gnucash" => "application/x-gnucash",
		  ".gnumeric" => "application/x-gnumeric",
		  ".gra" => "application/x-graphite",
		  ".gsf" => "application/x-font-type1",
		  ".gtar" => "application/x-gtar",
		  ".gz" => "application/x-gzip",
		  ".h" => "text/x-chdr",
		  ".h++" => "text/x-chdr",
		  ".hdf" => "application/x-hdf",
		  ".hh" => "text/x-c++hdr",
		  ".hp" => "text/x-chdr",
		  ".hpgl" => "application/vnd.hp-hpgl",
		  ".hs" => "text/x-haskell",
		  ".htm" => "text/html",
		  ".html" => "text/html",
		  ".icb" => "image/x-icb",
		  ".ico" => "image/x-ico",
		  ".ics" => "text/calendar",
		  ".idl" => "text/x-idl",
		  ".ief" => "image/ief",
		  ".iff" => "image/x-iff",
		  ".ilbm" => "image/x-ilbm",
		  ".iso" => "application/x-cd-image",
		  ".it" => "audio/x-it",
		  ".jar" => "application/x-jar",
		  ".java" => "text/x-java",
		  ".jng" => "image/x-jng",
		  ".jp2" => "image/jpeg2000",
		  ".jpe" => "image/jpeg",
		  ".jpeg" => "image/jpeg",
		  ".jpg" => "image/jpeg",
		  ".jpr" => "application/x-jbuilder-project",
		  ".jpx" => "application/x-jbuilder-project",
		  ".js" => "application/x-javascript",
		  ".karbon" => "application/x-karbon",
		  ".kdelnk" => "application/x-desktop",
		  ".kfo" => "application/x-kformula",
		  ".kil" => "application/x-killustrator",
		  ".kon" => "application/x-kontour",
		  ".kpm" => "application/x-kpovmodeler",
		  ".kpr" => "application/x-kpresenter",
		  ".kpt" => "application/x-kpresenter",
		  ".kra" => "application/x-krita",
		  ".ksp" => "application/x-kspread",
		  ".kud" => "application/x-kugar",
		  ".kwd" => "application/x-kword",
		  ".kwt" => "application/x-kword",
		  ".la" => "application/x-shared-library-la",
		  ".lha" => "application/x-lha",
		  ".lhs" => "text/x-literate-haskell",
		  ".lhz" => "application/x-lhz",
		  ".log" => "text/x-log",
		  ".ltx" => "text/x-tex",
		  ".lwo" => "image/x-lwo",
		  ".lwob" => "image/x-lwo",
		  ".lws" => "image/x-lws",
		  ".lyx" => "application/x-lyx",
		  ".lzh" => "application/x-lha",
		  ".lzo" => "application/x-lzop",
		  ".m" => "text/x-objcsrc",
		  ".m15" => "audio/x-mod",
		  ".m3u" => "audio/x-mpegurl",
		  ".man" => "application/x-troff-man",
		  ".md" => "application/x-genesis-rom",
		  ".me" => "text/x-troff-me",
		  ".mgp" => "application/x-magicpoint",
		  ".mid" => "audio/midi",
		  ".midi" => "audio/midi",
		  ".mif" => "application/x-mif",
		  ".mkv" => "application/x-matroska",
		  ".mm" => "text/x-troff-mm",
		  ".mml" => "text/mathml",
		  ".mng" => "video/x-mng",
		  ".moc" => "text/x-moc",
		  ".mod" => "audio/x-mod",
		  ".moov" => "video/quicktime",
		  ".mov" => "video/quicktime",
		  ".movie" => "video/x-sgi-movie",
		  ".mp2" => "video/mpeg",
		  ".mp3" => "audio/x-mp3",
		  ".mpe" => "video/mpeg",
		  ".mpeg" => "video/mpeg",
		  ".mpg" => "video/mpeg",
		  ".ms" => "text/x-troff-ms",
		  ".msod" => "image/x-msod",
		  ".msx" => "application/x-msx-rom",
		  ".mtm" => "audio/x-mod",
		  ".n64" => "application/x-n64-rom",
		  ".nc" => "application/x-netcdf",
		  ".nes" => "application/x-nes-rom",
		  ".nsv" => "video/x-nsv",
		  ".o" => "application/x-object",
		  ".obj" => "application/x-tgif",
		  ".oda" => "application/oda",
		  ".ogg" => "application/ogg",
		  ".old" => "application/x-trash",
		  ".oleo" => "application/x-oleo",
		  ".p" => "text/x-pascal",
		  ".p12" => "application/x-pkcs12",
		  ".p7s" => "application/pkcs7-signature",
		  ".pas" => "text/x-pascal",
		  ".patch" => "text/x-patch",
		  ".pbm" => "image/x-portable-bitmap",
		  ".pcd" => "image/x-photo-cd",
		  ".pcf" => "application/x-font-pcf",
		  ".pcl" => "application/vnd.hp-pcl",
		  ".pdb" => "application/vnd.palm",
		  ".pdf" => "application/pdf",
		  ".pem" => "application/x-x509-ca-cert",
		  ".perl" => "application/x-perl",
		  ".pfa" => "application/x-font-type1",
		  ".pfb" => "application/x-font-type1",
		  ".pfx" => "application/x-pkcs12",
		  ".pgm" => "image/x-portable-graymap",
		  ".pgn" => "application/x-chess-pgn",
		  ".pgp" => "application/pgp",
		  ".php" => "application/x-php",
		  ".php3" => "application/x-php",
		  ".php4" => "application/x-php",
		  ".pict" => "image/x-pict",
		  ".pict1" => "image/x-pict",
		  ".pict2" => "image/x-pict",
		  ".pl" => "application/x-perl",
		  ".pls" => "audio/x-scpls",
		  ".pm" => "application/x-perl",
		  ".png" => "image/png",
		  ".pnm" => "image/x-portable-anymap",
		  ".po" => "text/x-gettext-translation",
		  ".pot" => "text/x-gettext-translation-template",
		  ".ppm" => "image/x-portable-pixmap",
		  ".pps" => "application/vnd.ms-powerpoint",
		  ".ppt" => "application/vnd.ms-powerpoint",
		  ".ppz" => "application/vnd.ms-powerpoint",
		  ".ps" => "application/postscript",
		  ".psd" => "image/x-psd",
		  ".psf" => "application/x-font-linux-psf",
		  ".psid" => "audio/prs.sid",
		  ".pw" => "application/x-pw",
		  ".py" => "application/x-python",
		  ".pyc" => "application/x-python-bytecode",
		  ".pyo" => "application/x-python-bytecode",
		  ".qif" => "application/x-qw",
		  ".qt" => "video/quicktime",
		  ".qtvr" => "video/quicktime",
		  ".ra" => "audio/x-pn-realaudio",
		  ".ram" => "audio/x-pn-realaudio",
		  ".rar" => "application/x-rar",
		  ".ras" => "image/x-cmu-raster",
		  ".rdf" => "text/rdf",
		  ".rej" => "application/x-reject",
		  ".rgb" => "image/x-rgb",
		  ".rle" => "image/rle",
		  ".rm" => "audio/x-pn-realaudio",
		  ".roff" => "application/x-troff",
		  ".rpm" => "application/x-rpm",
		  ".rss" => "text/rss",
		  ".rtf" => "application/rtf",
		  ".rtx" => "text/richtext",
		  ".s3m" => "audio/x-s3m",
		  ".sam" => "application/x-amipro",
		  ".scm" => "text/x-scheme",
		  ".sda" => "application/vnd.stardivision.draw",
		  ".sdc" => "application/vnd.stardivision.calc",
		  ".sdd" => "application/vnd.stardivision.impress",
		  ".sdp" => "application/vnd.stardivision.impress",
		  ".sds" => "application/vnd.stardivision.chart",
		  ".sdw" => "application/vnd.stardivision.writer",
		  ".sgi" => "image/x-sgi",
		  ".sgl" => "application/vnd.stardivision.writer",
		  ".sgm" => "text/sgml",
		  ".sgml" => "text/sgml",
		  ".sh" => "application/x-shellscript",
		  ".shar" => "application/x-shar",
		  ".siag" => "application/x-siag",
		  ".sid" => "audio/prs.sid",
		  ".sik" => "application/x-trash",
		  ".slk" => "text/spreadsheet",
		  ".smd" => "application/vnd.stardivision.mail",
		  ".smf" => "application/vnd.stardivision.math",
		  ".smi" => "application/smil",
		  ".smil" => "application/smil",
		  ".sml" => "application/smil",
		  ".sms" => "application/x-sms-rom",
		  ".snd" => "audio/basic",
		  ".so" => "application/x-sharedlib",
		  ".spd" => "application/x-font-speedo",
		  ".sql" => "text/x-sql",
		  ".src" => "application/x-wais-source",
		  ".stc" => "application/vnd.sun.xml.calc.template",
		  ".std" => "application/vnd.sun.xml.draw.template",
		  ".sti" => "application/vnd.sun.xml.impress.template",
		  ".stm" => "audio/x-stm",
		  ".stw" => "application/vnd.sun.xml.writer.template",
		  ".sty" => "text/x-tex",
		  ".sun" => "image/x-sun-raster",
		  ".sv4cpio" => "application/x-sv4cpio",
		  ".sv4crc" => "application/x-sv4crc",
		  ".svg" => "image/svg+xml",
		  ".swf" => "application/x-shockwave-flash",
		  ".sxc" => "application/vnd.sun.xml.calc",
		  ".sxd" => "application/vnd.sun.xml.draw",
		  ".sxg" => "application/vnd.sun.xml.writer.global",
		  ".sxi" => "application/vnd.sun.xml.impress",
		  ".sxm" => "application/vnd.sun.xml.math",
		  ".sxw" => "application/vnd.sun.xml.writer",
		  ".sylk" => "text/spreadsheet",
		  ".t" => "application/x-troff",
		  ".tar" => "application/x-tar",
		  ".tcl" => "text/x-tcl",
		  ".tcpalette" => "application/x-terminal-color-palette",
		  ".tex" => "text/x-tex",
		  ".texi" => "text/x-texinfo",
		  ".texinfo" => "text/x-texinfo",
		  ".tga" => "image/x-tga",
		  ".tgz" => "application/x-compressed-tar",
		  ".theme" => "application/x-theme",
		  ".tif" => "image/tiff",
		  ".tiff" => "image/tiff",
		  ".tk" => "text/x-tcl",
		  ".torrent" => "application/x-bittorrent",
		  ".tr" => "application/x-troff",
		  ".ts" => "application/x-linguist",
		  ".tsv" => "text/tab-separated-values",
		  ".ttf" => "application/x-font-ttf",
		  ".txt" => "text/plain",
		  ".tzo" => "application/x-tzo",
		  ".ui" => "application/x-designer",
		  ".uil" => "text/x-uil",
		  ".ult" => "audio/x-mod",
		  ".uni" => "audio/x-mod",
		  ".uri" => "text/x-uri",
		  ".url" => "text/x-uri",
		  ".ustar" => "application/x-ustar",
		  ".vcf" => "text/x-vcalendar",
		  ".vcs" => "text/x-vcalendar",
		  ".vct" => "text/x-vcard",
		  ".vob" => "video/mpeg",
		  ".voc" => "audio/x-voc",
		  ".vor" => "application/vnd.stardivision.writer",
		  ".vpp" => "application/x-extension-vpp",
		  ".wav" => "audio/x-wav",
		  ".wb1" => "application/x-quattropro",
		  ".wb2" => "application/x-quattropro",
		  ".wb3" => "application/x-quattropro",
		  ".wk1" => "application/vnd.lotus-1-2-3",
		  ".wk3" => "application/vnd.lotus-1-2-3",
		  ".wk4" => "application/vnd.lotus-1-2-3",
		  ".wks" => "application/vnd.lotus-1-2-3",
		  ".wmf" => "image/x-wmf",
		  ".wml" => "text/vnd.wap.wml",
		  ".wmv" => "video/x-ms-wmv",
		  ".wpd" => "application/vnd.wordperfect",
		  ".wpg" => "application/x-wpg",
		  ".wri" => "application/x-mswrite",
		  ".wrl" => "model/vrml",
		  ".xac" => "application/x-gnucash",
		  ".xbel" => "application/x-xbel",
		  ".xbm" => "image/x-xbitmap",
		  ".xcf" => "image/x-xcf",
		  ".xhtml" => "application/xhtml+xml",
		  ".xi" => "audio/x-xi",
		  ".xla" => "application/vnd.ms-excel",
		  ".xlc" => "application/vnd.ms-excel",
		  ".xld" => "application/vnd.ms-excel",
		  ".xll" => "application/vnd.ms-excel",
		  ".xlm" => "application/vnd.ms-excel",
		  ".xls" => "application/vnd.ms-excel",
		  ".xlt" => "application/vnd.ms-excel",
		  ".xlw" => "application/vnd.ms-excel",
		  ".xm" => "audio/x-xm",
		  ".xmi" => "text/x-xmi",
		  ".xml" => "text/xml",
		  ".xpm" => "image/x-xpixmap",
		  ".xsl" => "text/x-xslt",
		  ".xslfo" => "text/x-xslfo",
		  ".xslt" => "text/x-xslt",
		  ".xwd" => "image/x-xwindowdump",
		  ".z" => "application/x-compress",
		  ".zabw" => "application/x-abiword",
		  ".zip" => "application/zip",
		  ".zoo" => "application/x-zoo"
	 );

	 $ext=trim(strtolower($ext));
	 if ($ext!='' && isset($mimetypes[$ext])) {
		  return $mimetypes[$ext];
	 }
	 else {
		  return "application/force-download";
	 }
}

function showerror($code)
{
	$code = str_replace('code:000',ERROR000,$code);
	$code = str_replace('code:250',ERROR250,$code);
	$code = str_replace('code:334',ERROR334,$code);
	$code = str_replace('code:335',ERROR335,$code);
	$code = str_replace('code:235',ERROR235,$code);
	$code = str_replace('code:252',ERROR252,$code);
	$code = str_replace('code:251',ERROR251,$code);
	$code = str_replace('code:354',ERROR354,$code);
	$code = str_replace('code:253',ERROR253,$code);

	return $code;
}

function logsend($count)
{
	global $dbh;

	$insert = "INSERT INTO ".DB_LOG." VALUES (0, $count, now())";
	$result = $dbh->prepare($insert);

	$result->execute();
}

function remove_html_tags($str)
{
	$tags = array ("/<script[^>]*?>.*?<\/script>/si",
				"/<[\/\!]*?[^<>]*?>/si",
				"/&(quot|#34);/i",
				"/&(laquo|#171);/i",
				"/&(raquo|#187);/i",
				"/&(hellip|#8230);/i",
				"/&(amp|#38);/i",
				"/&(lt|#60);/i",
				"/&(gt|#62);/i",
				"/&(nbsp|#160);/i",
				"/&(iexcl|#161);/i",
				"/&(cent|#162);/i",
				"/&(pound|#163);/i",
				"/&(copy|#169);/i",
				"/&#(\d+);/e"
				 );

	$replace = array ("",
 					"",
					"\"",
					"\"",
					"\"",
					"...",
					 "&",
					"<",
					">",
					" ",
					chr(161),
					chr(162),
					chr(163),
					chr(169),
					"chr(\\1)"
					);

	$str = preg_replace($tags, $replace, $str);

	return $str;
}

?>