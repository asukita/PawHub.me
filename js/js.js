var img=0;
var imgs=['A','B'];
function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

function toolsCarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });

	jQuery('.toolBar a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).attr("href")));
		$('.toolBar a img').css("width","44");
		$(this).find('img').css("width","40");
        return false;
    });
};

function changeCarousel(carousel, item, idx, state) {
	var colors=["#FFD13B","#62C4CF","#C6638C","#A9E05A"];
	$("#slide4").css("background",colors[idx%4]);
};

function sliderHeight(){
		
	wh = $(window).height();
	$('.slideImg').css({height:wh});
	$('#slide1').css({height:wh});
	$('#slide6').css({height:wh});
	$("#slide7").css({"min-height":wh-250});
	
}

function mymargtop() {
	var body_h = $(window).height();
	var container_h = $('.filtr_bg').height();	
	var marg_top = Math.abs((body_h - container_h-100));	
	$('.filtr_bg').css('margin-top', marg_top);
//	$('.filtr_bg').css('margin-bottom', marg_top);
	$('#slide4').css('height', body_h-100);

}

jQuery(document).ready(function ($) {


    $(window).stellar();

    var links = $('.navigation').find('li');
    slide = $('.slide');
    button = $('.button');
    mywindow = $(window);
    htmlbody = $('html,body');

	setInterval(function() {
		if(img==2){
			$('.slideImg.A').hide();
			$('.slideImg').css("opacity","0");
			$('.slideImg.A').show();
			img=0;
		}else{			
			$('.slideImg').height($('#slide1').height());
			//$('.slideImg.'+imgs[img]).show();
			$('.slideImg.'+imgs[img]).css("opacity","100");
			img++;
		}
	}, 6000);
	

	/**/	
	if (mywindow.scrollTop() < 1) {
		$('.navigation li[data-slide="1"]').addClass('active');
	}
	/**/

    slide.waypoint(function (event, direction) {

        dataslide = $(this).attr('data-slide');

        if (direction === 'down') {
            $('.navigation li[data-slide="' + dataslide + '"]').addClass('active').prev().removeClass('active');
			
			$('.navigation li[data-slide="1"]').removeClass('active');
			
        }
        else {
            $('.navigation li[data-slide="' + dataslide + '"]').addClass('active').next().removeClass('active');
        }

    });
 
    mywindow.scroll(function () {
        if (mywindow.scrollTop() == 0) {
            $('.navigation li[data-slide="1"]').addClass('active');
            $('.navigation li[data-slide="2"]').removeClass('active');
        }
    });

    /*function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.slide[data-slide="' + dataslide + '"]').offset().top + 2
        }, 2000, 'easeInOutQuint');
    }*/
	
	function goToByScroll(dataslide) {
		var goal = $('.slide[data-slide="' + dataslide + '"]').offset().top;
		if (mywindow.scrollTop()<goal) {
			var goalPx = goal + 5;
		} else {
			var goalPx = goal - 45;
		}
        htmlbody.animate({
            scrollTop: goalPx
        }, 2000, 'easeInOutQuint');
    }



    links.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });

    button.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);

    });
	
	
	// Sticky Navigation	
		$(".menu").sticky({topSpacing:0});
	
	//DROP menu	
	if ($(window).width()<750){
		$(".btn_dropdown").click(function(){
			$(".navigation").slideToggle("slow");
		});
		$(".navigation li").click(function(){
			$(".navigation").hide("fast");
		});
	}
	
	
	//Carousel
	jQuery('#mycarousel').jcarousel({
        auto: 10,
		scroll: 1,
        wrap: 'circular',
        initCallback: mycarousel_initCallback
    });
	//Tools Carousel
	jQuery('#tools').jcarousel({
        auto: 10,
		scroll: 1,
        wrap: 'circular',
        initCallback: toolsCarousel_initCallback,
		itemVisibleInCallback:{
			onBeforeAnimation: changeCarousel
		}
    });
	
	//prettyPhoto
	$("a[rel^='prettyPhoto']").prettyPhoto();
	
	//Image hover
	$(".hover_img").live('mouseover',function(){
			var info=$(this).find("img");
			info.stop().animate({opacity:0.53},300);
			$(".preloader").css({'background':'none'});
		}
	);
	$(".hover_img").live('mouseout',function(){
			var info=$(this).find("img");
			info.stop().animate({opacity:1},300);
			$(".preloader").css({'background':'none'});
		}
	);
	
	
	
	sliderHeight();
	
	mymargtop ();
	
	
	$("#slide1, #slide3, #slide5, #slide9").each(function () {
        var slide_h = $(this).height();
		
		$(this).css('background-size', '100% '+slide_h+'px');
		
    });
	
	
	//Iframe transparent
	 $("iframe").each(function(){
	  var ifr_source = $(this).attr('src');
	  var wmode = "wmode=transparent";
	  if(ifr_source.indexOf('?') != -1) {
	  var getQString = ifr_source.split('?');
	  var oldString = getQString[1];
	  var newString = getQString[0];
	  $(this).attr('src',newString+'?'+wmode+'&'+oldString);
	  }
	  else $(this).attr('src',ifr_source+'?'+wmode);
	 });
	
	
});

$(window).bind('resize',function() {
		
	//Update slider height
	sliderHeight();
	
	mymargtop ();
	
});






