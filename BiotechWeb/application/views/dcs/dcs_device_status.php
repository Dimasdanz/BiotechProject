<?php 
	if(read_file("assets/device/dcs/condition.txt") == 1){
		$condition = "Unlocked";
	}else{
		$condition = "Locked";
	}
	$password_attempts = read_file("assets/device/dcs/password_attempts.txt");
	if(read_file("assets/device/dcs/status.txt") == 1){
		$status = "Armed";
	}else{
		$status = "Disarmed";
	}
?>
<ol class="breadcrumb">
	<li>Status: <strong><?=$status?></strong></li>
	<li>Password Attempts: <strong><?=$password_attempts?></strong></li>
	<li>Condition: <strong><?=$condition?></strong></li>
</ol>