<?php
if (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) == "modules.lng.php") die('Error: Hacking Attempt');
$lang = array();
$lang['birthdaybox_module'] = 'Wir gratulieren...';
$lang['last_posts_info_reply'] = 'Dieses Thema enth�lt mehr als {$num} Antworten. Klicken Sie <a href="showtopic.php?id={@info->id}" target="_blank">hier</a>, um das ganze Thema zu lesen.';
$lang['last_posts_reply'] = 'Die letzten {$num} Beitr�ge in diesem Thema';
$lang['last_x_forumposts'] = 'Letzte {$topicnum} aktive Themen';
$lang['legend_cat_hidden'] = 'Forum ist geschlossen.';
$lang['legend_cat_new_post'] = 'Forum enth�lt neue Beitr�ge.';
$lang['legend_cat_old_post'] = 'Forum enth�lt keine neuen Beitr�ge.';
$lang['legend_cat_re'] = 'Weiterleitung auf eine URL.';
$lang['legend_pm_new'] = 'Neue Nachricht';
$lang['legend_pm_old'] = 'Gelesene Nachrichten';
$lang['legend_title'] = 'Legende';
$lang['legend_topic_new_closed'] = 'Thema geschlossen - Neuen Beitr�ge';
$lang['legend_topic_new_post'] = 'Neue Beitr�ge';
$lang['legend_topic_old_closed'] = 'Thema geschlossen - Keine neuen Beitr�ge';
$lang['legend_topic_old_post'] = 'Keine neuen Beitr�ge';
$lang['mymenu'] = 'Pers�nliches Men�';
$lang['mymenu_newpm_1'] = 'Du hast';
$lang['mymenu_newpm_2'] = 'neue PN';
$lang['mymenu_send'] = 'Anmelden';
$lang['new_pms'] = 'Neue private Nachricht(en)';
$lang['new_pms_since_last_visit'] = 'Sie haben seit Ihrem letzten Besuch {%my->cnpms} neue private Nachricht(en):';
$lang['related_no_results'] = 'Keine verwandten Themen gefunden';
$lang['related_topics'] = 'Verwandte Themen';
$lang['x_comments'] = 'Kommentare ({@row->posts})';
?>