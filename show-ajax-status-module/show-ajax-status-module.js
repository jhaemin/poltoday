function setStatus(str) {
	window.clearTimeout(this.timeoutHandle);

	$('#as-placeholder').html(str);
	$('#ajax-status').addClass('active');

	this.timeoutHandle = window.setTimeout(function() {
		$('#ajax-status').removeClass('active');
	}, 2000);
}