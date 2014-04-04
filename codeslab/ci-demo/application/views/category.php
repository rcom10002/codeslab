<html>
<head>
<title></title>
<script src="<?php echo base_url('js/jquery.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/jquery.base64.js'); ?>" type="text/javascript"></script>
</head>
<body>
<script>
	var subBizURL = "<?php echo site_url('/category/subBusiness/'); ?>";
	var categoryList = <?=$json;?>;
	var categoryEcho = function(categoryItem) {
		for (var bizAttr in categoryItem) {
			if ("ID" == bizAttr) {
				document.write("<a href='" + subBizURL + "/" + categoryItem[bizAttr] + "' >");
				document.write(bizAttr + ":" + categoryItem[bizAttr]);
				document.write("</a>" + "<br />");
			} else {
				document.write(bizAttr + ":" + categoryItem[bizAttr] + "<br />");
			}
		}
		document.write("<hr />")
	};
	if (categoryList && categoryList.length && categoryList.length > 0) {
		for (var idx in categoryList) {
			categoryEcho(categoryList[idx]);
		}
	}
	$(
		function () {
			$('a').each(function(){this.newhref = this.href; this.href = 'javascript:void(0);';});
			$('body').delegate('a', 'click', function() {
				$.post(this.newhref + '/json', function (data) {
					alert("----------- BEFORE DECRYPT ----------- " + data);
					alert("----------- AFTER DECRYPT ----------- " + $.base64('decode', data));
				});
				return false;
			});
		}
	);
</script>
</body>
</html>