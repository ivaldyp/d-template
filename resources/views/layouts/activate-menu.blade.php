<script>
	$(function () {
		var splitid = $("#activemenus").val().split(',');

		$.each(splitid, function(index, value){
			if(index == 0) {
			} else {
				$(".menu-li-"+value).addClass("menu-open");
			}
			$(".menu-a-"+value).addClass("active");
		});
	});
</script>