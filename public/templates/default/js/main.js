/*price range*/
 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/
$(document).ready(function(){
	$('#java-alert').modal({backdrop: 'static', keyboard: false});
	/*if (typeof(Storage) !== "undefined") {
		// Write code for local storage.
		var getDemoObjectData = localStorage.getItem('demoObject');
		if (getDemoObjectData == '' || getDemoObjectData == null) {
			localStorage.setItem('demoObject', new Date());
			$("#java-alert").modal('show');
		}
	} else {
		// Sorry, your browser does not support Web Storage..
		alert('Sorry, your browser does not support Web Storage');
	}*/

	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 600, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        //animationSpeed: 1000, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: 'Back To Top', // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
	
	$(".go_sign").on('click', function () {
		window.open(
			'member/login.html?email=' + $("#email").val(),
			'_blank' // <- This is what makes it open in a new window.
		  );
	})

	$(".go_web").on('click', function () {
		location.href = '/';
	})

	/*if($('#image-map')) {
		$('#image-map area').each(function() {
			var id = $(this).attr('id');
			$(this).mouseover(function() {
				$('#overlay'+id).show();
			});
			
			$(this).mouseout(function() {
				var id = $(this).attr('id');
				$('#overlay'+id).hide();
			});
		
		});
	}*/

});

function myHover(element)
{
	//document.getElementById(element.getAttribute('id')).css = "opacity:0.2;";
	$('#' + element.getAttribute('id')).attr('style','opacity:0.5;');
	$('#' + element.getAttribute('id') + 'Link').attr('style','color:#00b0f0;');
}

function myLeave(element)
{
	$('#' + element.getAttribute('id')).attr('style','opacity:0;');
	$('#' + element.getAttribute('id') + 'Link').attr('style','color:#000;');
}
