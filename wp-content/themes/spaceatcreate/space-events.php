<?php
/*
 * ========================================================================
 *  Event Custom Type
 * ========================================================================
 */

// create post type
function create_post_type() {
	$args = array(
		'labels' => post_type_labels('Event'),
		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'has_archive' => true,
		'description' => 'This is where you can create new Exhibition listings',
		'rewrite' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'revisions'
		)
	);
	
	register_post_type('event', $args);
}

// Helpers for Event labels
function post_type_labels($singular, $plural = '') {
	if($plural == '') $plural = $singular .'s';
	
	return array(
		'name' => _x( $plural, 'post type general name'),
		'singular_name' => _x( $singular, 'post type singular name'),
		'add_new' => __('Add New'),
		'add_new_item' => __('Add New'. $singular),
		'edit_item' => __( 'Edit '. $singular ),
		'new_item' => __( 'New '. $singular ),
		'view_item' => __( 'View '. $singular ),
		'search_items' => __( 'Search '. $plural ),
		'not_found' =>  __( 'No '. $plural .' found' ),
		'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
		 'parent_item_colon' => ''
	);
}

// This is for all the messages that come up when you edit/save et
function post_type_updated_messages( $message) {
	global $post, $post_ID;
	
	$message['event'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Event updated. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Event updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Event published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Event saved.'),
		8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) )
	);
	
	return $messages;
}

// Customise the length of excerpts for Event Posts
function custom_trim_excerpt($text) { // Fakes an excerpt if needed
	global $post;
	
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = 20;
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}
	}
	return $text;
}

/*
 * meta boxes for the date fields required for events
*/

$meta_box['event'] = array(
	'id' => 'post_format_meta',
	'title' => 'Exhibition Dates',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Start Date',
			'desc' => 'dd/mm/yy',
			'id' => 'event_start_date',
			'type' => 'date',
			'default' => ''
		),
		array(
			'name' => 'End Date',
			'desc' => 'dd/mm/yy',
			'id' => 'event_end_date',
			'type' => 'date',
			'default' => ''
		)
	)
);


// Add meta post box types
function plib_add_box() {
	global $meta_box;
	
	foreach($meta_box as $post_type => $value) {
		add_meta_box(
			$value['id'],
			$value['title'],
			'plib_format_box',
			$post_type,
			$value['context'],
			$value['priority']
		);
	}
}

// format the meta box
function plib_format_box() {
	global $meta_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="plib_meta_box_nonce" value="',wp_create_nonce(basename(__FILE__)),'">';
	
	echo '<div class="form-wrap">';
	
	foreach($meta_box[$post -> post_type]['fields'] as $field) {
		// get current data
		$meta = get_post_meta($post -> ID, $field['id'], true);
		
		echo '<label for="'.$field['id'].'">'.$field['name'].'</label>';

		switch($field['type']) {
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta ? $meta : $field['default']).'">'. $field['desc'];
			break;
						
			case 'textarea':
				echo '<textarea type="text" name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4" value="'.($meta ? $meta : $field['default']).'"></textarea>'.
				'<br>'.
				$field['desc'];
			break;
						
			case 'select':
				echo '<select type="text" name="'.$field['id'].'" id="'.$field['id'].'">';
				foreach($field['options'] as $option) {
					echo '<option '. ( $meta == $option ? ' selected="selected"' : '' ) . '>'.$option.'</option>';
				}
				echo '</select>'.
				'<br>'.
				$field['desc'];
			break;
					
			case 'radio' :
				foreach($field['options'] as $option) {
					echo '<input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$option['value'].'" ' .( $meta == $option['value'] ? ' checked="checked"' : ''). '>'.
					$option['name'];
				}
			break;
					
			case 'checkbox' :
				foreach($field['options'] as $option) {
					echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ' .( $meta ? ' checked="checked"' : ''). '>'.
					$option['name'];
				}
			break;
			
			case 'date':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.($meta ? $meta : $field['default']).'" class="date-picker">'. $field['desc'];
				break;
		}
	}
	
	echo '</div><!-- /@form-wrap -->';
}

// save data from fields
function plib_save_data($post_id) {
	global $meta_box, $post;
	
	// verify nonce
	if(!wp_verify_nonce($_POST['plib_meta_box_nonce'],basename(__FILE__))) {
		return $post_id;
	}
	
	// check autosave
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	
	// check permissions
	if('page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	}
	elseif(!current_user_can('edit_post', $post_id)){
		return $post_id;
	}
		
	foreach($meta_box[$post->post_type]['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		
		$new = $_POST[$field['id']];
		
		if($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		}
		elseif ('' == $new && $old) {
			delete_meta_post($post_id, $field['id'], $old);
		}
	}
}

// Add custom scripts for jquery UI for events
function plib_events_jquery_datepicker() {
	wp_enqueue_script(
		'jquery-ui-datepicker',
		get_template_directory_uri() . '/js/jquery-ui-datepicker/jquery-ui-1.8.11.custom.min.js',
		array('jquery')
	);
	
	wp_enqueue_script(
		'plib-datepicker',
		get_template_directory_uri() . '/js/jquery-ui-datepicker/plib-datepicker.js',
		array('jquery', 'jquery-ui-datepicker')
	);
}

// Add custom styles for jquery UI date-picker
function plib_events_jquery_datepicker_css() {
	wp_enqueue_style(
		'jquery-ui-datepicker',
		get_template_directory_uri() . '/js/jquery-ui-datepicker/css/smoothness/jquery-ui-1.8.11.custom.css'
	);
}

// Custom Events Actions
add_action('init', 'create_post_type');
add_action('admin_menu','plib_add_box');
add_action('save_post', 'plib_save_data');

// Custom Event Filters
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');
add_filter('post_type_messages', 'post_type_updated_messages');

// addding the date picker components
add_action('admin_print_scripts-post-new.php', 'plib_events_jquery_datepicker');
add_action('admin_print_scripts-post.php', 'plib_events_jquery_datepicker');

add_action('admin_print_scripts-post-new.php', 'plib_events_jquery_datepicker_css');
add_action('admin_print_scripts-post.php', 'plib_events_jquery_datepicker_css');
?>