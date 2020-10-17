
jQuery(function($){

	
	  $('#appearance').submit(function(e){
                e.preventDefault();
        
                $.ajax({
                    type: "POST",
                    url:ajaxurl,
                    data: {
                        arg:$('#appearance').serialize(),
                        action:'appearance'
                        },
                    success: function() {
                        console.log('appearance!'); 
                    
                    }
				});
             
        
		});	
		
		
		/******************************Exception************************/
		
		$('input[name="sort"]').click(function(){
			
				$('.exception').show();
				console.log('test'); 
				
				if ($(this).val()=='all'){
						$('#form-query').attr('class','exception');
						$('.exception>h4').html('Choose <span style="color:red;">exception</span>');
				} else {
						$('#form-query').attr('class','included');
						$('.exception>h4').html('Choose <span style="color:green;">included</span>');
				}
		});
		
		

		$('#form-query').submit(function(e){
                e.preventDefault();
                var arr = [];
				$('.query:checked').each(function(i,el){
						arr.push(el.value);
				});
                
                $.ajax({
                    type: "POST",
                    url:ajaxurl,
                    data: {
                        args:arr,
                        action:'_query',
						param:$('#form-query').attr('class')
                        },
                    success: function() {
                        console.log('_query'); 
						console.log(arr);
						location.reload();
                    
                    }
				});
             
        
		});	
		
		
			
			
			
			$('#category-query').submit(function(e){
                e.preventDefault();
                var arr_catg = [];
				$('.catg:checked').each(function(i,el){
						arr_catg.push(el.value);
				});
                
                $.ajax({
                    type: "POST",
                    url:ajaxurl,
                    data: {
                        args:arr_catg,
                        action:'_category_query'
                        },
                    success: function() {
                        console.log('_category_query'); 
						console.log(arr_catg);
                    
                    }
				});
             
        
		});	
		
		
			

	
});