<h1>Editer la page <?= $page->title; ?></h1>

<form action="#" method="POST">
	<p>
		<label for="title">Titre :</label>
		<input type="text" name="title" id="title" value="<?= $page->title; ?>" readonly />
	</p>
	<p>
		<label for="content">Contenu :</label>
		<textarea name="content" id="content"><?= $page->content; ?></textarea>
		<em style="font-size: 11px; color: grey;">
			Il est possible d'utiliser certaines balises comme : [b]Texte en gras[/b], [i]Texte en italique[/i], [u]Texte souligné[/u], [img]Lien vers l'image[/img],
			 [link=Lien]Texte du lien[/link]. Il est également possible d'imbriquer ces balises. Ecrire [b][i][link=http://www.videoc.com]Vidéoc[/link][/i][/b] affichera : <strong><em><a href="http://www.videoc.com/">Vidéoc</a></em></strong>
		</em>
	</p>
	<p>
		<label for="menu">Ajouter la page au menu :</label>
		<input type="radio" name="menu" id="menu" value="1" <?php if($page->menu == 1) echo "checked"; ?>/> Oui
		<input type="radio" name="menu" value="0" <?php if($page->menu == 0) echo "checked"; ?> /> Non
	</p>
	<p>
		<button type="submit">Ajouter</button>
	</p>
</form>