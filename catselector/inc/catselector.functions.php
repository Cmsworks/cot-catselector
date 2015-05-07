<?php

/**
 * catselector plugin
 *
 * @package catselector
 * @version 1.0.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */


function catselector_selectbox($area, $check, $name, $attr = '', $userrigths = 'W')
{
	global $db, $structure, $usr, $L, $R;
	
	if(!empty($check))
	{
		$parents = cot_structure_parents($area, $check);
	}
	
	$result = '';
	
	$subcats = cot_structure_children($area, $parents[0], true, true);
	$maxlvl = 1;
	
	if(!empty($check)){
		foreach ($subcats as $i => $k)
		{
			$mtch = $structure[$area][$k]['path'].'.';
			$mtchlen = mb_strlen($mtch);
			$mtchlvl = mb_substr_count($mtch,".");
			if($mtchlvl > $maxlvl) $maxlvl = $mtchlvl;
		}
	}
	
	for($lvl = 1; $lvl <= $maxlvl; $lvl++)
	{
		$result .= "<select name=\"".$name."\" ".$attr." onChange=\"catselector_changeselect(this, '".$area."', '".$name."', '".$userrigths."');\">";
		$result .= "<option value=\"\">---</option>";
		foreach ($structure[$area] as $i => $x)
		{		
			if(cot_auth($area, $i, $userrigths))
			{
				$mtch = $structure[$area][$i]['path'].'.';
				$mtchlen = mb_strlen($mtch);
				$mtchlvl = mb_substr_count($mtch,".");

				if(($mtchlvl == 1 && $lvl == 1) || ($lvl > 1 && $mtchlvl == $lvl && in_array($i, $subcats)))
				{
					$selected_cat = ($parents[$lvl-1] == $i) ? 'selected="selected"' : '';
					$result .= "<option ".$selected_cat." value=\"".$i."\">".$x['title']."</option>";
				}
			}
		}
		$result .= "</select>";
	}
	
	return($result);
}
