<?php

function show_coming_up($attrs){
	getTerms();
	$roles = get_option('OnlineScoutManager_activeRoles');
	$sectionid = $attrs['sectionid'];
	$outputType = $attrs['output'];
	$maxEntries = $attrs['max_entries'];

	if ($outputType == '')
		$outputType = 'both';
	if ($maxEntries == '') 
		$maxEntries = '5';

	if (is_numeric($sectionid)) {
		if (isset($roles[$sectionid])) {
			$programme = get_comingup_programme();
			return output_coming_up_programme($programme[$sectionid], $outputType, $maxEntries);

		} else {
			return "There is no OSM data for the specified section.";
		}
		
	} else {
		return "A numeric sectionid must be provided.";
	}
 
}

add_shortcode('coming-up', 'show_coming_up');
?>
