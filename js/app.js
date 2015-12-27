// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(document).ready(function(){
   $('.rateit').click(function(){
       //Display the rating area to the user for this band
       var band = $(this).attr('data-band'); 
       $('.myrate.'+band).slideToggle();
   });

   $('.rate-action').click(function(){
       console.log('clicked');
       //Here we go, this is how a public user rates a band 
       var band = $(this).attr('data-band'); 
       var rating = $('.myrating.'+band).val();
       //send the data to the backend
       $.ajax({
           url:"192.168.33.10/app/index.php",
           method: "POST",
           contentType: 'text/plain',
           data: {
                action: 'update',
                band: band,
                rating: rating
           },
           success: function(res){
                //html returned on success 
                $('.user-messages .message').html(res).addClass('alert-box round');
                console.log('success'); 
           },
           error: function(error_object, error_string, exception_object){
                $('.user-messages .message').html('Sorry, ajax request failed').addClass('alert-box alert round');
                console.log('error'); 
                console.log(error_object); 
                console.log(error_string); 
                console.log(exception_object); 
           }
       }).done(function(){
            console.log('done'); 
       });
   });
});
