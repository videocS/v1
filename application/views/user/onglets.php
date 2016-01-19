<ul class="onglets">
	<li <?php if(strstr($_SERVER['REQUEST_URI'], "edit")) echo 'id="active"'; ?>><a href="<?= base_url('user/edit/'.$user->id); ?>">Editer</a></li>
	<li <?php if(strstr($_SERVER['REQUEST_URI'], "show")) echo 'id="active"'; ?>><a href="<?= base_url('user/show/'.$user->id); ?>">Voir</a></li>
	<li <?php if(strstr($_SERVER['REQUEST_URI'], "preferences")) echo 'id="active"'; ?>><a href="<?= base_url('user/preferences/'.$user->id); ?>">Préférences</a></li>
	<li <?php if($this->session->rank < MODERATEUR) { echo 'class="disable"'; } ?>><a href="<?= base_url('admin/logs'); ?>">Administration</a></li>
</ul>