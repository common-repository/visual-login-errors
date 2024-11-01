jQuery.fn.drop = function(intShakes /*Amount of shakes*/, intDistance /*Shake distance*/, intDuration /*Time duration*/) {
	this.each(function() {
		$(this).css({position:'relative'});
		$(this).css({'marginTop':'-1000px'});
		$(this).animate({'marginTop':'7em'}, 500, "easeOutSine");
	});
	return this;
};
// SAMPLE USAGE
/*
$(function() {
	$(’#btn’).click(function() {
		$(this).drop(2, 10, 400);
	});
});
*/