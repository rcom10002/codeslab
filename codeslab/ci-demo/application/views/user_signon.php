
<script src="<?php echo base_url('js/jquery.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.base64.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.serializeFormJSON.js'); ?>" type="text/javascript"></script>
<script>
function signon() {
	$.post("<?=current_url()?>", $("#signon").serializeFormJSON(), function(data) {
		if (console) console.log(data);
		alert(data);
	});
}
</script>
<form id="signon" method="post">
USERNAME:<input type="text" name="USERNAME" /><br />
PASSWORD:<input type="password" name="PASSWORD" /><br />
<input type="button" value="Sign On" onclick="javascript:signon();">
</form>
