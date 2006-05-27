<?php
if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "config.inc.php") die('Error: Hacking Attempt');
$config = array();
$config['abozahl'] = 20;
$config['acceptrules'] = 1;
$config['activezahl'] = 20;
$config['asia'] = 0;
$config['asia_charset'] = 'ISO-8859-15';
$config['avfilesize'] = '10240';
$config['avfiletypes'] = '.gif|.jpeg|.png|.jpg';
$config['avheight'] = 100;
$config['avwidth'] = 100;
$config['benchmarkresult'] = 0;
$config['botgfxtest'] = 1;
$config['botgfxtest_colortext'] = 1;
$config['botgfxtest_filter'] = 0;
$config['botgfxtest_format'] = 'jpg';
$config['botgfxtest_height'] = 50;
$config['botgfxtest_posts'] = 1;
$config['botgfxtest_posts_height'] = 40;
$config['botgfxtest_posts_width'] = 170;
$config['botgfxtest_quality'] = 80;
$config['botgfxtest_text_verification'] = 0;
$config['botgfxtest_width'] = 175;
$config['censorstatus'] = 2;
$config['changename_allowed'] = 0;
$config['check_filesystem'] = 0;
$config['confirm_registration'] = '11';
$config['cookie_prefix'] = 'vc';
$config['correctsubdomains'] = 0;
$config['cryptkey'] = '';
$config['database'] = '';
$config['dbprefix'] = 'v_';
$config['dbpw'] = '';
$config['dbsystem'] = 'mysql';
$config['dbuser'] = '';
$config['decimals'] = 2;
$config['dictstatus'] = 1;
$config['edit_delete_time'] = 15;
$config['edit_edit_time'] = 0;
$config['enableflood'] = 1;
$config['enable_jabber'] = 1;
$config['error_handler'] = 0;
$config['error_log'] = 0;
$config['error_reporting'] = 2047;
$config['fdesc'] = 'Your Viscacha Installation!';
$config['floodsearch'] = 1;
$config['fname'] = 'Viscacha';
$config['foffline'] = 0;
$config['forenmail'] = 'admin@localhost';
$config['forumzahl'] = '15';
$config['fpath'] = '';
$config['ftp_path'] = '/';
$config['ftp_port'] = 21;
$config['ftp_pw'] = '';
$config['ftp_server'] = '';
$config['ftp_user'] = '';
$config['furl'] = '';
$config['gdversion'] = 2;
$config['guest_email_optional'] = 0;
$config['gzcompression'] = 3;
$config['gzip'] = 0;
$config['host'] = 'localhost';
$config['hterrordocs'] = 0;
$config['indexpage'] = 'portal';
$config['jabber_pass'] = 'Viscacha';
$config['jabber_server'] = 'jabber.ccc.de';
$config['jabber_user'] = 'ViscachaIM';
$config['langdir'] = 1;
$config['maxaboutlength'] = 10000;
$config['maxeditlength'] = 128;
$config['mineditlength'] = 0;
$config['maxmultiquote'] = 10;
$config['maxnamelength'] = 50;
$config['maxnoticelength'] = 100000;
$config['maxpostlength'] = 10000;
$config['maxpwlength'] = 32;
$config['maxsearchresults'] = 250;
$config['maxsiglength'] = 200;
$config['maxtitlelength'] = 100;
$config['maxurllength'] = 50;
$config['maxurltrenner'] = '...';
$config['maxwordlength'] = 50;
$config['maxwordlengthchar'] = '<br />';
$config['memberrating'] = 1;
$config['memberrating_counter'] = 1;
$config['minnamelength'] = 3;
$config['minpostlength'] = 10;
$config['minpwlength'] = 4;
$config['mintitlelength'] = 6;
$config['mlistenzahl'] = 15;
$config['module_5']['text'] = 'An announcement...';
$config['module_5']['title'] = 'Wichtige Nachricht';
$config['module_6']['items'] = '5';
$config['module_6']['teaserlength'] = '300';
$config['module_7']['topicnum'] = '10';
$config['module_9']['repliesnum'] = '5';
$config['module_10']['relatednum'] = '5';
$config['module_2']['feed'] = 1;
$config['module_2']['title'] = 'Ticker';
$config['mylastzahl'] = 10;
$config['new_dformat4'] = 1;
$config['nocache'] = 1;
$config['optimizetables'] = 'session,abos,replies,topics,pm,uploads,user,vote,votes';
$config['osi_profile'] = 1;
$config['pccron'] = 1;
$config['pccron_maxjobs'] = 3;
$config['pccron_sendlog'] = 0;
$config['pccron_sendlog_email'] = 'admin@localhost';
$config['pccron_uselog'] = 0;
$config['pconnect'] = 0;
$config['pdfcompress'] = 1;
$config['pdfdownload'] = 1;
$config['pmzahl'] = 15;
$config['postrating'] = 1;
$config['postrating_counter'] = 5;
$config['pspell'] = 'pspell';
$config['reduce_endchars'] = 1;
$config['reduce_nl'] = 1;
$config['reduce_url'] = 1;
$config['resizebigimg'] = 1;
$config['resizebigimgwidth'] = 550;
$config['rsschars'] = 200;
$config['rssttl'] = 30;
$config['searchminlength'] = 3;
$config['searchzahl'] = 10;
$config['sendmail'] = 0;
$config['sendmail_host'] = '';
$config['sessionmails'] = 0;
$config['sessionrefresh'] = 180;
$config['sessionsave'] = 15;
$config['session_checkip'] = 3;
$config['showpostcounter'] = 1;
$config['showsubfs'] = 1;
$config['sid_length'] = 32;
$config['sig_bbcode'] = 0;
$config['sig_bbedit'] = 0;
$config['sig_bbh'] = 0;
$config['sig_bbimg'] = 1;
$config['sig_bblist'] = 1;
$config['sig_bbot'] = 0;
$config['smileypath'] = 'images/smileys';
$config['smileysperrow'] = 5;
$config['smileyurl'] = 'images/smileys';
$config['smtp'] = 0;
$config['smtp_auth'] = 0;
$config['smtp_host'] = '';
$config['smtp_password'] = '';
$config['smtp_username'] = '';
$config['spellcheck'] = 0;
$config['spellcheck_ignore'] = 3;
$config['spellcheck_mode'] = 1;
$config['spider_logvisits'] = 1;
$config['spider_pendinglist'] = 0;
$config['syndication'] = 1;
$config['syndication_klipfolio_banner'] = 'images/klipfolio_banner.jpeg';
$config['syndication_klipfolio_icon'] = 'images/klipfolio_icon.gif';
$config['team_mod_dateuntil'] = 1;
$config['templatedir'] = 1;
$config['timezone'] = '+1';
$config['topicuppercase'] = 1;
$config['topiczahl'] = 10;
$config['tpcallow'] = 1;
$config['tpcdownloadspeed'] = 0;
$config['tpcfilesize'] = 512000;
$config['tpcfiletypes'] = '.gif|.jpeg|.jpg|.jpe|.png|.doc|.txt|.rtf|.zip|.rar|.tar|.gz|.pdf|.htm|.html|.css|.js|.bmp';
$config['tpcheight'] = 2048;
$config['tpcmaxuploads'] = 3;
$config['tpcthumbheight'] = 150;
$config['tpcthumbwidth'] = 200;
$config['tpcwidth'] = 2048;
$config['updateboardstats'] = 1;
$config['vcard_dl'] = 1;
$config['vcard_dl_guests'] = 0;
$config['version'] = '0.8 Beta 2';
$config['wordstatus'] = 1;
$config['wordwrap'] = 1;
?>