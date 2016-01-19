<h1>S'inscrire</h1>
<form action="#" method="POST">
	<p>
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" />
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
		<input type="email" name="email" id="email" />
	</p>
	<p>
		<label for="newsletter">Je souhaite recevoir la newsletter de <?= NAME_SITE ?> :</label>
		<input type="checkbox" name="newsletter" id="newsletter" value="1" checked />
	</p>
	<p>
		<button type="submit">S'inscrire</button>
	</p>
</form>