
<script type="text/javascript">
	$(function(){
		var chk = $('#chk-dont-show-popup');
		chk.change(function() {
			var check = $(this).is(":checked");
			var c_url = check ? 'common/not_show_term_popup' : 'common/show_term_popup';
			$.ajax({
				type: 'POST',
				url: __site_url+c_url,
				dataType: 'json',
				success: function(result){
				},
				error: function(){
				}
			});
		});
<?php
	$this->load->helper('cookie');
	$not_popup = get_cookie('not_show_term_popup');
	if(empty($not_popup)):
?>
		common.popup.show(null, '#common-popup');

		chk.attr('checked', false);
<?php else: ?>
		chk.attr('checked', true);
<?php endif; ?>
	});
</script>
