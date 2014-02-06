    </div>
	
	<!-- Core Scripts  -->
    <script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
    <script>
		$(document).ready(function(){
			$("#<?=$this->uri->segment(1, '')?>").addClass("active");
			$("#<?=$this->uri->segment(1, '')?> #<?=$this->uri->segment(2, 'home')?>").addClass("active");
		});
	</script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?=base_url()?>assets/js/sb-admin.js"></script>

    <!-- Plugin Scripts
    <script src="<?=base_url()?>assets/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/morris/morris.js"></script>
	<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
	<script src="<?=base_url()?>assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/flot/jquery.flot.pie.js"></script>
	-->
</body>