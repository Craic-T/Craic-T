$( document ).ready(function() {

    const currentUrl = window.location.href;
    console.log(currentUrl);

    $("nav>ul>li>a").each(function(){
        console.log($(this).attr('href'));
        if(currentUrl.includes($(this).attr('href')))
        {
            $(this).addClass('selected');
        }
    })

});