<script>
	function get_device_status(){
		$('.device_status').load('/device_status/dcs');
	}
	setInterval('get_device_status()', 1000);
</script>