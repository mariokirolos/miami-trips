$(document).ready(function(){
	$(document).on('click' , '.uploadBTN' , function(e){
		e.preventDefault();
		$this = $(this);

		var mediaUploader = wp.media({
			'title': $this.data('title') ,
			'button': {
				'text': $this.data('btn_text')
			},
			'multiple': $this.data('multiple')
		});

		mediaUploader.open();

		mediaUploader.on('select' , function(){
			//Clear current information
			$this.parents('.upload').find('.images').html('');	

				//Get Uploads
				var uploads = mediaUploader.state().get('selection').toJSON();
				//Insert each uploaded image to the container
				for(i = 0; i < uploads.length ; i++){
					id = uploads[i].id;
					thumbnail = uploads[i].sizes.thumbnail.url;

					$this.parents('.upload').find('.images').append(
						'<input type="hidden" name="' + $this.data('inputname') + '[]" value="'+ id +'" /><div class="image"><button class="remove">x</button><img src="'+ thumbnail +'" /></div>');

				}
		});

	});


	$(document).on('click' , '.image .remove' , function(e){
		e.preventDefault();
		$this = $(this);

		$('#confirmModal .modal-body').html('Are you Sure you want to remove this image?');

		//Confirm Deletion
			$('#confirmModal').modal('show');
			
		console.log('God is Love');

			$(document).on('click' , '#ConfirmRemoveBTN' , function(){

				$('#confirmModal').modal('hide');
				$this.parents('.image').prev('input').val('');
				$this.parents('.image').remove();
			});
	});

	$(document).on('focus' , '.datepicker' , function(){
		$(this).datepicker({
			changeMonth: true,
	      	changeYear: true
		})
	});

	$(document).on('keyup' , '.number' , function(){
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
	       this.value = this.value.replace(/[^0-9\.]/g, '');
	    }
	});


	$(document).on('blur' , '.email' , function(){
		$this = $(this);


		if($this.val() != 0)
        {
            if(isEmail($this.val()))
            {
                $this.removeClass('error');
            } else {
                $this.addClass('error');
                $this.val('');
            }
        } else {
        	$this.removeClass('error');
        }

	});



	$(document).on('click' , '#addNightBTN' , function(e){
		e.preventDefault();
		
		//Calculate number of nights and put it back on the top right span.
		$number = $('.night').length;

		//Clone the night div.
		$night = $('.nights .night:last').clone();
		//Reset the Div inputs
			$night.find("input[type='text']").val("");
			$night.find('input:checkbox').removeAttr('checked').attr('name' , 'meals['+ ($number) +'][]');
			$night.find("textarea").val("");
			$night.find('.images').html('');
		//Append the empty inputs to the main container
		$('.nights').append($night);
		
		$text = ( parseInt($number + 1) )+ ' Nights';
		
		$('#no_of_nights').html($text);
	});


	$(document).on('click' , '.removeDay' , function(e){
		e.preventDefault();
		$this = $(this);

		$('#confirmModal .modal-body').html('Are you Sure you want to remove this night?');
	

		$number = $('.night').length;

		if($number > 1){
			
			//Confirm Deletion
			$('#confirmModal').modal('show');

			$(document).on('click' , '#ConfirmRemoveBTN' , function(){

				$('#confirmModal').modal('hide');
				// //Calculate number of nights and put it back on the top right span.

				$number = $('.night').length;
				$text =   ( parseInt($number - 1) )+ ' Nights';
				console.log($number);

				$this.parents('.night').remove();

				$('#no_of_nights').html($text);

			});

		}else{
			
			$('#ErrorModal .modal-body').html('Error! At least one date should be there');
			$("#ErrorModal").modal('show');
			$text =  'Repeated ' + ( parseInt($number - 1) )+ ' times';
		}
	});

	

	$(document).on('click' , '#addDateBTN' , function(e){
		e.preventDefault();
		//Calculate number of nights and put it back on the top right span.
		$number = $('.date').length;

		//Clone the date div.
		$date = $('.dates .date:last').clone();
		//Reset the Div inputs
			$date.find("input[type='text']").val("");

			$date.find('.datepicker').removeAttr('id');
			$date.find('.datepicker').removeClass('hasDatepicker');

		//Append the empty inputs to the main container
		$('.dates').append($date);
		
		$text =  'Repeated ' + ( parseInt($number) )+ ' times';
		
		$('#no_of_dates').html($text);
	});
	
	$(document).on('click' , '.removeDate' , function(e){
		e.preventDefault();
		$this = $(this);
	
		$('#confirmModal .modal-body').html('Are you Sure you want to remove this Date?');

		$number = $('.date').length;

		if($number > 1){
			
			//Confirm Deletion
			$('#confirmModal').modal('show');

			$(document).on('click' , '#ConfirmRemoveBTN' , function(){

				$('#confirmModal').modal('hide');
				// //Calculate number of nights and put it back on the top right span.

				$number = $('.date').length;
				$text =  'Repeated ' + ( parseInt($number - 1) )+ ' times';
				console.log($number);

				$this.parents('.date').remove();

				$('#no_of_dates').html($text);

			});

		}else{
			
			$('#ErrorModal .modal-body').html('Error! At least one date should be there');
			$("#ErrorModal").modal('show');
			$text =  'Repeated ' + ( parseInt($number - 1) )+ ' times';
		}
	});


	function isEmail(emailAddress){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    	return pattern.test(emailAddress);
	}

});




$(window).load(function(){
    //Disable the Title field for the Reservations
    ConfirmationNumber
    if (($("#post_type").length > 0)){
        if($("#post_type").val() == 'miami_reservations'){
            $('#title').attr("readonly", true);
        }
    }
});