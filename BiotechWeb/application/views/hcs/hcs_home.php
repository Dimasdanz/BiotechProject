<script src="<?=base_url()?>assets/device/hcs/ipcam/get_misc.cgi"></script>
<script src="<?=base_url()?>assets/device/hcs/ipcam/check_user.cgi"></script>
<script src="<?=base_url()?>assets/device/hcs/ipcam/get_status.cgi"></script>
<script src="<?=base_url()?>assets/device/hcs/ipcam/get_camera_params.cgi"></script>
<script>
if(sys_ver.charAt(0)!='4')
	location = 'vererr.htm';	
try{
	user;
}	
catch(exception){
	location='index.htm';
}	
var record_osd=1;
var ptz_type=0;
var ERROR_TIMEOUT=-3;
var ERROR_CANCEL=-5;
var current=0;
var PRI_REFUSE=0;
var PRI_VISITOR=1;
var PRI_OPERATOR=2;
var PRI_ADMINISTRATOR=3;
var R160_120=2;
var R320_240=8;
var R640_480=32;
var PTZ_STOP=1;
var TILT_UP=0;
var TILT_UP_STOP=1;
var TILT_DOWN=2;
var TILT_DOWN_STOP=3;
var PAN_LEFT=4;
var PAN_LEFT_STOP=5;
var PAN_RIGHT=6;
var PAN_RIGHT_STOP=7;
var PTZ_LEFT_UP=90;
var PTZ_RIGHT_UP=91;
var PTZ_LEFT_DOWN=92;
var PTZ_RIGHT_DOWN=93;
var PTZ_CENTER=25;
var PTZ_VPATROL=26;
var PTZ_VPATROL_STOP=27;
var PTZ_HPATROL=28;
var PTZ_HPATROL_STOP=29;
var PTZ_PELCO_D_HPATROL=20;
var PTZ_PELCO_D_HPATROL_STOP=21;
var IO_ON=94;
var IO_OFF=95;
var cameras={};
var listen_src="";
var talk_src="";
var listen_on_src="";
var talk_on_src="";
var record_src="";
var record_on_src="";
if(pri == PRI_ADMINISTRATOR)
	document.write('<script src="get_misc.cgi"><\/script>');
cameras.alias=new Array();
cameras.host=new Array();
cameras.port=new Array();
cameras.user=new Array();
cameras.pwd=new Array();
cameras.pri=new Array();
cameras.valid=new Array();
cameras.restart=new Array();
cameras.retry_times=new Array();
cameras.count=1;
cameras.first=0;
cameras.pri[0]=cameras.pri[1]=cameras.pri[2]=cameras.pri[3]=0;
cameras.pri[4] = cameras.pri[5] = cameras.pri[6] = cameras.pri[7] = 0;
cameras.pri[8] = 0;
cameras.set_params=function(index,alias,host,port,user,pwd)	{ 
	 if ((index > 8) || (index < 0))
		return;
	this.alias[index]=alias;
	this.host[index]=host;
	this.port[index]=port;
	this.user[index]=user;
	this.pwd[index]=pwd;}
cameras.set_count=function(current,count){  
	if(count > 9)
		count = 9;
	if ((count > 4) && (count < 9))
		count = 4;
	if (count < 1 || ((count > 1) && (count <4)))
		count = 1;	
	this.count=count;
	if (parseInt(current) + parseInt(count) > 9)
		this.first = 9 - count;	
	else
		this.first=current;
	for (i = 0;i < 9;++ i)
		this.valid[i]=0;
	for (i=this.first;i<parseInt(this.first)+parseInt(this.count);++i)
		this.valid[i]=1;		}
function decoder_control(command)
{ 
	action_zone.location='decoder_control.cgi?command='+command;
	
}
function camera_control(param,value)
{ action_zone.location='camera_control.cgi?param='+param+'&value='+value;}
function pic_rspeed(value)
{ 
	video_stream.src='http://192.168.4.5:888/videostream.cgi?user='+ user +'&pwd='+ pwd +'&resolution='+ resolution +'&rate='+value;
}
function set_reversal(){if (flip&0x01){
		flip=flip&0x02;			
	}else
		flip=flip|0x01;	
	camera_control(5,flip);}
function set_mirror(){	if (flip&0x02)
		flip=flip&0x01;
	else
		flip=flip|0x02;
	camera_control(5,flip);}
function body_onload(){	
	var port;
	if (location.port=='')
		port=80;
	else
		port=location.port;			
	cameras.set_params(0,alias,location.hostname,port,user,pwd);
	for(i=1;i<=8;i++)
		cameras.set_params(i,'','',0,'','');
	current=0;	
	for(i=0;i<9;i++){
		cameras.pri[i]=PRI_REFUSE;
		cameras.retry_times[i]=0;
		cameras.restart[i]=0;
	}	
	cameras.set_count(current,1);
	var bOpe = pri>PRI_VISITOR;
	var bAdmin = pri>PRI_OPERATOR; 
	if(!bOpe){
		ptzpanel.style.display='none';
		hpatrol.style.display='none';
		vpatrol.style.display='none';
		img_reversal.style.display='none';
		img_mirror.style.display='none';
		bvoption.style.display='none';
		img_option.style.display='none';			
		img_switchon.style.display='none';			
		img_switchoff.style.display='none';		
	}
	else if(!bAdmin){
		img_option.style.display='none'; }
	if(pri == PRI_ADMINISTRATOR)
		document.getElementById('curpos').innerText = ptz_patrol_rate;		
}
function showhint(str){	
hint_span.innerText=str;
}
function OnResolutionChanged(nValue){	
	camera_control(0,nValue);
	setTimeout('location.reload()',2000);}
function up_onmousedown() {
	(flip&0x01)?decoder_control(TILT_DOWN):decoder_control(TILT_UP);}
function up_onmouseup() {
	if (!ptz_type)
		decoder_control(PTZ_STOP);
	else if (flip&0x01)
		decoder_control(TILT_DOWN_STOP);
	else	
		decoder_control(TILT_UP_STOP);}
function down_onmousedown() {
	(flip&0x01)?decoder_control(TILT_UP):decoder_control(TILT_DOWN);}
function down_onmouseup() {
	if (!ptz_type)
		decoder_control(PTZ_STOP);
	else if (flip&0x01)
		decoder_control(TILT_UP_STOP);
	else
		decoder_control(TILT_DOWN_STOP);	}
function left_onmousedown() {
	(flip&0x02)?decoder_control(PAN_RIGHT):decoder_control(PAN_LEFT);}
function left_onmouseup() {
	if (!ptz_type)
		decoder_control(PTZ_STOP);
	else if (flip&0x02)
		decoder_control(PAN_RIGHT_STOP);
	else	
		decoder_control(PAN_LEFT_STOP);	}
function right_onmousedown() {
	(flip&0x02)?decoder_control(PAN_LEFT):decoder_control(PAN_RIGHT);}
function right_onmouseup() {
	if(!ptz_type)
		decoder_control(PTZ_STOP);
	else if(flip&0x02)
		decoder_control(PAN_LEFT_STOP);
	else	
		decoder_control(PAN_RIGHT_STOP);}
function image_switchon_onclick(){
	decoder_control(IO_ON);}
function image_switchoff_onclick(){
	decoder_control(IO_OFF);}
var s_hpatrol=true;
var s_vpatrol=true;
function hpatrol_onclick() {
	if(s_hpatrol){
		ptz_type?decoder_control(PTZ_PELCO_D_HPATROL):decoder_control(PTZ_HPATROL);
		s_hpatrol = false;
}else{
		ptz_type?decoder_control(PTZ_PELCO_D_HPATROL_STOP):decoder_control(PTZ_HPATROL_STOP);
		s_hpatrol=true;
	}}
function vpatrol_onclick() {
	if(s_vpatrol){
		if (!ptz_type) decoder_control(PTZ_VPATROL);
		s_vpatrol = false;
	}	else{
		if (!ptz_type) decoder_control(PTZ_VPATROL_STOP);
		s_vpatrol=true;	}}
function getX(elem){
  var x = 0;
  while(elem){
    x = x + elem.offsetLeft;
    elem = elem.offsetParent;
  }return x;}
function getY(elem){
  var y = 0;
  while(elem){
    y = y + elem.offsetTop;
    elem = elem.offsetParent;}
  return y;}
function showpostable(){	
	hidep();
	var tb=document.getElementById('pt');
	var curpos=document.getElementById('curpos');
	var nleft=getX(curpos);
	var ntop=getY(curpos);
	tb.style.left=nleft-90;
	tb.style.top=ntop-2;
	tb.style.display = "block";}
function setspeed(nValue){
	action_zone.location='set_misc.cgi?ptz_patrol_rate='+nValue;
	document.getElementById('curpos').innerText = nValue;} 
function showppos(panel,btn){	
	hidep();
	var tb=document.getElementById(panel);
	var curpos=document.getElementById(btn);
	var nleft=getX(curpos);
	var ntop=getY(curpos);
	tb.style.left=nleft-90;
	tb.style.top=ntop;
	tb.style.display = "block";}
function hideppos(panel){
	var tb=document.getElementById(panel);
	tb.style.display = "none";}
function callcmd(cmd){
	if(current>=0 && current<9)
		decoder_control(cmd);
		}
function hidep(){
hideppos('cp');
hideppos('sp');
hideppos('pt')
}
function MM_reloadPage(init) { 
 if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
  document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
 else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
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
				<div class="panel-body" align="center">
					<img src="http://192.168.4.5:888/videostream.cgi" id="video_stream">
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