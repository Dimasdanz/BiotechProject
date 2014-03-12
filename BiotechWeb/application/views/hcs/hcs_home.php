<script src="<?=base_url()?>assets/device/hcs/ipcam/function.js"></script>
<script>
var fInterval = "";

function InitAUTO()
{
  frm0 = document.forms[0];
  frm1 = document.forms[1];
  frm0.WebLanguageSel.value = frm1.WebLanguage.value;
}

function ClickSubmit()
{
  javascript:document.forms[1].submit();
}

function Stop() {
	window.clearInterval(fInterval);
}

function ShowRunningString() {
    fInterval = window.setInterval("ShowFrameRate()", 1000);
}

function Init() {
    if (1) {
       audioon.disabled = false;
       audiooff.disabled = false;
    } else {
       audioon.disabled = true;
       audiooff.disabled = true;
    }
    
    window.setTimeout("ShowRunningString()", 3000);
}

function ShowFrameRate() {
    var fFrameRate;
    if ((1) || (0))
    {
       fFrameRate = cvcs.GetFrameRate();
    }
    if (1)
    {
       window.status = "Frame:" + fFrameRate.toString() + " fps"
    }
    if (0)
    {
       CurrentFrame.innerHTML = "Frame:" + fFrameRate.toString() + " fps"
    }
    cvcs.GetRealTimeData(); 
    CurrentTime.innerHTML = cvcs.GetTimeString();
} 

function SubmitAudioOn()
{
     cvcs.SetSound(1);
}
 
function SubmitAudioOff()
{
     cvcs.SetSound(0);
}
</script>
<div id="page-wrapper">
<?php
	$this->load->view('gcs/gcs_header');
?>
	<?php 
		if($this->session->flashdata('success')){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?=$this->session->flashdata('success')?>
		</div>
    <?php 
    	}
    ?>
    <div class="row">
    	<div class="col-sm-12">
    		<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-lightbulb-o"></i> IP Camera
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-8">
							<applet name="cvcs" codebase="http://192.168.4.10/" archive="aplug.jar" code="aplug.class" width="640" height="480">
								<param name="RemotePort" value="80">
								<param name="Timeout" value="5000">
								<param name="RotateAngle" value="0">
								<param name="PreviewFrameRate" value="2">
								<param name="Algorithm" value="1">
								<param name="DeviceSerialNo" value="YWRtaW46">
							</applet>
						</div>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-12">
									Zoom :
									<input type="button" class="btn btn-primary btn-sm" value="x1" onclick="cvcs.Zoom(1)">
									<input type="button" class="btn btn-primary btn-sm" value="x2" onclick="cvcs.Zoom(2)">
									<input type="button" class="btn btn-primary btn-sm" value="x3" onclick="cvcs.Zoom(3)">
									<input type="button" class="btn btn-primary btn-sm" value="x4" onclick="cvcs.Zoom(4)">
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-sm-12">
								Audio :
								<input id="audioon" type="button" class="btn btn-primary btn-sm" value="ON" onclick="SubmitAudioOn()">
								<input id="audiooff" type="button" class="btn btn-primary btn-sm" value="OFF" onclick="SubmitAudioOff()">
								<span id="CurrentFrame"></span>
								</div>
							</div>
						</div>
					</div>
					<form action="http://192.168.4.10/audiocontrol.cgi" method="POST">
						<input type="hidden" name="AudioMute" value="0">
					</form>
					 
					<form action="http://192.168.4.10/audiocontrol.cgi" method="POST">
						<input type="hidden" name="AudioMute" value="1">
					</form>
				
					<script language="Javascript">
						InitAUTO();
					</script>
				</div>
			</div>
    	</div>
    </div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-lightbulb-o"></i> Status Lampu
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3 text-center">
							<h4>Lampu 1</h4>
							<input type="checkbox" id="lamp_1" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lampu 2</h4>
							<input type="checkbox" id="lamp_2" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lampu 3</h4>
							<input type="checkbox" id="lamp_3" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lampu 4</h4>
							<input type="checkbox" id="lamp_4" checked data-on="success" data-off="danger">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-list"></i> Log Hari Ini
				</div>
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>No.</th>
									<th>Lampu</th>
									<th>Status</th>
									<th>Waktu</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 1;
								if($today_log != NULL){
									foreach ($today_log as $row){
								?>
									<tr>
										<td><?=$no?></td>
										<td><?=$row->lamp?></td>
										<td><?=$row->condition?></td>
										<td><?=date('h:i:s', strtotime($row->time))?></td>
									</tr>
								<?php 
										$no++;
										}
									}else{
								?>
									<tr>
										<td colspan="3">Tidak ada Log untuk hari ini</td>
									</tr>
								<?php 
									}
								?>
							</tbody>
						</table>
					</div>
				<div class="panel-footer clearfix">
					<a href="<?=base_url()?>hcs/log" class="btn btn-primary pull-right"><i class="fa fa-list"></i> Lihat Semua Log <i class="fa fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		
	</div>
</div>
<div class="modal fade" id="modal_confirm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<?=form_open(base_url().'hcs/change_status')?>
            		<input type="hidden" name="lamp" id="lid">
					<input type="hidden" name="status" id="status_value">
					<button type="submit" class="btn btn-success" id="yes">Ya</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php
	$this->load->view('template/footer');
?>
<script src="<?=base_url()?>assets/js/bootstrap-switch.js"></script>
<script>
	$(document).ready(function() {
		<?php 
			if($lamp_1 == 1){
		?>
			$('#lamp_1').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_1').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_2 == 1){
		?>
			$('#lamp_2').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_2').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_3 == 1){
		?>
			$('#lamp_3').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_3').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_4 == 1){
		?>
			$('#lamp_4').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_4').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		$("input[id^=lamp]").bootstrapSwitch();
		$("input[id^=lamp]").on('switch-change', function (e, data) {
			if (data.value == true) {
				var name = this.id;
				var string = name.charAt(0).toUpperCase() + name.slice(1);
				$("#lid").val(this.id);
				$("#status_value").val(1);
				$("#confirm_str").html('Are you sure want to turn on '+string.replace(/_/g, ' ')+'?');
			}else{
				var name = this.id;
				var string = name.charAt(0).toUpperCase() + name.slice(1);
				$("#lid").val(this.id);
				$("#status_value").val(0);
				$("#confirm_str").html('Are you sure want to turn off '+string.replace(/_/g, ' ')+'?');
			}
			$('#modal_confirm').modal('show');
		});
		$('#modal_confirm').on('hide.bs.modal', function (e) {
			$("#"+$("#lid").val()).bootstrapSwitch('toggleState');
		});
	});
</script>