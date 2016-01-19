<h1>Editer un membre</h1>
<p>Sélectionnez un membre :</p>
<form action="#" method="POST">
<select name="member" id="member" onChange="location = this.options[this.selectedIndex].value;">
	<option value="">Membre</option>
<?php 
	foreach($members as $member)
	{
		echo '<option value="'.base_url('user/edit/'.$member->id).'">'.ucfirst($member->username).'</option>';
	}
?>
</select>
</form>