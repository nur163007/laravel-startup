(function () {
	"use strict";

	var slideMenu = $('.side-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});


	$(window).on('load resize',function(){
        if($(window).width() < 768){
            $('.side-menu').hover(function(event) {
				event.preventDefault();
				$('.app').addClass('sidenav-toggled');
			});
		}
		if($(window).width() > 768){
			$('.side-menu').hover(function(event) {
				event.preventDefault();
				$('.app').removeClass('sidenav-toggled');
			});
		}
    });

	// Activate sidebar slide toggle



	// Activate sidebar slide toggle
	$("[data-toggle='sub-slide']").on('click', function(e) {
		var $this = $(this);
		var checkElement = $this.next();
		var animationSpeed = 300,
		slideMenuSelector = '.sub-slide-menu';
		if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
		  checkElement.slideUp(animationSpeed, function() {
			checkElement.removeClass('open');
		  });
		  checkElement.parent("li").removeClass("is-expanded");
		}
		 else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
		  var parent = $this.parents('ul').first();
		  var ul = parent.find('ul:visible').slideUp(animationSpeed);
		  ul.removeClass('open');
		  var parent_li = $this.parent("li");
		  checkElement.slideDown(animationSpeed, function() {
			checkElement.addClass('open');
			parent.find('li.is-expanded').removeClass('is-expanded');
			parent_li.addClass('is-expanded');
		  });
		}
		if (checkElement.is(slideMenuSelector)) {
		  e.preventDefault();
		}
	});

	// Activate sidebar slide toggle
	$("[data-toggle='sub-slide2']").on('click', function(e) {
		var $this = $(this);
		var checkElement = $this.next();
		var animationSpeed = 300,
		slideMenuSelector = '.sub-slide-menu2';
		if (checkElement.is(slideMenuSelector) && checkElement.is(':visible')) {
		  checkElement.slideUp(animationSpeed, function() {
			checkElement.removeClass('open');
		  });
		  checkElement.parent("li").removeClass("is-expanded");
		}
		 else if ((checkElement.is(slideMenuSelector)) && (!checkElement.is(':visible'))) {
		  var parent = $this.parents('ul').first();
		  var ul = parent.find('ul:visible').slideUp(animationSpeed);
		  ul.removeClass('open');
		  var parent_li = $this.parent("li");
		  checkElement.slideDown(animationSpeed, function() {
			checkElement.addClass('open');
			parent.find('li.is-expanded').removeClass('is-expanded');
			parent_li.addClass('is-expanded');
		  });
		}
		if (checkElement.is(slideMenuSelector)) {
		  e.preventDefault();
		}
	});

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();


	// ______________Active Class
	// $(document).ready(function() {
    //
    //     $(".app-sidebar li a").each(function() {
    //         console.log(this.href)
    //         var pageUrl = window.location.href.split(/[?#]/)[0];
    //         if (this.href == pageUrl) {
    //             $(this).addClass("active");   //child a add class
    //             $(this).parent().addClass("is-expanded");  //child li add class
    //             $(this).parent().parent().prev().addClass("active"); //parent a add class
    //             $(this).parent().parent().addClass("open"); // clild ul class add
    //             $(this).parent().parent().prev().addClass("is-expanded"); //parent a add class
    //             $(this).parent().parent().parent().addClass("is-expanded"); // parent li class add
    //             $(this).parent().parent().parent().parent().addClass("open"); // main ul class add
    //             // $(this).parent().parent().parent().parent().prev().addClass("active");
    //             $(this).parent().parent().parent().parent().parent().addClass("is-expanded"); //aside add class
    //         }
    //     });
	// });
})();

