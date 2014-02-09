    </div>
	
	<!-- Core Scripts  -->
    <script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
    <script>
		$(document).ready(function(){
			$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("selected");
			$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("active");
		});
	</script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?=base_url()?>assets/js/sb-admin.js"></script>
</body>