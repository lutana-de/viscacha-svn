<?php
if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "config.inc.php") die('Error: Hacking Attempt');
$config = array(
'acceptrules' => 1,
'asia' => 0,
'asia_charset' => 'ISO-8859-15',
'avfilesize' => '10240',
'avfiletypes' => '.gif|.jpeg|.png|.jpg',
'avheight' => 100,
'avwidth' => 100,
'benchmarkresult' => 0,
'botgfxtest' => 1,
'botgfxtest_filter' => 0,
'censorstatus' => 2,
'changename_allowed' => 0,
'check_filesystem' => 0,
'confirm_registration' => '11',
'cookie_prefix' => 'vc',
'correctsubdomains' => 0,
'cryptkey' => '',
'database' => '',
'dbprefix' => 'v_',
'dbpw' => '',
'dbsystem' => 'mysql',
'dbuser' => '',
'decimals' => 2,
'dictstatus' => 1,
'edit_delete_time' => 15,
'edit_edit_time' => 0,
'enableflood' => 1,
'enable_jabber' => 1,
'error_reporting' => 2047,
'fdesc' => 'Viscacha',
'floodsearch' => 1,
'fname' => 'Viscacha',
'foffline' => 0,
'forenmail' => 'admin@localhost',
'forumzahl' => '15',
'fpath' => '',
'ftp_path' => '/',
'ftp_port' => 21,
'ftp_pw' => '',
'ftp_server' => '',
'ftp_user' => '',
'furl' => '',
'gdversion' => 2,
'gzcompression' => 3,
'gzip' => 0,
'host' => 'localhost',
'hterrordocs' => 0,
'indexpage' => 'portal',
'jabber_pass' => 'Viscacha',
'jabber_server' => 'jabber.ccc.de',
'jabber_user' => 'ViscachaIM',
'langdir' => 1,
'maxaboutlength' => 10000,
'maxeditlength' => 128,
'maxmultiquote' => 10,
'maxnamelength' => 50,
'maxnoticelength' => 100000,
'maxpostlength' => 10000,
'maxpwlength' => 32,
'maxsearchresults' => 250,
'maxsiglength' => 200,
'maxtitlelength' => 80,
'maxurllength' => 50,
'maxurltrenner' => '...',
'maxwordlength' => 50,
'maxwordlengthchar' => '<br />',
'minnamelength' => 3,
'minpostlength' => 10,
'minpwlength' => 4,
'mintitlelength' => 6,
'mlistenzahl' => 15,
'mylastzahl' => 10,
'new_dformat4' => 1,
'nocache' => 1,
'optimizetables' => 'session,abos,fav,replies,topics,pm,uploads,user,vote,votes',
'osi_profile' => 1,
'pccron' => 1,
'pccron_maxjobs' => 3,
'pccron_sendlog' => 0,
'pccron_sendlog_email' => 'admin@localhost',
'pccron_uselog' => 0,
'pconnect' => 0,
'pdfcompress' => 1,
'pdfdownload' => 1,
'pmzahl' => 15,
'pspell' => 'pspell',
'reduce_endchars' => 1,
'reduce_nl' => 1,
'reduce_url' => 1,
'register_text_verification' => 0,
'resizebigimg' => 1,
'resizebigimgwidth' => 550,
'rsschars' => 200,
'rssttl' => 30,
'searchminlength' => 3,
'sendmail' => 0,
'sendmail_host' => '',
'sessionmails' => 0,
'sessionrefresh' => 180,
'sessionsave' => 15,
'session_checkip' => 1,
'showpostcounter' => 1,
'showsubfs' => 1,
'sid_length' => 32,
'sig_bbcode' => 0,
'sig_bbedit' => 0,
'sig_bbh' => 0,
'sig_bbimg' => 1,
'sig_bblist' => 1,
'sig_bbot' => 0,
'smileysperrow' => 5,
'smtp' => 0,
'smtp_auth' => 0,
'smtp_host' => '',
'smtp_password' => '',
'smtp_username' => '',
'spellcheck' => 0,
'spellcheck_ignore' => 3,
'spellcheck_mode' => 1,
'syndication' => 1,
'syndication_klipfolio_banner' => 'images/klipfolio_banner.jpeg',
'syndication_klipfolio_icon' => 'images/klipfolio_icon.gif',
'team_mod_dateuntil' => 1,
'templatedir' => 1,
'timezone' => '+1',
'topicuppercase' => 1,
'topiczahl' => 10,
'tpcallow' => 1,
'tpcdownloadspeed' => 0,
'tpcfilesize' => 512000,
'tpcfiletypes' => '.gif|.jpeg|.jpg|.jpe|.png|.doc|.txt|.rtf|.zip|.rar|.tar|.gz|.pdf|.htm|.html|.css|.js|.bmp',
'tpcheight' => 2048,
'tpcmaxuploads' => 3,
'tpcthumbheight' => 150,
'tpcthumbwidth' => 200,
'tpcwidth' => 2048,
'updateboardstats' => 1,
'vcard_dl' => 1,
'vcard_dl_guests' => 0,
'version' => '0.8 Beta 1',
'wordstatus' => 1,
'wordwrap' => 1
);
?>