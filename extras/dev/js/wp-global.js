jQuery(document).ready(function ($) {
	//Add all your global onReady Functions here
	setTimeout("hideLoading()", 500);
	$("#topbar-subscribe a").click(
		function() {
			$("#subscribe").slideToggle();
			return false;
		}
	);
});

function hideLoading() {
	jQuery("#loadingFrame").hide();
}
