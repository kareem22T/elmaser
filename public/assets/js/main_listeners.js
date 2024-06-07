$(function () {
    $('.left .social .more').on('click', function () {
        $('.left .social .links').fadeToggle('fast')
        if (!$('.left .social .links').hasClass('flex'))
            $('.left .social .links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.left .social .links').toggleClass('flex')
            }, 200);
    })
    $('.top .right .more').on('click', function () {
        $('.top .right .links').fadeToggle('fast')
        if (!$('.top .right .links').hasClass('flex'))
            $('.top .right .links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.top .right .links').toggleClass('flex')
            }, 200);
    })
    $('.bottom .right .more').on('click', function () {
        $('.bottom .right .mobil_links, .bottom  .hide-content').fadeToggle('')
        if (!$('.top .right .mobil_links').hasClass(''))
            $('.top .right .mobil_links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.top .right .mobil_links').toggleClass('flex')
            }, 200);
    })
    $('.bottom .left .more').on('click', function (e) {
        e.preventDefault()
        $('.bottom .right .mobil_links, .bottom  .hide-content').fadeToggle('')
        if (!$('.top .right .mobil_links').hasClass(''))
            $('.top .right .mobil_links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.top .right .mobil_links').toggleClass('flex')
            }, 200);
    })
    $('.bottom .hide-content').on('click', function () {
        $('.bottom .right .mobil_links, .bottom  .hide-content').fadeToggle('')
        if (!$('.top .right .mobil_links').hasClass(''))
            $('.top .right .mobil_links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.top .right .mobil_links').toggleClass('flex')
            }, 200);
    })
    $('.settings .more').on('click', function () {
        $('.settings .settings_links').fadeToggle('fast')
        if (!$('.settings .settings_links').hasClass('flex'))
            $('.settings .settings_links').toggleClass('flex')
        else
            setTimeout(() => {
                $('.settings .settings_links').toggleClass('flex')
            }, 200);
    })

})
