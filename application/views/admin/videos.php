<h1>Vidéos en attente de validation</h1>
<table>
	<tr><td>Nom de la vidéo</td><td>Thème(s)</td><td>Description</td><td>Action</td></tr>

	<?php foreach($videos as $video): ?>
		<tr>
			<td><a href="<?= $video->link; ?>" target="_blank"><?= $video->title; ?></a></td>
			<td><?php $theme = explode('-', $video->themes);
			echo $theme[0];
			if($theme[1] != "")
				echo " et ".$theme[1];
			?>
			</td>
			<td><?= htmlspecialchars($video->description); ?></td>
			<td><a href="<?= base_url('admin/videos/'.$video->id.'/1'); ?>">Valider</a> - 
				<a href="<?= base_url('admin/videos/'.$video->id.'/2'); ?>">En bêta</a> - 
				<a href="<?= base_url('admin/videos/'.$video->id.'/3'); ?>">Refuser</a></td>
		</tr>
	<?php endforeach; ?>
</table>