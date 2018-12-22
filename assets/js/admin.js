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
});