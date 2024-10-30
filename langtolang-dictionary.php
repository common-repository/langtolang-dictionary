<?php
/*
Plugin Name: Langtolang Dictionary
Plugin URI: http://www.langtolang.com/external/wordpress/
Description: Langtolang Dictionary Sidebar Widget for WordPress provides a multilingual dictionary translating from/to English, Arabic, Chinese Simplified, Chinese Traditional, Czech, Danish, Dutch, Estonian, Finnish, French, German, Greek, Hungarian, Icelandic, Indonesian, Italian, Japanese, Korean, Latvian, Lithuanian, Norwegian, Polish, Portuguese Brazil, Portuguese Portugal, Romanian, Russian, Slovak, Slovenian, Spanish, Swedish, Turkish from the wordpress sidebar.
Version: 1.0.1
Author: Baris Efe
Author URI: http://www.langtolang.com
*/
// Register and load the widget
function langtolang_load_widget() {
	register_widget( 'langtolang_widget' );
}
add_action( 'widgets_init', 'langtolang_load_widget' );
// Creating the widget
class langtolang_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
				// Base ID of your widget
				'langtolang_widget',
				// Widget name will appear in UI
				__('Langtolang Dictionary', 'langtolang_widget_domain'),
				// Widget description
				array( 'description' => __( 'Langtolang Dictionary Sidebar Widget for WordPress provides a multilingual dictionary translating from/to English, Arabic, Chinese Simplified, Chinese Traditional, Czech, Danish, Dutch, Estonian, Finnish, French, German, Greek, Hungarian, Icelandic, Indonesian, Italian, Japanese, Korean, Latvian, Lithuanian, Norwegian, Polish, Portuguese Brazil, Portuguese Portugal, Romanian, Russian, Slovak, Slovenian, Spanish, Swedish, Turkish from the wordpress sidebar.', 'langtolang_widget_domain' ), )
				);
	}
	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

			//print_r($instance);
			//echo "langtolang-selectFrom".$widget_langtolang-selectFrom;
			$selectFrom = $instance['langtolang-selectFrom'];
			if ( empty($selectFrom) )
				$selectFrom = 'english';
				$htmlSelectFrom = '<select name="selectFrom" class="widefat">'.prepare_html_language_options($selectFrom).'</select>';
					
				$selectTo = $instance['langtolang-selectTo'];
				if ( empty($selectTo) )
					$selectTo = 'spanish';
					$htmlSelectTo = '<select name="selectTo" class="widefat">'.prepare_html_language_options($selectTo).'</select>';

					// This is where you run the code and display the output
					echo __( '
			<form role="search" name="langtolang" method="get" action="http://www.langtolang.com/" target="_blank" class="search-form">
			<label class="screen-reader-text" for="txtLang">Search</label>
			<input type="text" name="txtLang" id="txtLang" value="" placeholder="'. esc_attr_x( 'Search &hellip;', 'placeholder' ) .'">
			<label class="screen-reader-text" for="selectFrom">Select From</label>
			'.$htmlSelectFrom.'
			<label class="screen-reader-text" for="selectTo">Select To</label>
			'.$htmlSelectTo.'
			<br/><button type="submit" class="submit button" id="search-submit">'. esc_attr_x( 'Search', 'submit button' ) .'</button>
			</form>

						', 'langtolang_widget_domain' );
						
					echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		//$this->loadOptions($instance);
		//print_r($instance);
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Langtolang Dictionary', 'langtolang_widget_domain' );
		}
		// Widget admin form
		?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
	<?php
	echo $instance['langtolang-selectFrom'].$instance['langtolang-selectTo'];
	$default_language_from = $instance['langtolang-selectFrom'];
	if ( empty($default_language_from) )
		$default_language_from = 'english';
	$default_language_to = $instance['langtolang-selectTo'];
	if ( empty($default_language_to) )
		$default_language_to = 'spanish';
	echo $default_language_from.$default_language_to;
	?>
	<p>
		<label for="langtolang-selectFrom"><?php _e('Default From'); ?></label>
		<br /><select class="widefat" id="<?php echo $this->get_field_id( 'langtolang-selectFrom' ); ?>" name="<?php echo $this->get_field_name( 'langtolang-selectFrom' ); ?>">
<?php 
	echo prepare_html_language_options($default_language_from);
?>
		</select>
	</p>
	<p>
		<label for="langtolang-selectTo"><?php _e('Default To'); ?></label>
		<br /><select class="widefat" id="<?php echo $this->get_field_id( 'langtolang-selectTo' ); ?>" name="<?php echo $this->get_field_name( 'langtolang-selectTo' ); ?>">
<?php 
	echo prepare_html_language_options($default_language_to);
?>
		</select>
	</p>
		<input type="hidden" id="langtolang-submit" name="langtolang-submit" value="1" />

<?php 
// Widget admin form end
}
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	echo "new_instance";
	print_r($new_instance);
	print_r($old_instance);
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['langtolang-selectFrom'] = ( ! empty( $new_instance['langtolang-selectFrom'] ) ) ? strip_tags( $new_instance['langtolang-selectFrom'] ) : '';
	$instance['langtolang-selectTo'] = ( ! empty( $new_instance['langtolang-selectTo'] ) ) ? strip_tags( $new_instance['langtolang-selectTo'] ) : '';
	return $instance;
}
} // Class langtolang_widget ends here



function prepare_html_language_options($default_language) {
	$LANGUAGES = array(
			"english"=>"English",
			"arabic"=>"Arabic",
			"chinese_simplified"=>"Chinese Simplified",
			"chinese_traditional"=>"Chinese Traditional",
			"czech"=>"Czech",
			"danish"=>"Danish",
			"dutch"=>"Dutch",
			"estonian"=>"Estonian",
			//"esperanto"=>"Esperanto",
			"finnish"=>"Finnish",
			"french"=>"French",
			"german"=>"German",
			"greek"=>"Greek",
			"hungarian"=>"Hungarian",
			"icelandic"=>"Icelandic",
			"indonesian"=>"Indonesian",
			"italian"=>"Italian",
			"japanese"=>"Japanese",
			"korean"=>"Korean",
			"latvian"=>"Latvian",
			"lithuanian"=>"Lithuanian",
			"norwegian"=>"Norwegian",
			"polish"=>"Polish",
			"portuguese_brazil"=>"Portuguese Brazil",
			"portuguese_portugal"=>"Portuguese Portugal",
			"romanian"=>"Romanian",
			"russian"=>"Russian",
			//"serbo_croat"=>"Serbo Croat",
			"slovak"=>"Slovak",
			"slovenian"=>"Slovenian",
			"spanish"=>"Spanish",
			//"swahili"=>"Swahili",
			"swedish"=>"Swedish",
			"turkish"=>"Turkish");

	$html="";
	foreach ($LANGUAGES as $key => $value) {
		if ($default_language==$key) {
			$html .= '<option selected="selected" value="'.$key.'" label="'.$value.'">'.$value.'</option>';
		} else {
			$html .= '<option value="'.$key.'" label="'.$value.'">'.$value.'</option>';
		}
	}
	return $html;
}

?>