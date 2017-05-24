<?php
/**
 * Template Name: Front Page Template
 *
 * @package Tyche
 */

/**
 * Grab the header
 */
get_header();
/**
 * Load the frontpage class and output the
 * widget sections as per customizer order
 */
new Tyche_Frontpage();

/**
 * Grab the footer
 */
get_footer();
