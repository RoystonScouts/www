<div class="widget-wrapper widget">
<?php

$programme = get_comingup_programme();

if ($programme) {
	$sectionId = $instance['sectionid'];
?>
	<h3 class="widget-title"><?php echo $instance['wtitle']; ?></h3>
<?php

	if (is_numeric($sectionId)) {
		echo output_coming_up_programme($programme[$sectionId], $instance['type'], $instance['numentries']);
	} else {
		$roles = get_option('OnlineScoutManager_activeRoles');

		foreach ($roles as $role) {
			$sectionName = get_section_name($role['sectionid']);
			echo '<h3>'.$sectionName.'</h3>';

			echo output_coming_up_programme($programme[$role['sectionid']], $instance['type'], $instance['numentries']);
		}
	}
}
?>
</div>
