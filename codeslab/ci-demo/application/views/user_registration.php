
<script src="<?php echo base_url('js/jquery.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.base64.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.serializeFormJSON.js'); ?>" type="text/javascript"></script>
<script>

function register() {
	$.post("<?=current_url()?>", $("#register").serializeFormJSON(), function(data) {
		if (console) console.log(data);
		alert(data);
	});
}
</script>
<form id="register" method="post">
FIRST_NAME:<input type="text" name="FIRST_NAME" /><br />
LAST_NAME:<input type="text" name="LAST_NAME" /><br />
EMAIL:<input type="text" name="EMAIL" /><br />
PHONE:<input type="text" name="PHONE" /><br />
USERNAME:<input type="text" name="USERNAME" /><br />
PASSWORD:<input type="text" name="PASSWORD" /><br />
PASSWORD_CONFIRM:<input type="text" name="PASSWORD_CONFIRM" /><br />
TYPE:<input type="text" name="TYPE" /><br />
STATUS_ID:<input type="text" name="STATUS_ID" />
<input type="button" value="Register" onclick="javascript:register();">
</form>
