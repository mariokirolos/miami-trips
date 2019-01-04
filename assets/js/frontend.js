$('#days_slider').on('slide.bs.carousel', function (e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('.carousel-item').length;
    
    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});

$(document).on('click' , '.itinerary_day' , function(e){
    e.preventDefault();
    $this = $(this);
    target_id = $this.data('target');



    console.log(target_id);


    $('#itinerary').slideUp('fast' , function(){
        $('#itinerary .card').removeClass('active');
        $("#itinerary").find(".card[data-id='" + target_id + "']").addClass('active');

        $(this).slideDown('fast');
    });
});

$(document).on('click' , '.book-now' , function(e){
    e.preventDefault();
    trip_date = $(this).data('date');
    $('#date_from option').removeAttr('selected');
    $('#date_from option[value="' + trip_date + '"]').attr("selected", "selected");
});

