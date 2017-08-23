<?php
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}
if (!class_exists('TG_FEATURED_USERS')) {

    class TG_FEATURED_USERS extends WP_Widget {
        
		/*
         * @init Related Blogs
         * 
         */
        public function __construct() {
            $widget_ops_rel = array('classname' => 'tg-featured-doctore', 'description' => 'Display Featured Users');
            $control_ops_rel = array('width' => 300, 'height' => 250, 'id_base' => 'tg_featured_doctor');
            parent::__construct('tg_featured_doctor', esc_html__('Featured Users ', 'docdirect'), $widget_ops_rel, $control_ops_rel);
        }

        /**
         *  Related Blogs Form
         *
         */
        public function form($instance) {
            $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Featured Users', 'docdirect');
            $number = isset($instance['number']) && !empty($instance['number']) ? $instance['number'] : '';
			$order = isset($instance['order']) && !empty($instance['order']) ? $instance['order'] : '';
			$users_type = isset($instance['users_type']) && !empty($instance['users_type']) ? $instance['users_type'] : '';
			
			$args = array('posts_per_page' => '-1', 
				'post_type' => 'directory_type', 
				'post_status' => 'publish',
				'suppress_filters' => false
			);
			$cust_query = get_posts($args);
			
            ?>
            <p>
                <label for="title"><?php esc_html_e('Title:', 'docdirect'); ?></label>
                <input type="text" id="title" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" />
            </p>
            <p>
                <label for="users_type"><?php esc_html_e('User Type', 'docdirect'); ?></label>
                <select name="<?php echo esc_attr($this->get_field_name('users_type')); ?>" class="widefat">
                	<option value=""><?php esc_html_e('Select Type', 'docdirect'); ?></option>
                    <?php 
					if( isset( $cust_query ) && !empty( $cust_query ) ) {
						foreach ($cust_query as $key => $dir) {
							$counter++;
							$title = get_the_title($dir->ID);
							$selected	= '';
							if( isset( $users_type ) && $users_type == $dir->ID ){
								$selected	= 'selected';
							}
					?>
                    <option <?php echo esc_attr( $selected );?> value="<?php echo intval( $dir->ID ); ?>"><?php echo esc_attr( $title ); ?></option>
                    <?php }}?>
                </select>
            </p>
            <p>
                <label for="number"><?php esc_html_e('Number of users to show:', 'docdirect'); ?></label>
                <input type="number" id="number" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($number); ?>" class="widefat" />
            </p>
            
            
            <p>
                <label for="order"><?php esc_html_e('Order', 'docdirect'); ?></label>
                <select name="<?php echo esc_attr($this->get_field_name('order')); ?>" class="widefat">
                	<option value="ASC" <?php echo isset( $order ) && $order == 'ASC' ? 'selected' :''; ?>><?php esc_html_e('ASC', 'docdirect'); ?></option>
                    <option value="DESC" <?php echo isset( $order ) && $order == 'DESC' ? 'selected' :''; ?>><?php esc_html_e('DESC', 'docdirect'); ?></option>
                </select>
            </p>
            <?php
        }

        /**
         * @Update Related Blogs 
         *
         */
        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = $new_instance['number'];
			$instance['order'] = $new_instance['order'];
			$instance['users_type'] = $new_instance['users_type'];
            return $instance;
        }

        /**
         * @Display Related Blogs
         *
         *
         */
        public function widget($args, $instance) {

            extract($args);
            $meta_query_args = array();
			$title = $instance['title'];
            $number_of_posts = $instance['number'];
			$order = $instance['order'];
			$users_type = $instance['users_type'];
			
            echo ($args['before_widget']);
			echo ($args['before_title'] . apply_filters('widget_title', esc_attr($title)) . $args['after_title']);
			
			$query_args	= array(
								'role'  => 'professional',
								'order' => $order,
							 );
			
			$query_args['number']	= $number_of_posts;
			
			if( isset( $users_type ) && !empty( $users_type ) ) {
				$meta_query_args[] = array(
											'key'     => 'directory_type',
											'value'   => $users_type,
											'compare' => '='
										);
			}
			
			//Verify user
			$meta_query_args[] = array(
										'key'     => 'verify_user',
										'value'   => 'on',
										'compare' => '='
									);
			
			
			//Featured users
			$today = time();
			$meta_query_args[] = array(
						'key'     => 'user_featured',
						'value'   => $today,
						'type' => 'numeric',
						'compare' => '>'
					);
					
			if( !empty( $meta_query_args ) ) {
				$query_relation = array('relation' => 'AND',);
				$meta_query_args	= array_merge( $query_relation,$meta_query_args );
				$query_args['meta_query'] = $meta_query_args;
			}
													
			$query_args['meta_key']	  = 'user_featured';
			$query_args['orderby']	   = 'meta_value';	
			$user_query  = new WP_User_Query($query_args);

			?>
			<ul>
				<?php
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

					 $directory_type = get_user_meta( $user->ID, 'directory_type', true);
					 $reviews_switch    = fw_get_db_post_option($directory_type, 'reviews', true);
					 $avatar = apply_filters(
								'docdirect_get_user_avatar_filter',
								 docdirect_get_user_avatar(array('width'=>150,'height'=>150), $user->ID),
								 array('width'=>150,'height'=>150) //size width,height
							);
							
					$username	= $user->first_name.' '.$user->last_name;
					if( empty( $username ) ){
						$username	= $user->user_login;
					}
					
					$data	= docdirect_get_everage_rating ( $user->ID );
					?>
					<li>
                        <figure class="tg-imgdoc">
                            <img src="<?php echo esc_url( $avatar );?>" alt="<?php esc_html_e('User','docdirect');?>">
                            <div class="tg-img-hover">
                                <a href="<?php echo get_author_posts_url($user->ID); ?>"><i class="icon-zoom"></i></a>
                            </div>
                        </figure>
                        <div class="tg-docinfo">
                            <span class="tg-docname"><a href="<?php echo get_author_posts_url($user->ID); ?>"><?php echo esc_attr( $username );?></a></span>
                            <?php if( isset( $reviews_switch ) && $reviews_switch === 'enable' ){?>
                            <span class="tg-stars">
                                <em><?php esc_html_e('Ranking:','docdirect');?></em>
                                <span class="tg-stars star-rating">
                                    <span style="width:<?php echo esc_attr( $data['percentage'] );?>%"></span>
                                </span>
                            </span>
                            <?php }?>
                            <?php if( !empty( $user->tagline ) ){?>
                            <div class="tg-designation">
                                <p><a href="javascript:;"><?php echo esc_attr( $user->tagline );?></a></p>
                            </div>
                        </div>
                    </li>
				<?php }
				}
			} else{?>
				<li><?php  DoctorDirectory_NotificationsHelper::informations(esc_html__('No users Found.','docdirect'));?></li>
			<?php }?>
			</ul>
            <?php echo ($args['after_widget']); ?>
            <?php
        }

    }

}

add_action('widgets_init', create_function('', 'return register_widget("TG_FEATURED_USERS");'));
