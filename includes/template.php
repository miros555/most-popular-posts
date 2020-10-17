<div class="wrap popular-posts">


	<p><b>All posts or favorite only</b></p>
   
    <p><input name="sort" type="radio" value="all" <?php echo get_option( 'appearance')==='all'?'checked':''; ?>> All</p>
    <p><input name="sort" type="radio" value="favorite" <?php echo get_option( 'appearance')==='favorite'?'checked':''; ?>> Favorite only</p>


 
 
 <hr/>
 

 <div class="exception">

 <h4>Select if needed exception</h4>
 
  <?php 
		$arg = array( 
			'posts_per_page' => -1, 
			'meta_key' => 'wpb_post_views_count', 
			'orderby' => 'wpb_post_views_count', 
			'order' => 'DESC'  );
				
				$query = new WP_Query( $arg ); 
				
				if( $query->have_posts() ){  ?>
						
						<form id="form-query">
						
				<?php	while( $query->have_posts() ){ 
								$query->the_post();	 ?>
      
		<input class="query" type="checkbox" value="<?php echo get_the_ID();?>"/>
			<label for="<?php the_title();?>"><?php the_title();?></label><br/>
		
		<?php } 
		
				wp_reset_postdata(); 
	} ?>
		
		
		<p><input type="submit" value="Выбрать"></p>
		
	</form>
  
	</div>
			
				 	
  
 <br/> 
  
  <div>
  
   <h4>Select if needed categories</h4>
   
		<br/>
			<form id="category-query">
  <?php 
  
  $all_categories = get_categories('fields=names'); 
  
  foreach ($all_categories as $catg){  ?>
  <input class="catg" type="checkbox" <?php echo in_array( $catg, (array) get_option( 'category_query') ) ?'checked' : ''; ?>
			value="<?php echo $catg; ?>"/>
			<label for="catg"><?php echo $catg; ?></label><br/>
  
  
  <?php }  ?>
  
	<p><input type="submit" value="Выбрать"></p>
		</form>
  <br/>
          </div>

</div>