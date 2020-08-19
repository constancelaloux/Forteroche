// navbar background color change on scroll
$(window).scroll(function()
{
    var scroll = $(window).scrollTop();
    if(scroll < 200)
    {
        $('#navbar').css('background', 'transparent');
        $('a.nav-link').css('color', '#111');
    } 
    else
    {
        $('#navbar').css('background', '#1d1919');
        $('a.nav-link').css('color', 'white');
    }
});

