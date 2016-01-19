<h1>Profil de <?= $user->username; ?></h1>
<?php $this->load->view('user/onglets', $user->id); ?>
<p>
<?php if($user->rank == MEMBRE) 
{
	echo "Membre";
}
elseif($user->rank == MODERATEUR)
{
	echo "Modérateur";
}
elseif($user->rank == ADMINISTRATEUR)
{
	echo "Administrateur";
}
?>

</p>
