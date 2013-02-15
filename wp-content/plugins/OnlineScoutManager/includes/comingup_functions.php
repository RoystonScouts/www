<?php

function get_comingup_programme() {
	getTerms();

	$programme = get_cached_osm('programme');

	if (!$programme) {
		$roles = get_option('OnlineScoutManager_activeRoles');
		if (!is_array($roles)) {
			echo '<p>Online Scout Manager account has not been configured.</p>';
			return nil;
		} else {
			$now = strtotime(date("Y-m-d"));
			foreach ($roles as $role) {
				$prog = osm_query('programme.php?action=getProgramme&sectionid='.$role['sectionid'].'&termid='.$role['termid']);
				if ($prog['items']) {
					foreach ($prog['items'] as $meeting) {
						$dateInSeconds = strtotime($meeting['meetingdate']);
						if ($dateInSeconds > $now) {
							$storeProgramme[$role['sectionid']][$dateInSeconds][] = array('type' => 'programme', 'date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['title'], 'summary' => $meeting['notesforparents']);
						}
					}
				}
			
				$prog = osm_query('events.php?action=getEvents&sectionid='.$role['sectionid'].'&termid='.$role['termid'].'&futureonly=true');
				if ($prog['items']) {
					$prog['items'] = array_reverse($prog['items']);
				
					foreach ($prog['items'] as $meeting) {
						$dateInSeconds = strtotime($meeting['startdate']);
						if ($dateInSeconds > $now) {
							$storeProgramme[$role['sectionid']][$dateInSeconds][] = array('type' => 'events', 'date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['name'], 'summary' => $meeting['notes']);
						}
					}
				}
				if (is_array($storeProgramme[$role['sectionid']])) {
					ksort($storeProgramme[$role['sectionid']]);
				}
			}
			update_cached_osm('programme', $storeProgramme);
			$programme = $storeProgramme;
		}
	}
	return $programme;
}

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

function output_coming_up_programme($sectionProgramme, $outputType, $numEntries) {
	if ($sectionProgramme) {
		$i = 0;
		foreach ($sectionProgramme as $array) {
			foreach ($array as $entry) {
				if ($outputType == 'both' or ($outputType == 'programme' and $entry['type'] == 'programme') or ($outputType == 'events' and $entry['type'] == 'events')) {
					$rs .= '<div class="osm_comingup_title">'.$entry['title'].'</div>';
					$rs .= '<div class="osm_comingup_date">'.$entry['date'].'</div>';
					$rs .= '<div class="osm_comingup_description">'.$entry['summary'].'</div>';
					$i++;
					if ($i >= $numEntries) {
						break 2;
					}
				}
			}
		}
	} else {
		$rs = '<p>Nothing coming up this term.</p>';
	}
	return $rs;
}
?>
