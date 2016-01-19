<?php if($video->state == 2): ?>
	<em>
		Cette fiche est en attente d'approbation de la communauté. 
		<?php if($this->session->id <= 0): ?>
			Connectez-vous pour voter pour ou contre son acceptation.
		<?php ;else: ?>
			Cette fiche a-t-elle sa place sur le site selon vous ? 
			<?php if($vote): ?>
				Vous avez déjà voté.
			<?php else: ?>
				<a href="<?= base_url('video/voter/'.$video->id.'/'.$this->session->id.'/1'); ?>" style="color: green;">Oui</a> - <a href="<?= base_url('video/voter/'.$video->id.'/'.$this->session->id.'/2'); ?>" style="color: red;">Non</a>
			<?php endif; ?>
		<?php endif; ?>
	</em><hr />
<?php endif; ?>
<h1><?= $video->title; ?></h1>
<p>INFORMATIONS GÉNÉRALES ICI</p>

