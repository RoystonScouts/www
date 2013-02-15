<div class="widget-wrapper widget">
<?php
getTerms();
$continue = true;
$programme = get_cached_osm('programme');
if (!$programme) {
	$roles = get_option('OnlineScoutManager_activeRoles');
	if (!is_array($roles)) {
		$continue = false;
		echo '<p>Online Scout Manager account has not been configured.</p>';
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
?>
<h3 class="widget-title"><?php echo $instance['wtitle']; ?></h3>
<?php
if ($continue) {
	$sectionId = $instance['sectionid'];

	if (is_numeric($sectionId)) {
		output_coming_up_programme($sectionId, $programme[$sectionId], $instance['type'], $instance['numentries']);
	} else {
		$roles = get_option('OnlineScoutManager_activeRoles');

		foreach ($roles as $role) {
			output_coming_up_programme($role['sectionid'], $programme[$role['sectionid']], $instance['type'], $instance['numentries']);
		}
	}
}
?>
</div>
