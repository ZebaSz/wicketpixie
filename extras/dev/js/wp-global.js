jQuery(document).ready(function ($) {
	//Add all your global onReady Functions here
	setTimeout("hideLoading()", 500);
	$('#subscribe').hide();
	$("#topbar-subscribe a").toggle(
		function() { $("#subscribe").slideDown();
		return false;
	},
		function() { $("#subscribe").slideUp();
		return false;
	});
});

function hideLoading() {
	jQuery("#loadingFrame").css('display', 'none');
}
