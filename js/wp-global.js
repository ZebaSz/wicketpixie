jQuery(document).ready(function ($) {
	$("#loading").delay(500).hide();
	$("#topbar-subscribe a").click(
		function() {
			$("#subscribe").slideToggle();
			return false;
		}
	);
});
