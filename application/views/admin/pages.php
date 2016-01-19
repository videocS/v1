<h1>Gestion des pages</h1>
<p>Vous pouvez gérer les pages du site à l'aide de cette page :</p>
<table>
	<tr><td>Titre</td><td>Menu</td><td>Action</td></tr>
	<?php foreach($pages as $page)
	{
		echo '<tr><td><a href="'.base_url($page->slug).'">'.$page->title.'</a></td><td>';
		if($page->menu == 1) echo "Oui";
		else echo "Non";
		echo '</td><td><a href="'.base_url("page/edit/".$page->slug).'">Editer</a> - <a href="'.base_url("page/delete/".$page->slug).'">Supprimer<a></td></tr>';
	}
	?>
</table>

<p>Ajouter une page :</p>
<form action="#" method="POST">
	<p>
		<label for="title">Titre :</label>
		<input type="text" name="title" id="title" />
	</p>
	<p>
		<label for="content">Contenu :</label>
		<textarea name="content" id="content"></textarea>
		<em style="font-size: 11px; color: grey;">
			Il est possible d'utiliser certaines balises comme : [b]Texte en gras[/b], [i]Texte en italique[/i], [u]Texte souligné[/u], [img]Lien vers l'image[/img],
			 [link=Lien]Texte du lien[/link]. Il est également possible d'imbriquer ces balises. Ecrire [b][i][link=http://www.videoc.com]Vidéoc[/link][/i][/b] affichera : <strong><em><a href="http://www.videoc.com/">Vidéoc</a></em></strong>
		</em>		
	</p>
	<p>
		<label for="menu">Ajouter la page au menu :</label>
		<input type="radio" name="menu" id="menu" value="1" /> Oui
		<input type="radio" name="menu" value="0" /> Non
	</p>
	<p>
		<button type="submit">Ajouter</button>
	</p>
</form>