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
    var pocet = 1;
    var cur = 0;
    var seat;
    var str = window.location.pathname.match('booking/([0-9]+)');
    var performance = str[1];
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
                            url: window.location.pathname + "?seat="+seat+"&do=Reservation",
                            success: function(payload){
                                console.log('Test');
                                console.log(payload);
                            }
                        });
                        selected.push(seat);
                        cur++;
                    } else {
                        alert('You can not book more seats than you selected.');
                    }
                } else {
                    if($.inArray(seat, selected)!==-1){
                        check(update, "/check.php?seat="+seat+"&id="+performance+"&state=3");                        
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
    
    $('#seats-number').on("click", function(){
        pocet = this.value;
        //console.log(pocet);
    });
    
    $('#proceed').on("click", function(ev){
        ev.preventDefault();
        if(selected.length===0){
            alert("You have not chosen any seats.");
            return;
        }
        var arr = JSON.stringify(selected);
        check(insert, "/check.php?id="+performance+"&state=1&seats="+arr);
    });
    
    $('.cinema').on('click', 'a', function(ev){
        ev.preventDefault();
        seat = this.id;
        elem = this;
        check(client, "/check.php?seat="+seat+"&id="+performance);
    });
    
    var dom = $(".md-modal");
    
    $(".md-overlay").click(function(){
        dom.removeClass("md-show");
        location.reload();
    });
    
    $(".show-md").click(function(){
        dom.addClass("md-show");
    });
});