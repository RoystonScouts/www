<?php

function get_section_name($sectionId) {
	$roles = get_option('OnlineScoutManager_activeRoles');

	$result = '';
	foreach ($roles as $role) {
		if ($sectionId == $role['sectionid']) {
			$result = $role['sectionname'];
		}
	}
	return $result;
}

function output_coming_up_programme($sectionId, $sectionProgramme, $outputType, $numEntries) {
	if ($sectionProgramme) {
		$sectionName = get_section_name($sectionId);
		echo '<h3>'.$sectionName.'</h3>';

		$i = 0;
		foreach ($sectionProgramme as $array) {
			foreach ($array as $entry) {
				if ($outputType == 'both' or ($outputType == 'programme' and $entry['type'] == 'programme') or ($outputType == 'events' and $entry['type'] == 'events')) {
					echo '<div class="osm_comingup_title">'.$entry['title'].'</div>';
					echo '<div class="osm_comingup_date">'.$entry['date'].'</div>';
					echo '<div class="osm_comingup_description">'.$entry['summary'].'</div>';
					$i++;
					if ($i >= $numEntries) {
						break 2;
					}
				}
			}
		}
	} else {
		echo '<p>Nothing coming up this term.</p>';
	}
}
?>
