<?php
$no = 1;
if ($today_log != NULL) {
	foreach ( $today_log as $row ) {
		?>
<tr>
	<td><?=$no?></td>
	<td><?=$row->turbidity?></td>
	<td><?=date('h:i:s', strtotime($row->time))?></td>
</tr>
<?php
		$no ++;
	}
} else {
	?>
<tr>
	<td colspan="3">Tidak ada Log untuk hari ini</td>
</tr>
<?php
}
?>