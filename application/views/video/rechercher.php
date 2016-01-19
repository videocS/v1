<h1>Les vidéos référencées</h1>
<?php echo $pagination; ?>
<form action="#" method="GET">
	<select name="type" id="type">
		<option value="1">Tout type</option>
		<?php foreach($types as $type): ?>
			<option value="<?= $type->title; ?>"><?= $type->title; ?></option>
		<?php endforeach; ?>
	</select>

	<select name="theme" id="theme">
		<option value="1">Tout thème</option>
		<?php foreach($themes as $theme): ?>
			<option value="<?= $theme->title; ?>"><?= $theme->title; ?></option>
		<?php endforeach; ?>
	</select>

	<input type="text" name="search" id="search" placeholder="Recherche" />

	<select name="order" id="order">
		<option value="1">Du + récent au + ancien</option>
		<option value="2">Du + ancien au + récent</option>
		<option value="3">Du + apprécié au - apprécié</option>
	</select>

	<input type="submit" value="GO !" />
</form>
<?php 
if(isset($videos))
{
	foreach($videos as $video){
?>
		<p><?= $video->title; ?></p>
<?php
	}
}
?>
