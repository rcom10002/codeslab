<html>
<head>
<title></title>
<script src="<?php echo base_url('js/jquery-ui/js/jquery-1.10.2.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery-ui/js/jquery-ui-1.10.4.custom.min.js'); ?>" type="text/javascript"></script>
 <link href="<?php echo base_url('js/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('js/jquery.base64.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/table-view.js'); ?>" type="text/javascript"></script>
<script>
var pageContext = {
    //listAll
    //removeItem
    //updateItem
};

function init() {
	$( "#dialog" ).dialog({});
    $("body").find("table").remove();
	var pageContext = <?php echo $pageContext ?>;
	console.log(<?php echo $pageContext ?>, pageContext.ACTION.RETRIEVE);
    $.post(pageContext.ACTION.RETRIEVE, function (data) {
	    $("body").append(CreateTableView({data: data, action: pageContext.ACTION}));
	    setTimeout(function() { $( "#dialog" ).dialog('close'); }, 1000);
    });
}

$(init);
</script>
</head>
<body>
<!--
<script>
	var entityList = <?=$json;?>;
	var entityEcho = function(entityItem) {
		for (var bizAttr in entityItem) {
			document.write(bizAttr + ":" + entityItem[bizAttr] + "<br />");
		}
		document.write("<hr />")
	};
	if (entityList && entityList.length && entityList.length > 0) {
		for (var idx in entityList) {
			entityEcho(entityList[idx]);
		}
	}
</script>
-->
<div id="dialog" title="Basic dialog" style="display: none;">
  <p>Data is loading, please wait ...</p>
</div>
</body>
</html>