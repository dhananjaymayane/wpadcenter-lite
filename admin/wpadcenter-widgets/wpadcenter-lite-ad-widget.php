<?php

if( !class_exists('ADWidget_lite')){

	class ADWidget_lite extends WP_Widget {
		function ADWidget_lite() {
			//Constructor
			parent::__construct(false, $name = 'WP Adcenter', array('description' => 'Widget For AdCenter Plugin.'));
		}


		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			$category = (is_numeric($instance['category']) ? (int)$instance['category'] : '');
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			if ( $category )
			{if( function_exists( 'wpadl_displayAdzone' ) )    echo wpadl_displayAdzone( $category );}

			/* After widget (defined by themes). */
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			//update and save the widget

			return $new_instance;
		}
		function form($instance) {
			//widgetform in backend
			global $wpdb;
			$totalZones = wpadl_totalZones('ORDER BY name ASC');

			$category = !empty($instance) ? esc_attr($instance['category']):'';

			$title = !empty($instance) ? strip_tags($instance['title']):'';
			// Get the existing categories and build a simple select dropdown for the user.
			$categories = $totalZones;
			$cat_options = array();
			$cat_options[] = '<option value="BLANK">Select one...</option>';
			for($i=0;$i<count($categories);$i++) {
				$selected = $category === $categories[$i]->id ? ' selected="selected"' : '';
				$cat_options[] = '<option value="' . $categories[$i]->id .'"' . $selected . '>' . $categories[$i]->name . '</option>';
			}
			?>
<p>

	<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>" type="text"
		value="<?php echo $instance['title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('category'); ?>"> <?php _e('Select Ad Zone:'); ?>
	</label> <select id="<?php echo $this->get_field_id('category'); ?>"
		class="widefat"
		name="<?php echo $this->get_field_name('category'); ?>">
		<?php echo implode('', $cat_options); ?>
	</select>
</p>

		<?php }
	}
}