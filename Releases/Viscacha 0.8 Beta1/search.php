<?php
/*
	Viscacha - A bulletin board solution for easily managing your content
	Copyright (C) 2004-2006  Matthias Mohr, MaMo Net
	
	Author: Matthias Mohr
	Publisher: http://www.mamo-net.de
	Start Date: May 22, 2004

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

error_reporting(E_ALL);

DEFINE('SCRIPTNAME', 'search');

include ("data/config.inc.php");
include ("classes/function.viscacha_frontend.php");

$zeitmessung1 = t1();

$slog = new slog();
$my = $slog->logged();
$lang->init($my->language);
$tpl = new tpl();
$my->p = $slog->Permissions();
$my->pb = $slog->GlobalPermissions();

if ($my->p['search'] == 0) {
	error($lang->phrase('query_string_error'));
}

$breadcrumb->Add($lang->phrase('search'));

// Suchanfragen längerfristig speichern können!
// Googlify

if ($_GET['action'] == "search") {

	if ($config['floodsearch'] == 1) {
		if (flood_protect() == FALSE) {
			error($lang->phrase('flood_control'));
		}
	}
	$boards = array();
	if (isset($_POST['boards']) && is_array($_POST['boards'])) {
		foreach ($_POST['boards'] as $b) {
			if (is_id(trim($b))) {
				$boards[] = $b;
			}
		}
	}
	$search = preg_replace("/(\s){1,}/is"," ",$_POST['search']);
    $search = preg_replace("/\*{1,}/is",'*',$search);
	$ignorewords = $lang->get_words();
	$word_seperator = "\\.\\,;:\\+!\\?\\_\\|\s\"'\\#\\[\\]\\%\\{\\}\\(\\)\\/\\\\";
	$searchwords = preg_split('/['.$word_seperator.']+?/', $search, -1, PREG_SPLIT_NO_EMPTY);

	$ignored = array();
	$used = array();
	foreach ($searchwords as $sw) {
		$sw = trim($sw);
		if ($sw{0} == '-') {
			$sw2 = substr($sw, 1);
		}
		else {
			$sw2 = $sw;
		}
		if (!is_array($sw2)) {
			
		}
		$sw2 = str_replace('*','',$sw2);
		if (in_array(strtolower($sw2), $ignorewords) || strxlen($sw2) < $config['searchminlength']) {
			$ignored[] = $sw2;
		}
		else {
			$used[] = str_replace('*', '%', $sw);
		}
	}

	if (strxlen($_POST['name']) >= $config['searchminlength']) {
		$result = $db->query('SELECT id FROM '.$db->pre.'user WHERE name="'.$_POST['name'].'"');
		if ($db->num_rows() == 1) {
			$name = $db->fetch_assoc($result);
			$rname = $name['id'];
		}
		else {
			$rname = $_POST['name'];
		}
	}

	if ((count($used) == 0 || count($used) > 8) && empty($rname)) {
		error($lang->phrase('illegal_search'));
	}

	$sql_where_like = '';
	
	if ($_POST['opt_2'] == 1) {
		$op = 'OR ';
	}
	else {
		$op = 'AND ';
	}
	if ($_POST['opt_1'] == 1) {
		$binary = ' BINARY';
	}
	else {
		$binary = '';
	}
	
	$range = count($used);
	for ($i=0;$i<$range;$i++) {
		$str = $used[$i];
		if ($str{0} == '-') {
			$not = 'NOT ';
			$str = substr($str, 1);
		}
		else {
			$not = '';
		}
		if ($i > 0) {
			$sql_where_like .= $op.$not;
		}
		if ($_POST['opt_0'] == 0) {
			$sql_where_like .= "(r.topic LIKE{$binary} '%{$str}%' OR r.comment LIKE{$binary} '%{$str}%') ";
		}
		else {
			$sql_where_like .= "r.topic LIKE{$binary} '%{$str}%' ";
		}
	}

	$sql_where = $slog->sqlinboards('r.board', 1)." ";

	if (count($used) > 0) {
		$sql_where .= "({$sql_where_like}) ";
	}

	if (isset($rname)) {
		if (count($used) > 0) {
			$sql_where .= "AND ";
		}
		$sql_where .= "r.name = '{$rname}' ";
	}

	if (strxlen($_POST['name']) >= $config['searchminlength']) {
		$used[] = $_POST['name'];
	}
	else {
		$ignored[] = $_POST['name'];
	}
	
	$having = '';
	if ($_POST['temp'] > 0 && $_POST['temp'] < 366) {
		$sql_where .= "AND t.last ";
		if ($_POST['temp2'] == 1) {
			$sql_where .= '<=';
		}
		else {
			$sql_where .= '>=';
		}
		$timestamp = time()-60*60*24*$_POST['temp'];
		$sql_where .= " '{$timestamp}' ";
		$having = " LEFT JOIN {$db->pre}topics AS t ON t.id = r.topic_id";
	}

	$sql = "SELECT r.topic_id FROM {$db->pre}replies AS r{$having} WHERE {$sql_where} GROUP BY r.topic_id LIMIT {$config['maxsearchresults']}";
	$result = $db->query($sql,__LINE__,__FILE__);
	
	$searchresult = array();
	while ($row = $db->fetch_assoc($result)) {
		$searchresult[] = $row['topic_id'];
	}

	if (count($searchresult) > 0) {
		$data = array(
		'ids' => $searchresult,
		'ignored' => $ignored,
		'used' => $used
		);
		$vals = array('search','name','boards','opt_0','opt_1','opt_2','temp','temp2','sort','order');
		foreach ($vals as $v) {
			$data[$v] = $_POST[$v];
		}
		$fid = md5(microtime());
		file_put_contents('cache/search/'.$fid.'.inc.php', serialize($data));
		viscacha_header('Location: search.php?action=result&fid='.$fid.SID2URL_JS_x);
	}
	else {
		error($lang->phrase('search_nothingfound'), 'search.php'.SID2URL_1);
	}
}
elseif ($_GET['action'] == "result") {

	echo $tpl->parse("header");
	echo $tpl->parse("menu");

	$file = 'cache/search/'.$_GET['fid'].'.inc.php';
	$resfile = 'temp/searchresult/'.$_GET['fid'].'.inc.php';
	if (!file_exists($file)) {
		error($lang->phrase('search_doesntexist'), 'search.php'.SID2URL_1);
	}
	$data = file_get_contents($file);
	$data = unserialize($data);

	$ignored = array();
	foreach ($data['ignored'] as $row) {
	    $row = trim($row);
	    if (!empty($row)) {
	        $ignored[] = $row;
	    }
	}

	$start = $_GET['page']*$config['forumzahl'];
	$start = $start-$config['forumzahl'];
	
	if (!file_exists($resfile)) {
		switch ($data['sort']) {
			case 'topic':
			case 'posts':
			case 'date':
			case 'last':
				$order = $data['sort'];
				break;
			case 'name':
			case 'board':
				$order = $data['sort'].", last";
				break;
			default:
				$order = 'last';
				break;
		}
	
		if ($data['order'] == 1) {
			$order .= ' ASC';
		}
		else {
			$order .= ' DESC';
		}
		$result = $db->query("
		SELECT prefix, vquestion, posts, mark, id, board, topic, date, status, last, last_name, sticky, name 
		FROM {$db->pre}topics WHERE id IN (".implode(',', $data['ids']).") ".$slog->sqlinboards('board')." 
		ORDER BY {$order}"
		,__LINE__,__FILE__);
		
		$cache = array();
		while ($row = $gpc->prepare($db->fetch_object($result))) {
			$cache[] = $row;
		}

		if (!extension_loaded("zlib") || !function_exists('gzcompress')) {
			file_put_contents($resfile, serialize($cache));
		}
		else {
			file_put_contents($resfile, gzcompress(serialize($cache), 9));
		}
		
	}
	else {
		$cache = file_get_contents($resfile);
		if (!extension_loaded("zlib") || !function_exists('gzcompress')) {
			$cache = unserialize($cache);
		}
		else {
			$cache = unserialize(gzuncompress($cache));
		}
	}

	$count = count($cache);
	$pages = array_chunk($cache, $config['forumzahl']);

	$temp = pages($count, 'forumzahl', "search.php?action=result&amp;fid=".$_GET['fid'].SID2URL_x."&amp;");
	
	$forums = cache_cat_bid();
	$memberdata = cache_memberdata();
	
	$inner['index_bit'] = '';

	if (!isset($pages[$_GET['page']-1])) {
		$pages[$_GET['page']-1] = array();
	}
	
	$prefix = cache_prefix();
	$mymodules->load('search_result_top');

	foreach ($pages[$_GET['page']-1] as $row) {
		$pref = '';
		$showprefix = FALSE;
		if (isset($prefix[$row->board][$row->prefix]) && $row->prefix > 0) {
			$showprefix = $prefix[$row->board][$row->prefix];
		}
		else {
			$showprefix = null;
		}
		
		if(is_id($row->name) && isset($memberdata[$row->name])) {
			$row->mid = $row->name;
			$row->name = $memberdata[$row->name];
		}
		else {
			$row->mid = FALSE;
		}
		
		if (is_id($row->last_name) && isset($memberdata[$row->last_name])) {
			$row->last_name = $memberdata[$row->last_name];
		}
		
		$rstart = str_date($lang->phrase('dformat1'),times($row->date));
		$rlast = str_date($lang->phrase('dformat1'),times($row->last));
		
		if ($row->mark == 'n') {
			$pref .= $lang->phrase('forum_mark_n'); 
		}
		elseif ($row->mark == 'a') {
			$pref .= $lang->phrase('forum_mark_a');
		}
		elseif ($row->status == '2') {
			$pref .= $lang->phrase('forum_moved');
		}
		elseif ($row->sticky == '1') {
			$pref .= $lang->phrase('forum_announcement');
		}

		if ((isset($my->mark['t'][$row->id]) && $my->mark['t'][$row->id] > $row->last) || $row->last < $my->clv) {
	 		$firstnew = 0;
			if ($row->status == 1 || $row->status == 2) {
			   	$alt = $lang->phrase('forum_icon_closed');
				$src = $tpl->img('dir_closed');
			}
			else {
			   	$alt = $lang->phrase('forum_icon_old');
			   	$src = $tpl->img('dir_open');
	 		}
	 	}
	  	else {
	  		$firstnew = 1;
			if ($row->status == 1 || $row->status == 2) {
				$alt = $lang->phrase('forum_icon_closed');
				$src = $tpl->img('dir_closed2');
			}
			else {
				$alt = $lang->phrase('forum_icon_new');
				$src = $tpl->img('dir_open2');
			}
		}
		$qhighlight = urlencode(implode(' ', $data['used']));
		
		$mymodules->load('search_result_bit');
		$inner['index_bit'] .= $tpl->parse("search/result_bit");
	}
	echo $tpl->parse("search/result");
	
	$mymodules->load('search_result_bottom');
	
}
elseif ($_GET['action'] == "active") {

	$breadcrumb->AddUrl('search.php'.SID2URL_1);
	$breadcrumb->Add($lang->phrase('active_topics_title'));

	echo $tpl->parse("header");
	echo $tpl->parse("menu");

    unset($count);

	$sqlwhere = "";
	if ($_GET['type'] == 'abo') {
	    if (!$my->vlogin) {
	        error($lang->phrase('not_allowed'));
	    }
		$timestamp = $my->clv;
		$ids = array();
   		$result = $db->query("SELECT tid FROM {$db->pre}abos WHERE mid = '{$my->id}'",__LINE__,__FILE__);
   		if ($db->num_rows($result) > 0) {
       		while ($row = $db->fetch_assoc($result)) {
       			$ids[] = $row['tid'];
       		}
       		$sqlwhere .= " id IN (".implode(',', $ids).") AND ";
   		}
   		else {
		    $count = 0;
	        echo $tpl->parse("search/active");
   		}
	}
	elseif (preg_match("/(days|hours)-(\d{1,2})/i", $_GET['type'], $type)) {
		$type[1] = strtolower($type[1]);
		if (empty($type[1])) {
			$type[1] = 'days';
		}
		if (empty($type[2])) {
			$type[2] = 1;
		}
		if ($type[2] > 14) {
			$type[2] = 14;
		}
		if ($type[1] == 'days') {
			$type[2] = $type[2]*24;
		}
		$timestamp = time()-60*60*$type[2];
	}
	else { // $_GET['type'] == 'lastvisit'
		if ($my->clv < 1) {
		    $count = 0;
	        echo $tpl->parse("search/active");
	    }
		$timestamp = $my->clv;
	}
	
	$mymodules->load('search_active_top');
	
	if (!isset($count)) {
    	$sqlwhere = " last > '{$timestamp}' ";
    	
    	$result = $db->query("
    	SELECT prefix, vquestion, posts, mark, id, board, topic, date, status, last, last_name, sticky, name 
    	FROM {$db->pre}topics WHERE".$sqlwhere.$slog->sqlinboards('board')." 
    	ORDER BY last DESC"
    	,__LINE__,__FILE__);
    	$count = $db->num_rows($result);
    		
    	if ($count > 0) {
    		$temp = pages($count, 'forumzahl', "search.php?action=result&amp;fid=".$_GET['fid'].SID2URL_x."&amp;");
    		
    		$forums = cache_cat_bid();
    		$prefix = cache_prefix();
    		$memberdata = cache_memberdata();
    		$inner['index_bit'] = '';
    	
    		while ($row = $gpc->prepare($db->fetch_object($result))) {
    			$pref = '';
    			$showprefix = '';
    			if ($row->prefix > 0 && isset($prefix[$row->board][$row->prefix])) {
    				$showprefix = $prefix[$row->board][$row->prefix];
    			}
    			
    			if(is_id($row->name) && isset($memberdata[$row->name])) {
    				$row->mid = $row->name;
    				$row->name = $memberdata[$row->name];
    			}
    			else {
    				$row->mid = FALSE;
    			}
    			
    			if (is_id($row->last_name) && isset($memberdata[$row->last_name])) {
    				$row->last_name = $memberdata[$row->last_name];
    			}
    			
    			$rstart = str_date($lang->phrase('dformat1'),times($row->date));
    			$rlast = str_date($lang->phrase('dformat1'),times($row->last));
    			
    			if ($row->mark == 'n') {
    				$pref .= $lang->phrase('forum_mark_n'); 
    			}
    			elseif ($row->mark == 'a') {
    				$pref .= $lang->phrase('forum_mark_a');
    			}
    			elseif ($row->status == '2') {
    				$pref .= $lang->phrase('forum_moved');
    			}
    			elseif ($row->sticky == '1') {
    				$pref .= $lang->phrase('forum_announcement');
    			}
    	
    			if ((isset($my->mark['t'][$row->id]) && $my->mark['t'][$row->id] > $row->last) || $row->last < $my->clv) {
    		 		$firstnew = 0;
    				if ($row->status == 1 || $row->status == 2) {
    				   	$alt = $lang->phrase('forum_icon_closed');
    					$src = $tpl->img('dir_closed');
    				}
    				else {
    				   	$alt = $lang->phrase('forum_icon_old');
    				   	$src = $tpl->img('dir_open');
    		 		}
    		 	}
    		  	else {
    		  		$firstnew = 1;
    				if ($row->status == 1 || $row->status == 2) {
    					$alt = $lang->phrase('forum_icon_closed');
    					$src = $tpl->img('dir_closed2');
    				}
    				else {
    					$alt = $lang->phrase('forum_icon_new');
    					$src = $tpl->img('dir_open2');
    				}
    			}
    			$mymodules->load('search_active_bit');
    			$inner['index_bit'] .= $tpl->parse("search/active_bit");
    		}
    	}
    	echo $tpl->parse("search/active");
    	$mymodules->load('search_active_bottom');
	}
}
else {
	$forums = BoardSubs();
	echo $tpl->parse("header");
	echo $tpl->parse("menu");
	$mymodules->load('search_top');
	echo $tpl->parse("search/index");
	$mymodules->load('search_bottom');
}

$slog->updatelogged();
$zeitmessung = t2();
echo $tpl->parse("footer");
$phpdoc->Out();
$db->close();
?>
