var $ = require("jquery");

//ログイン認証前のヘッダーのハンバーガーメニュー実装
$(document).on('click', '.js-borders', function(){

    $('.l-header__menu').removeClass('not-active').addClass('active');

    $(this).addClass('js-flag');

    $(this).children().eq(0).addClass('border1');
    $(this).children().eq(1).addClass('border2');
    $(this).children().eq(2).addClass('border3');
});

$(document).on('click', '.js-borders.js-flag',function(){

    $('.l-header__menu').removeClass('active').addClass('not-active');

    $(this).children().eq(0).removeClass('border1');
    $(this).children().eq(1).removeClass('border2');
    $(this).children().eq(2).removeClass('border3');

    $(this).removeClass('js-flag');
});



//ログイン認証後のヘッダーのハンバーガーメニュー実装

$(document).on('click', '.js-borders2', function(){

    $('.l-header2__menu2').removeClass('not-active').addClass('active');

    $(this).addClass('js-flag');

    $(this).children().eq(0).addClass('border1');
    $(this).children().eq(1).addClass('border2');
    $(this).children().eq(2).addClass('border3');
});

$(document).on('click', '.js-borders2.js-flag',function(){

    $('.l-header2__menu2').removeClass('active').addClass('not-active');

    $(this).children().eq(0).removeClass('border1');
    $(this).children().eq(1).removeClass('border2');
    $(this).children().eq(2).removeClass('border3');

    $(this).removeClass('js-flag');
});