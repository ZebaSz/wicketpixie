jQuery(document).ready(function ($) {
	//Add all your global onReady Functions here
	setTimeout("hideLoading()", 500);
	$('#subscribe').hide();
	$("#topbar-subscribe a").toggle(
		function() { $("#subscribe").animate({ height: "show", duration: 700, easing:"easeInQuad"});
		return false;
	},
		function() { $("#subscribe").animate({ height: "hide", duration: 700, easing:"easeOutQuad"});
		return false;
	});
});

function hideLoading() {
	jQuery("#loadingFrame").css('display', 'none');
}
