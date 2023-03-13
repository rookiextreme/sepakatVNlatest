function scrollToTop() {
    //scroll to the highest
    $('body').animate({ scrollTop: 0 }, 'fast');
    $('.parallax').animate({ scrollTop: 0 }, 'slow');
}
function createCookie(name,value,days) {
    //create cookie
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function isLetter(str) {
    return str.match(/[a-z]/i);
}

function forceCaps(obj) {
    obj.value = obj.value.toUpperCase().trim()
}
function forceCapsWithoutTrim(obj) {
    obj.value = obj.value.toUpperCase();
}
function forceNumeric(obj){
    obj.value = obj.value.replaceAll(',','');
}
function forceCurrency(obj){
    forceNumeric(obj);
    var thisval = obj.value;

    if(isLetter(obj.value)){
        thisval = null;
        console.log('saya huruf');
    }
    
    if(thisval){

        console.log('thisval' , thisval);

        thisval = thisval.replace(/[^\d.]+/g,'');
        var newCost = parseFloat(thisval).toFixed(2);
        obj.value = newCost.toString().replace(/\B(?=(\d{3})+(?!\d.))/g, ",");
    } else {
        obj.value = parseFloat(0).toFixed(2);
    }
}
function convertCurrency(thisval){
    //give comma
    var dTxt = thisval.toString();
    var myNew = dTxt.replace(/[^\d.]+/g,'');
    var newCost = parseFloat(myNew).toFixed(2);
    return newCost.toString().replace(/\B(?=(\d{3})+(?!\d.))/g, ",");
}
function getDefCurrency(fldId){
    //give comma
    var dTxt = $('#' + fldId).val().toString();
    var myNew = dTxt.replace(/[^\d.]+/g,'');
    var newCost = parseFloat(myNew).toFixed(2);
    return newCost.toString().replace(/\B(?=(\d{3})+(?!\d.))/g, ",");
}
function countGrandTotal() {
    var total = 0.0;
    var sum = 0.00;
    $('.currency').each(function(){
        var thisval = $(this).val();
        if(thisval == '')thisval = '0.00';
        $(this).val(parseFloat(thisval).toFixed(2));
        sum += +$(this).val();
    });
    $('#grandtotal').text(parseFloat(sum).toFixed(2));
}
function convertDateToDB(zdate) {
    //converting date to format that DB prefers

    //convert date first
    var mydate = zdate.substring(0, 2);
    var mymth = zdate.substring(3, 6);
    var numMth = 1;

    switch(mymth){
    case "Jan": numMth = 01;
        break;
    case "Feb": numMth = 02;
        break;
    case "Mar": numMth = 03;
        break;
    case "Apr": numMth = 04;
        break;
    case "May": numMth = 05;
        break;
    case "Jun": numMth = 06;
        break;
    case "Jul": numMth = 07;
        break;
    case "Aug": numMth = 08;
        break;
    case "Sep": numMth = 09;
        break;
    case "Oct": numMth = 10;
        break;
    case "Nov": numMth = 11;
        break;
    case "Dec": numMth = 12;
        break;
    }

    var myyr = zdate.substring(7, 11);
    return myyr + "-" + numMth + "-" + mydate;
    //alert(myyr + "-" + numMth + "-" + mydate);
}
function convertTimeToDB(ztime) {
    //converting date to format that DB prefers

    //convert date first
    var mmyam = ztime.substring(6, 8);
    var myhr = ztime.substring(0, 2);
    var mymin = ztime.substring(3, 5);
    if(mmyam == 'PM'){
        myhr = 12 + parseInt(myhr);
    }else{
        myhr = parseInt(myhr);
    }
    return myhr + ":" + mymin + ":00";
}
function acceptCookie() {
    createCookie('cooAccept', '1', 100);
    $('.mycookies').fadeOut('slow');
}
function readCookie(name) {
    //read cookie
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    //delete cookie
    createCookie(name,"",-1);
}
function closeCookies() {
    $('.cookies-layer').fadeOut();
}

function startLoading(){
    parent.$('#loading').show();
}
function stopLoading(){
    parent.$('#loading').hide();
}
// function openFromMenu(clink) {
//     var cwid = $(document).width();
//     if(parseInt(cwid) <= 1200) {
//         mobileOpen(clink);
//     }else{
//         //slowly blink
//         parent.startLoading();
//         createCookie('comAppsLink', clink, 1);
//         window.open(clink, "pg-apps");

//         setTimeout(function(){
//             document.getElementById("pg-apps").contentWindow.document.body.onclick =
//             function() {
//                 //console.log('hi bro');
//                 parent.togAdminMenu();
//             }
//         }, 500)
//     }
// }
function openPgInFrame(clink) {
    var cwid = $(document).width();
    if(parseInt(cwid) >= 1200) {
        parent.startLoading();
        createCookie('comAppsLink', clink, 1);
        window.open(clink, "pg-apps");
    }else{
        //slowly blink
        parent.startLoading();
        createCookie('comAppsLink', clink, 1);
        window.open(clink, "pg-apps");
        //frame = document.createElement('pg-apps');
        //frame.src = clink;

        //console.log('1212');

        setTimeout(function(){
            document.getElementById("pg-apps").contentWindow.document.body.onclick =
            function() {
                //console.log('hi bro');
                parent.togAdminMenu();
            }
        }, 500)
    }
}
function openFromMenu(clink) {
    //the one that close the side menu
    var cwid = $(document).width();
    if(parseInt(cwid) <= 1200) {
        //mobileOpen(clink);
        togAdminMenu();
        createCookie('comAppsLink', clink, 1);
        window.open(clink, "pg-apps");
    }else{
        //slowly blink
        parent.startLoading();
        createCookie('comAppsLink', clink, 1);
        window.open(clink, "pg-apps");
        //frame = document.createElement('pg-apps');
        //frame.src = clink;

        //console.log('1212');

        setTimeout(function(){
            document.getElementById("pg-apps").contentWindow.document.body.onclick =
            function() {
                //console.log('hi bro');
                //parent.togAdminMenu();
            }
        }, 500)
    }
}
function mobileOpen(clink) {
    togAdminMenu();
    createCookie('comAppsLink', clink, 1);
    window.open(clink, "pg-apps");
}
function goTo(clink) {
    window.open(clink, "_self");
}
function goTabOld(obj, content) {
    $('.tab-content').slideUp('fast');
    $('#' + content).slideDown('fast');
    var wd = parseInt($('#' + obj.id).css("width"));

    //alert($('.content').css("padding-right"));

    var diff = $('.quick-navigation .wrapper .cub-tab.active').css("padding-right");

    var tabId = obj.id;
    var tabNo = tabId.replace("tab", "");

    var differentiator = 17;
    var totalLf = 0;
    for (i = 1; i <= tabNo; i++) {
        if(i > 1){
            totalLf = totalLf + parseInt($('#tab' + (i-1)).css("width")) + parseInt(differentiator);
        }else{
            totalLf = 0;
        }
    }

    $('.quick-navigation .wrapper .cub-tab').removeClass('active');
    $('.quick-navigation .wrapper #' + obj.id).addClass('active');

    $('.under-active').animate({
        'width' : (parseInt(wd) - parseInt(diff)) + "px",
        'left' : parseInt(totalLf) + "px"
    });
}
function goTab(obj, content) {

    if($(obj).attr("disabled")){
        return false;
    }

    $('.quick-navigation .wrapper .cub-tab').removeClass('active');
    $('.quick-navigation .wrapper #' + obj.id).addClass('active');

    $('.tab-content').slideUp('fast');
    $('.tab-content#' + content).slideDown('fast');
    var wd = parseInt($('#' + obj.id).css("width"));

    var diff = $('.quick-navigation .wrapper .cub-tab:first').css("padding-right");

    var diff = $('.quick-navigation .wrapper .cub-tab.active').css("padding-right");

    var tabId = obj.id;
    var tabNo = tabId.replace("tab", "");

    let currentTotalTab = $('.cub-tab').length;
    let differentiator = 0;
    let totalUnactive = $('.cub-tab').not('.active').length;
    var totalLf = 0;

    $('.cub-tab:visible').each(function(i,o,u){
        let hasClass = $(this).hasClass("active");
        if(hasClass){
            return false;
        }
        differentiator = differentiator+5;
        totalLf = totalLf + parseInt($(this).css("width"));
    });

    // console.log('differentiator', differentiator);
    // console.log('totalLf' ,totalLf);

    // for (i = 1; i <= tabNo; i++) {
    //     if(i > 1){
    //         if($('#tab' + (i-1)).length){
    //             totalLf = totalLf + parseInt($('#tab' + (i-1)).css("width")) + parseInt(differentiator-1);
    //         }
    //     }else{
    //         totalLf = 0;
    //     }
    // }

    $('.under-active').animate({
        'width' : (parseInt(wd) - parseInt(diff)) + "px",
        'left' : parseInt(totalLf)+differentiator + "px"
    });
    window.location.hash = "tab="+parseInt(obj.id.split('tab')[1]);
}
function initTab() {
    var wd = parseInt($('.cub-tab:first').css("width"));
    var diff = $('.quick-navigation .wrapper .cub-tab.active').css("padding-right");

    $('.under-active').css({
        'width' : (parseInt(wd) - parseInt(diff)) + "px"
    });

    $('.tab-content').not('.tab-content:first').hide();
}
function togAppsMenu() {
    //toggleBigMenu();
    var topAppsMenu = $('.top-apps-menu').css('top');
    //var menuHeight = $('.top-apps-menu').css('height');
    //var menuHeight = Math.abs(parseInt(topAppsMenu));
    var cwid = $(document).width();
    var chit = $('.top-apps-menu').css('height');

    //by default, this menu was set to hidden. If hidden, then show
    if($('.top-apps-menu').is(":hidden") == true){
        $('.top-apps-menu').css("display","block");
    }
    if(parseInt(topAppsMenu) == 0){
        //menu is opened
        $('html, body').css({
            overflow: 'scroll',
            height: 'auto'
        });

        if(parseInt(cwid) <= 576) {
            xToBars();

            $('.top-apps-menu').animate({
                'top' : "-91vh"
            });
            $('.whole').animate({
                'marginTop' : "0px"
            });
        }
    }else{
        //open menu
        //to avoid page being moved
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });

        if(parseInt(cwid) <= 576) {
            //mobile view
            barsToX();

            $('.top-apps-menu').animate({
                'top' : "0vh"
            },{
                duration: 250,
                specialEasing: {
                width: "linear",
                height: "easeOutBounce"
                },
            });

            $('.whole').animate({
                'marginTop' : parseInt(chit) + "px"
            },{
                duration: 250,
                specialEasing: {
                width: "linear",
                height: "easeOutBounce"
                },
            });
        }
    }
}
function togAdminMenu() {
    //toggleFlyMenu();
    var leftFlyMenu = $('.flymenu').css('left');
    var cwid = $(document).width();


    if(parseInt(leftFlyMenu) >= 0){
        //menu is opened
        $('html, body').css({
            overflow: 'scroll',
            height: 'auto'
        });

        if(parseInt(cwid) < 1201) {
            xToBars();

            $('.flymenu').animate({
                'left' : "-100vw"
            },{
                duration: 250,
                specialEasing: {
                width: "linear",
                height: "easeOutBounce"
                },
            });
        }
    }else{
        //open menu
        //to avoid page being moved
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });

        if(parseInt(cwid) < 1200) {
            //mobile view
            barsToX();

            $('.flymenu').animate({
                'left' : "0px"
            },{
                duration: 250,
                specialEasing: {
                width: "linear",
                height: "easeOutBounce"
                },
            });
        }
    }
}
function barsToX() {
    //change Hamburger to X
    $('#bars-2').css('opacity','0');
    $('#bars-1').addClass('rotate45');
    $('#bars-3').addClass('rotate45b');
}
function xToBars() {
    //change Hamburger to X
    $('#bars-1').removeClass('rotate45');
    $('#bars-3').removeClass('rotate45b');
    $('#bars-2').css('opacity','1');
}

let scroll = {};
let scrollPower = 100;
function scrollToRight(target){

    if(!scroll[target]){
        scroll[target] = 0;
    }


    let currentScroll = document.getElementById(target).scrollLeft;
    if(scroll[target]>currentScroll){
        scroll[target] = currentScroll;
    } else {
        scroll[target] = scroll[target] + scrollPower;
    }

    console.log('scrollToRight ', scroll[target]);
    document.getElementById(target).scrollLeft = scroll[target];
}

function scrollToLeft(target){

    let currentScroll = document.getElementById(target).scrollLeft;

    scroll[target] = currentScroll;

    console.log('scrollToLeft ', scroll[target]);
    scroll[target] = scroll[target] - scrollPower;
    if(scroll[target] < 0){
        scroll[target] = 0;
    }
    document.getElementById(target).scrollLeft = scroll[target];
}

const calculatePercentageWFlow = function(target, progressBar, scProgress){

    let totalRequired = $('.text-danger').parent().parent().find(target).length;
    let totalValidated = 0;
    let totalLeftRequired = 0;
    let percentage = 0;
    let elementsRequired = [];

    $('.text-danger').parent().parent().find(target).each(function(i,o,u){

        $(this).css({
            'box-shadow': '0px 0px 0px 2px rgb(0 0 0 / 10%), inset 1px 0 5px rgb(0 0 0 / 3%)'
        });
        
        if($(this).data('type') == 'btn-group'){
            let hasAtleaseOne = $(this).parent().find('.'+$(this).data('type')).find('span.active, button.active').length;
            if(hasAtleaseOne > 0){
                totalValidated++;
            } else {
                elementsRequired.push(this);
            }
        } else if($(this).attr('type') == 'file'){
            console.log($(this).data('file'));
            if($(this).data('file') == 1){
                totalValidated++;
            } else {
                elementsRequired.push(this);
            }
        } else if($(this).attr('type') != 'file'){
            if(this.value != ''){
                totalValidated++;
            } else {
                elementsRequired.push(this);
            }
        }
    });

    totalLeftRequired = totalRequired - totalValidated;
    percentage = Math.round((totalValidated/totalRequired)*100);
    console.log('totalLeftRequired => ', totalLeftRequired);
    $(progressBar).attr('style','width: ' + percentage + '%');
    $(scProgress).text(percentage + '%');

    if(elementsRequired.length > 0){
        elementsRequired.forEach(element => {
            $(element).css({
                'box-shadow': '0px 0px 0px 2px rgb(245 3 3 / 56%), inset 1px 0 5px rgb(229 21 21 / 66%)'
            });
            element.focus();
        });
    }
    return {
        totalRequired: totalRequired,
        totalValidated: totalValidated,
        totalLeftRequired: totalLeftRequired,
        percentage: percentage,
        elementsRequired: elementsRequired
    };

}