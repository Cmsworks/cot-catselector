<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */
 
defined('COT_CODE') or die('Wrong URL');


$area = cot_import('area','G','ALP');
$c = cot_import('c','G','ALP');
$userrigths = cot_import('userrigths', 'G', 'ALP');

if(!empty($c))
{
	$subcats = cot_structure_children($area, $c, false, false);
	foreach($subcats as $i => $k)
	{
		if(cot_auth($area, $k, $userrigths))
		{
			$options[$i]['id'] = $k;
			$options[$i]['title'] = $structure[$area][$k]['title'];
		}
	}
	header('Content-Type: application/json');
	echo json_encode($options);
}

?>
