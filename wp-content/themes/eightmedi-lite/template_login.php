<?php 
/* Template Name: Custom Login template

 */
get_header();  ?>
<div class="ed-container">
    <?php 
    global $post;
    $sidebar = get_post_meta($post->ID, 'eightmedi_lite_sidebar_layout', true);
    if($sidebar=='both-sidebar' || $sidebar=='left-sidebar'){
        get_sidebar('left');
    }
    ?>
 <header class="page-header">
            <h1 class="page-title">Login</h1>
        </header>
    <div id="primary" class="content-area <?php echo $sidebar;?>">
        <main id="main" class="site-main" role="main">
       

<br>
<br>
<br>
<?php // login form
   $args = array(
    'echo' => true,
    'redirect' => site_url(), 
    'form_id' => 'loginform',
    'label_username' => __( 'Username' ),
    'label_password' => __( 'Password' ),
    'label_remember' => __( 'Remember Me' ),
    'label_log_in' => __( 'Log In' ),
    'id_username' => 'user_login',
    'id_password' => 'user_pass',
    'id_remember' => 'rememberme',
    'id_submit' => 'wp-submit',
    'remember' => true,
    'value_username' => NULL,
    'value_remember' => false );

wp_login_form( $args );
?>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</main><!-- #main -->
    </div><!-- #primary -->
    <?php 
    if($sidebar=='both-sidebar' || $sidebar=='right-sidebar' ){
        get_sidebar('right');
    }
    ?>
</div>
<?php get_footer(); ?>
