// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(document).ready(function(){
    //load list of bands on page load 
    $.ajax({
        url:"app/",
        method: "GET",
        dataType: 'json',
        data: {
            action: 'bands'
        },
        success: function(res){
            //res should be an array of band ratings 
            console.log(res);
            for(var i=0;i<res.length;i++){
                var obj = res[i];
                if(obj["band"] != ""){
                    $('.public.rating.'+obj["band"]+' .value').html('Public Rating: '+obj["rate"]+' Skulls'); 
                }
            }
        },
        error: function(error_object, error_string, exception_object){
            $('.user-messages .message').html('Sorry, we can not load public ratings at this time').addClass('alert-box alert round');
        }
    });

    $('.rateit').click(function(){
        //Display the rating area to the user for this band
        var band = $(this).attr('data-band'); 
        $('.myrate.'+band).slideToggle();
    });

    $('.rate-action').click(function(){
        //Here we go, this is how a public user rates a band 
        var band = $(this).attr('data-band'); 
        var rating = $('.myrating.'+band).val();
        //send the data to the backend
        $.ajax({
            url:"app/",
            method: "POST",
            data: {
                action: 'rate',
            band: band,
            rating: rating
            },
            success: function(res){
                //html returned on success 
                $('.user-messages .message').html(res).addClass('alert-box round');
            },
            error: function(error_object, error_string, exception_object){
                $('.user-messages .message').html('Sorry, ajax request failed').addClass('alert-box alert round');
            }
        }).done(function(){
            console.log('done'); 
        });
    });
});
