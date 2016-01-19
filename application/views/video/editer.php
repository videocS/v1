<h1>Edition de <?= $video->title; ?></h1>

<?php 
	$themeVideo = explode('-', $video->themes);
?>

<form action="#" method="POST">
	<p>
		<label for="title">Titre officiel :</label>
		<input type="text" name="title" id="title" value="<?= $video->title; ?>" />
	</p>
	<p>
		<label for="description">Description officielle :</label>
		<textarea name="description" id="description"><?= $video->description; ?></textarea>
	</p>
	<p>
		<label for="theme">Thème :</label>
		<select id="theme" name="theme">
			<option></option>
			<?php foreach($themes as $theme): ?>
				<option value="<?= $theme->title; ?>" <?php if($themeVideo[0] == $theme->title) echo "selected"; ?>><?= $theme->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="theme_bis">Thème secondaire <em>(optionnel)</em> :</label>
		<select id="teme_bis" name="theme_bis">
			<option></option>
			<?php foreach($themes as $theme): ?>
				<option value="<?= $theme->title; ?>" <?php if($themeVideo[1] == $theme->title) echo "selected"; ?>><?= $theme->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="type">Type :</label>
		<select id="type" name="type">
			<option></option>
			<?php foreach($types as $type): ?>
				<option value="<?= $type->title; ?>" <?php if($video->type == $type->title) echo "selected"; ?>><?= $type->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="link">Lien :</label>
		<input type="text" name="link" id="link" value="<?= $video->link; ?>"/>
	</p>
	<p>
		<label for="more_details">Détails supplémentaires <em>(optionnel)</em> :</label>
		<textarea name="more_details" id="more_details"><?= $video->more_details; ?></textarea>
	</p>
	<p>
		<label for="duration">Durée (en minutes) : </label>
		<input type="number" name="duration" id="duration" step="1" value="<?= $video->duration; ?>" />
	</p>
	<p>
		<label for="state">Statut :</label>
		<select name="state" id="state">
			<option value="0" <?php if($video->state == 0) echo "selected"; ?>>En attente de validation</option>
			<option value="1" <?php if($video->state == 1) echo "selected"; ?>>Validé</option>
			<option value="2" <?php if($video->state == 2) echo "selected"; ?>>En bêta</option>
		</select>
	</p>
	<p>
		<label for="screen">Impression d'écran :</label>
		<input type="url" name="screen" id="screen" value="<?= $video->screen; ?>" />
	</p>
	<p>
		<button type="submit">Envoyer</button>
	</p>
</form>