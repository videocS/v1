<h1>Proposer une video à referencer</h1>
<p>Merci de remplir le formulaire suivant afin de proposer une vidéo. Votre demande sera traitée dans les plus brefs délais.</p>
<form action="#" method="POST">
	<p>
		<label for="title">Titre officiel :</label>
		<input type="text" name="title" id="title" />
	</p>
	<p>
		<label for="description">Description officielle :</label>
		<textarea name="description" id="description"></textarea>
	</p>
	<p>
		<label for="theme">Thème :</label>
		<select id="theme" name="theme">
			<option></option>
			<?php foreach($themes as $theme): ?>
				<option value="<?= $theme->title; ?>"><?= $theme->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="theme_bis">Thème secondaire <em>(optionnel)</em> :</label>
		<select id="teme_bis" name="theme_bis">
			<option></option>
			<?php foreach($themes as $theme): ?>
				<option value="<?= $theme->title; ?>"><?= $theme->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="type">Type <em>(optionnel)</em> :</label>
		<select id="type" name="type">
			<option></option>
			<?php foreach($types as $type): ?>
				<option value="<?= $type->title; ?>"><?= $type->title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="link">Lien :</label>
		<input type="text" name="link" id="link" />
	</p>
	<p>
		<button type="submit">Envoyer</button>
	</p>
</form>