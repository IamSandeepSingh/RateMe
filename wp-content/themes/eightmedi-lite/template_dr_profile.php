<?php 
/* Template Name: Custom dr. proflies

 */
get_header();
?>
<?php
$args1 = array(
 'role' => 'doctor',
 'orderby' => 'user_nicename',
 'order' => 'ASC'
);
 $doctors = get_users($args1);
echo '<ul>';
 foreach ($doctors as $user) {
print_r($user);
 echo '<li>' . $user->display_name.'['.$user->user_email . ']</li>';
 }
echo '</ul>';
?>
<?php get_footer();

?>



