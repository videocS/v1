<h1>Envoyer une newsletter</h1>
<p>Remplissez ce formulaire afin de pouvoir envoyer un mail à tous les membres de <?= NAME_SITE ?> acceptant la newsletter.</p>
<form action="#" method="POST">
	<p>
		<label for="title">Titre :</label>
		<input type="text" name="title" id="title" value="<?= "Newsletter du ".date('d/m/Y'); ?>" />
	</p>
	<p>
		<label for="content">Message :</label>
		<textarea name="content" id="content"></textarea>
	</p>
	<p>
		<button type="submit">Envoyer !</button>
</form>