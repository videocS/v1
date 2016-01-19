<h1>Profil de <?= $user->username; ?></h1>
<?php $this->load->view('user/onglets', $user->id); ?>