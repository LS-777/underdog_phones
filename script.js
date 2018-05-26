// aos functions start
AOS.init();

//carousel speed
$('.carousel').carousel({
    interval: 2000
});


//from a transparent navbar to a solid background one, cheking on scroll activity
function checkScroll(){
    var startY = $('.nav__1').height() * 2; //The point where the navbar changes in px

    if($(window).scrollTop() > startY){
        $('.nav__1').addClass("scrolled");
    }else{
        $('.navbar').removeClass("scrolled");
    }
}

if($('.nav__1').length > 0){
    $(window).on("scroll load resize", function(){
        checkScroll();
    });
}



// Smooth scrolling to anchors
$('.goto').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top
    }, 500);
    return false;
});




