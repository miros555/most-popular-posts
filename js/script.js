
jQuery(function($){

console.log(optionalData.postID); 

		function register_view_post(){
          
                $.ajax({
                    type: "POST",
                    url: optionalData.url,
                    data: {
                        view_post: optionalData.postID,
                        action:'view_post'
                        },
                    success: function() {
                        console.log('new view post!'); 
						document.cookie = "view_post="+optionalData.postID;
                    
                    }
                });
               
            } 
	
			
		register_view_post();
	
	
});