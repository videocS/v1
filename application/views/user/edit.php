<h1>Profil de <?= $user->username; ?></h1>
<?php $this->load->view('user/onglets', $user->id); ?>
<p>Remplissez ce formulaire afin d'éditer ce profil. Laissez vide le champ mot et passe et confirmation pour ne pas changer le mot de passe.</p>
<form action="#" method="POST">
	<p>
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" value="<?= $user->username; ?>" <?php if($this->session->rank < MODERATEUR) echo "readonly"; ?> />
	</p>
	<p>
		<label for="password">Mot de passe :</label>
		<input type="password" name="password" id="password" />
	</p>	
	<p>
		<label for="password_confirm">Confirmation (mot de passe) :</label>
		<input type="password" name="password_confirm" id="password_confirm" />
	</p>	
	<p>
		<label for="email">Adresse e-mail :</label>
		<input type="email" name="email" id="email" value="<?= $user->email; ?>" />
	</p>
	<p>
		<label for="newsletter">Je souhaite recevoir la newsletter de <?= NAME_SITE ?> :</label>
		<input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if($user->newsletter == 1) echo "checked"; ?> />
	</p>
	<?php if($this->session->rank >= ADMINISTRATEUR):?>
		<p>
			<label for="rank">Rang :</label>
			<select id="rank" name="rank">
				<option value="<?= BANNI ?>" <?php if($user->rank == BANNI) echo "selected"; ?>>Banni</option>
				<option value="<?= MEMBRE ?>" <?php if($user->rank == MEMBRE) echo "selected"; ?>>Membre</option>
				<option value="<?= MODERATEUR ?>" <?php if($user->rank == MODERATEUR) echo "selected"; ?>>Modérateur</option>
				<option value="<?= ADMINISTRATEUR ?>" <?php if($user->rank == ADMINISTRATEUR) echo "selected"; ?>>Administrateur</option>
			</select>
		</p>
	<?php endif; ?>
	<p>
		<button type="submit">Editer</button>
	</p>
</form>