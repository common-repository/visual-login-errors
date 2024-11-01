jQuery.fn.pulse = function(intShakes /*Amount of shakes*/, intDistance /*Shake distance*/, intDuration /*Time duration*/) {
	var r_out = "-8px";
	var l_out = "0px";
	var r_in = "0px";
	var l_in = "8px";
	var ps_out = "16px";
	var ps_in = "16px";
	this.each(function() {
		for (var x=1; x<=intShakes; x++) {
			$(this).animate(
				{
					"marginLeft":l_out,
					"marginRight":r_out,
					"paddingLeft":ps_out,
					"paddingRight":ps_out
				}, 200, "easeOutSine")
				.animate(
				{
					"marginLeft":l_in,
					"marginRight":r_in,
					"paddingLeft":ps_in,
					"paddingRight":ps_in
				}, 200, "easeInSine")
		}
	});
	return this;
};
// SAMPLE USAGE
/*
$(function() {
	$(’#btn’).click(function() {
		$(this).pulse(2, 10, 400);
	});
});
*/