<h1>Logs à valider</h1>
<ul>
	<?php 
	foreach($logs as $log)
	{
		echo "<li>[".date('d/m H:i', strtotime($log->done_at))."] <strong>".$log->username."</strong> : ".$log->action."</li>";
	}
	?>
</ul>
<?php
	if(empty($logs))
		echo "Aucune action à valider.";
	else
		echo '<a href="'.base_url("admin/logs/accept").'" style="display: block; text-align: center; font-size: 20px;">J\'ai lu cet historique, et je le valide</a>';
?>
