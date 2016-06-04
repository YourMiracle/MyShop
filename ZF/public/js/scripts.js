
$(function(){

    if(window.location.pathname == '/'){

        $('.bxslider').bxSlider({


        });
    var colors = new Array(
        [62,35,255],
        [60,255,60],
        [255,35,98],
        [45,175,230],
        [255,0,255],
        [255,128,0]);

    var step = 0;
//color table indices for:
// current color left
// next color left
// current color right
// next color right
    var colorIndices = [0,1,2,3];

//transition speed
    var gradientSpeed = 0.002;

    function updateGradient()
    {

        if ( $===undefined ) return;

        var c0_0 = colors[colorIndices[0]];
        var c0_1 = colors[colorIndices[1]];
        var c1_0 = colors[colorIndices[2]];
        var c1_1 = colors[colorIndices[3]];

        var istep = 1 - step;
        var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
        var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
        var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
        var color1 = "rgb("+r1+","+g1+","+b1+")";

        var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
        var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
        var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
        var color2 = "rgb("+r2+","+g2+","+b2+")";

        $('#gradient').css({
            background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"}).css({
            background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});

        step += gradientSpeed;
        if ( step >= 1 )
        {
            step %= 1;
            colorIndices[0] = colorIndices[1];
            colorIndices[2] = colorIndices[3];

            //pick two new target color indices
            //do not pick the same as the current one
            colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
            colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;

        }
    }

    setInterval(updateGradient,10);
    }
    $('.nav-hover').mouseover(function () {

        $('.hover-menu').animate({
            // left : '+=500',
            height: "toggle"

        },200)

    })

    // $('.nav-hover').mouseout(function () {
    //
    //     $('.hover-menu').animate({
    //         // left : '+=500',
    //         height: "toggle"
    //
    //     },200)
    //
    // })

    $('.nav.navbar-nav li').mouseover(function () {
        $(this).addClass('active');

    })
    $('.nav.navbar-nav li').mouseout(function () {

                $(this).removeClass('active');

    })


    function setCookie(name, value, options) {
        options = options || {};

        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }

        value = encodeURIComponent(value);

        var updatedCookie = name + "=" + value;

        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }

        document.cookie = updatedCookie;
    }

    $('.filter-price').click(function(){
        var data = new Array ;
        $('.filter-price').each(function(k,v){
            if($(this).prop("checked")){
                data.push($(this).val());
            }
        });
        document.cookie = "prices="+data;

        $.ajax({
            url : '/catalog',
            success: function(res){
                $('.goods').html($(res).find('.goods').html());
            }
        })
    })
    $('.list-group-item').click(function(){

        document.cookie = "cat="+$(this).data('id');

        $.ajax({
            url : '/catalog',
            success: function(res){
                $('.goods').html($(res).find('.goods').html());
            }
        })
    })

    $('.clear-filter').click(function(){

        document.cookie = "cat=";
        document.cookie = "prices=";
        $.ajax({
            url : '/catalog',
            success: function(res){
                $('.goods').html($(res).find('.goods').html());
            }
        })
    })


})