$('.header .tophead .menu-list .menu').click(function(){
    $(this).children(".sub").slideToggle()
    $(this).children('span::after').css("transform",'rotate(-90deg)')
})

$('.header .tophead .menushort').click(function(){
    $('.header .tophead .menu-list').slideToggle()
    $(this).toggleClass("open")
})

