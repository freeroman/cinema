/*
$(function() {
    $.nette.init();
});*/

$(function(){
    $.nette.init();
    
    if(window.location.pathname.match(".*homepage/booking/[0-9]+.*")){
        setTimeout(function(){
            get_seats();
        }, 5000);
    }
    
    setTimeout(function(){
            location.reload();
        }, 300000);
    
    function get_seats(){ 
        $.nette.ajax({
            url: window.location.pathname + "?do=reload",
            complete: function (payload) { 
                setTimeout(function(){
                    get_seats();
                }, 10000);
            } 
        });
    } 
});

function check(client, url){
    //console.log('GET: '+url);
    client.open('GET',url, true); 
    client.send();
}

$(document).ready(function(){  
    var pocet = 4;
    var cur = 0;
    var seat;
    var str = window.location.pathname.match('booking/([0-9]+)');
    var performance = str!==null ? str[1] : null;
    var selected = new Array();
    var elem;
    var code = null;
    
    var client = new XMLHttpRequest();
    
    var update = new XMLHttpRequest();
    
    var insert = new XMLHttpRequest();
    
    update.onreadystatechange = function(){
        if (this.readyState==4){
            if (this.status==200) {
                $.nette.ajax({
                            url: window.location.pathname + "?do=reload"
                        });
            }
        }
    };
    
    insert.onreadystatechange = function(){
        if (this.readyState==4){
            if (this.status==200) {
                console.log(this.responseText);
                code = JSON.parse(this.responseText);
                var href = window.location.href.match('(.*)/[^/]+/[^/]+$');
                window.location.href = href[1] + "/completed?code="+code;
            }
        }
    };
    
    client.onreadystatechange = function(){
        if (this.readyState==4){
            if (this.status==200) {
                //console.log('log: '+this.responseText);
                var obj = JSON.parse(this.responseText);
                if(obj){
                    if(cur<pocet)
                    {
                        $.nette.ajax({
                            url: window.location.pathname + "?seat="+seat+"&do=Reservation"/*,
                            success: function(payload){
                                console.log('Test');
                                console.log(payload);
                            }*/
                        });
                        selected.push(seat);
                        cur++;
                    } else {
                        alert('You can not book more than ' + pocet + ' seats.');
                    }
                } else {
                    if($.inArray(seat, selected)!==-1){
                        check(update, "/cinema/www/check.php?seat="+seat+"&id="+performance+"&state=3");                        
                        selected.splice( $.inArray(seat, selected), 1 );
                        cur--;
                    } else {
                        alert('We are sorry but this seat is already taken.');
                    }
                }
                /*currPos=obj.pos;
                image.alt=obj.title;
                image.src=obj.img;
    
    
                
                desc.innerHTML=obj.info;*/
                //counter.innerHTML=(parseInt(obj.pos)+1);
            }
        }
    };
    /*
    $('#seats-number').on("click", function(ev){
        if(cur>pocet){
            alert("You have selected");
        }
        pocet = this.value;
    });*/
    
    $('#frm-selectCinemas-cinema').on("change", function(){
        $.nette.ajax({
            url: window.location.pathname + "homepage/default/"+$(this).find('option:selected').val()+"?do=Cinemas"
        });
    });
    
    $('#proceed').on("click", function(ev){
        ev.preventDefault();
        if(selected.length===0){
            alert("You have not chosen any seats.");
            return;
        }
        var arr = JSON.stringify(selected);
        check(insert, "/cinema/www/check.php?id="+performance+"&state=1&seats="+arr);
    });
    
    $('.cinema').on('click', 'a', function(ev){
        ev.preventDefault();
        seat = this.id;
        elem = this;
        check(client, "/cinema/www/check.php?seat="+seat+"&id="+performance);
    });
    
    
    //var dom = $(".md-modal");
    /*
    $(".md-overlay").click(function(){
        $(".modal div").removeClass("md-show");
        location.reload();
    });*/
    
    $("#add-perfomrnace").click(function(){
        $("#frm-newPerformance").toggle();
    });
    
    $("#add-film").click(function(){
        $("#frm-newFilm").toggle();
    });
    
    $("#add-cinema").click(function(){
        $("#frm-newCinema").toggle();
    });
});