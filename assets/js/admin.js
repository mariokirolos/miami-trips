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
						'<div class="image"><button class="remove">x</button><input type="hidden" name="' + $this.data('inputname') + '[]" value="'+ id +'" /><img src="'+ thumbnail +'" /></div>');

				}
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



	function isEmail(emailAddress){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    	return pattern.test(emailAddress);
	}

});