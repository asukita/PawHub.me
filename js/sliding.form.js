$(function() {

	/*
	 current position of fieldset / navigation link
	 */
	var current = 1;

	/*
	 sum and save the widths of each one of the fieldsets
	 set the final sum as the total width of the steps element
	 */
	var stepsWidth = 0;
	var widths = new Array();
	$('#steps .step').each(function(i) {
		var $step = $(this);
		widths[i] = stepsWidth;
		stepsWidth += $step.width();
	});
	$('#steps').width(stepsWidth + 5);

	/*
	 to avoid problems in IE, focus the first input of the form
	 */
	$('#formElem').children(':first').find(':input:first').focus();

	/*
	 when clicking on a navigation link
	 the form slides to the corresponding fieldset
	 */
	$('#navigation a').bind('click', function(e) {
		var $this = $(this);
		var prev = current;
		$this.closest('ul').find('li').removeClass('selected');
		$this.parent().addClass('selected');
		/*
		 we store the position of the link
		 in the current variable
		 */
		current = $this.parent().index() + 1;
		/*
		 animate / slide to the next or to the corresponding
		 fieldset. The order of the links in the navigation
		 is the order of the fieldsets.
		 Also, after sliding, we trigger the focus on the first
		 input element of the new fieldset
		 If we clicked on the last link (confirmation), then we validate
		 all the fieldsets, otherwise we validate the previous one
		 before the form slided
		 */
		if (!$('.no-js').length) {
			$('#steps').stop().animate({
				left : '-' + widths[current - 1] + 'px'

			});
		}else{
			$('#steps').stop().animate({
				marginLeft : '-' + widths[current - 1] + 'px'

			});
		}

		e.preventDefault();
	});

}); 