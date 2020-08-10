$(document).ready(function(){

	$('.theme-item').each(function(){
		var _$self = $(this);

		_$self.bind('click', function(){
			var id = this.id;
			var tmp = document.getElementsByClassName(id + '-content')[0];

			if (tmp.style.display == 'block') {
				tmp.style.display = 'none';
				$('#' + id + '-arrow').removeClass('FXMOpb');
			} else {
				tmp.style.display = 'block';
				$('#' + id + '-arrow').addClass('FXMOpb');
			}
		});
	});
});