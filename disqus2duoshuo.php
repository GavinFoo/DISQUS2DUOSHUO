<?php
// +----------------------------------------------------------------------
// | DISQUS 2 DUOSHUO [ DISQUS 转换至 多说 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://fuxiaopang.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.gnu.org/licenses/gpl-2.0.txt )
// +----------------------------------------------------------------------
// | Author: Gavin Foo <fuxiaopang@msn.com>
// +----------------------------------------------------------------------


header('Content-type: application/json');

include "xml2json.php";
$xmlNode = simplexml_load_file('disqus.xml');
$arrayData = xmlToArray($xmlNode);

$out = '';

$thread = $arrayData['disqus']['thread'];
foreach ($thread as $t) {
	$newthread['thread_key'] = $t['@dsq:id'];
	$newthread['title'] = $t['title'];
	$newthread['url'] = $t['link'];
	$newthreads[] = $newthread;
}
$out['threads'] = $newthreads;


$post = $arrayData['disqus']['post'];
foreach ($post as $p) {
	$newpost['post_key'] = $p['@dsq:id'];
	$newpost['thread_key'] = $p['thread']['@dsq:id'];
	$newpost['message'] = $p['message'];
	if (isset($p['parent'])) {
		$newpost['parent_key'] = $p['parent'];
	}
	$newpost['author_name'] = $p['author']['name'];
	$newpost['author_email'] = $p['author']['email'];
	$newpost['ip'] = $p['ipAddress'];
	$newpost['created_at'] = date("Y-m-d h:i:s",strtotime($p['createdAt']));
	$newposts[] = $newpost;
}
$out['posts'] = $newposts;

echo json_encode($out);


?>