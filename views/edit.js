$(function () {
	function resizeEdit () {
		$('#edit').height( $(window).height() - 100 );
		console.log($(window).height());
	}

	$(window).on('resize', resizeEdit);

	resizeEdit();

	var saveContentTask = null;
	function saveContent () {
		$.post('/?action=update', {
			content: $('#edit').val()
		});
		saveContentTask = null;
	}

	$('#edit').on('keydown', function () {
		if (saveContentTask) {
			window.clearTimeout(saveContentTask);
			saveContentTask = null;
		}
		saveContentTask = window.setTimeout(saveContent, 500);
	});
});