<?php
/*

Plugin Name: Popular Posts
Author: Miro
Version: 1.2
*****

*/

add_action( 'wp_enqueue_scripts', 'popular_posts_styles' );
function popular_posts_styles() {
		wp_enqueue_style('style-plugin', plugins_url('popular-posts/style.css') );
}


add_action( 'admin_enqueue_scripts', 'action_function_scripts' );
function action_function_scripts( $hook_suffix ){
			wp_enqueue_style('admin-style', plugins_url('popular-posts/includes/admin-style.css') );
			wp_enqueue_script( 'admin-script', plugins_url('popular-posts/js/admin-script.js'), ['jquery'] );
}


add_action( 'admin_menu', 'Add_My_Admin_Link' );
 
function Add_My_Admin_Link() {
		add_menu_page(
			'Most_popular_posts', 
			'Popular posts', 
			'manage_options', 			
			'popular-posts/includes/template.php', '','', 5
		);
}


add_action( 'wp_ajax_appearance', 'set_appearance' ); 
function set_appearance(){
		$arg = substr($_POST['arg'],5);
		update_option( 'appearance', $arg);
	
}	


add_action( 'wp_ajax__query', 'set_query' ); 

function set_query(){
			$param = $_POST['param'];
			$args = $_POST['args'];
			
				foreach ($args as $a){
					wp_set_post_tags( $a, $_POST['param'], false);
				}
	
}	


add_action( 'wp_ajax__category_query', 'set_category_query' ); 

function set_category_query(){
			$args = $_POST['args'];

			update_option( 'category_query', $args);	
}	


function wpb_set_post_views($postID) {
	
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){
       
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
		
		$cookie = 'view_post_'. $postID;

		if( empty($_COOKIE[$cookie]) ){
            setcookie($cookie, 1, time()+86400*30, '/', $_SERVER["HTTP_HOST"]);
			$count++;
            update_post_meta($postID, $count_key, $count);
        } else {
			
			return;
		}   
        
    }
	

}

add_action( 'wp', 'wpb_track_post_views');

function wpb_track_post_views () {
	
		global $post;
		$count_key = 'wpb_post_views_count';
		$postID = $post->ID; 
		
		$count = get_post_meta($postID, $count_key, true);

		if($count==''){
       
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
		
		}else{
		
			$cookie = 'view_post_'. $postID;
		
		
		
			if( empty($_COOKIE[$cookie]) ){
				setcookie($cookie, 1, time()+86400*30, '/', $_SERVER["HTTP_HOST"]);
				$count++;
				update_post_meta($postID, $count_key, $count);
			} else {
			
				return;
		}
  
    }

}


add_action( 'pre_get_document_title', 'wpb_get_post_views');

function wpb_get_post_views(){
	
		if ( !is_single() ) return;
		
		global $post;
		$post_id = $post->ID;    
	
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta($post_id, $count_key, true);
			
		!isset($_COOKIE['view_post']) ? $count : null;

		echo '<h3 class="views"> '.$count.' Views</h3><br>';

}	
		
				
add_shortcode('popular_posts', 'post_views');
  
function post_views($postID){
	
		if ( !empty(get_option( 'category_query')) ) {
					$catgs = get_option( 'category_query');
					$catgs = implode (',',$catgs);
					$catgs = ['category_name' => $catgs];
				} else {
					$catgs = '';
				}
				
				
				$arg = array( 
					'posts_per_page' => 3, 
					'meta_key' => 'wpb_post_views_count',
					'orderby' => 'wpb_post_views_count', 
					'order' => 'DESC',
					$catgs,
					'tax_query' => array(
       
					'relation' => 'OR',
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'slug',
							'terms'    => 'included',
							'operator' => 'IN'
							),
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'slug',
							'terms'    => 'exception',
							'operator' => 'NOT IN'
							),
						)
					);
			
			$query = get_posts( $arg ); 
				
						$count = 0;
						$content = '<h3 class="mp">MOST**POPULAR**POSTS</h3>';
						
			foreach ( $query as $post ){
						
						$count++;
					
				$post_id = (string) $post->ID;
				$post_views = get_post_meta($post_id, 'wpb_post_views_count', true);
				$post_views = !empty ($post_views) ? 'Views: '.$post_views : 'Views: 0';
	
				$content.= '<div class="single-post"><h2>' . $count . ' POSITION</h2><div class="float">' 
							. get_the_post_thumbnail($post_id) . '<div>'. $post->post_date . '<h4>
							<h5>'.$post_views.'</h5><h4><a href="' . $post->guid . '">'
							.$post->post_title. '</a></h4>' . $post->post_excerpt . '<br> 
							<a href="' . $post->guid . '" class="read-more">READ MORE</a></div>';  
							
						}  
		
		return $content;

}