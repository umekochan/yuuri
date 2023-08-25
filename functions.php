<?php 

function setup_my_theme() {
    add_theme_support( 'title-tag' );
 }
 add_action( 'after_setup_theme', 'setup_my_theme');

?>