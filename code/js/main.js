$( document ).ready(function() {
	matchHeights();
	setImgSliders();
});

$(window).resize(function(){
	matchHeights();
	resizeImgSliders();
})

//ensure heights match where needed
function matchHeights(){
	$(".matchHeight").each(function(i, val){
		var h = $(this).find(".matchToThis").outerHeight();
		$(this).find(".matchThis").each(function(x, match){
			$(this).outerHeight(h)
		});
	});
}

//set up all the image sliders on the page
function setImgSliders(x){
	$(".imageSlider").each(function(i, val){
		var imgUl = $(val).find("ul").first();
		var selectorsUl = $(imgUl).clone().appendTo(val).addClass("selectors");
		var imgs = $(selectorsUl).find("li");
		$(imgs).first().addClass("selected");
		$(imgs).each(function(i, val2){
			$(val2).click(function(){
				selectorsUl.find(".selected").removeClass("selected");
				$(val2).addClass("selected");
				imgUl.css("left", i*-100 + "%");
				if(i != 0 && i != (imgs.length - 1)){
					selectorsUl.css("left", (i*-10)+10 + "em")
				}				
			});
		});
	});
	resizeImgSliders();
}

//separate part for sizing the images to make it responsive
function resizeImgSliders(){
	$(".imageSlider").each(function(i, val){
		var imgUl = $(val).find("ul").first();
		var imgLi = $(imgUl).find("li");
		$(imgUl).width($(val).innerWidth()*imgLi.length);
		$(imgUl).css("padding", "0");
		$(imgLi).each(function(i,val2){
			$(val2).width($(val).width());
		});
	});
}