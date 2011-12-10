jQuery(document).ready(function ($) {
	//Add all your global onReady Functions here
	$("#loadingFrame").delay(500).hide();
	$("#topbar-subscribe a").click(
		function() {
			$("#subscribe").slideToggle();
			return false;
		}
	);
});
