<?php

require_once('/var/www/servicecenter.guru/wp-blog-header.php');
header('HTTP/1.1 200 OK');


if(isset($_POST["company"]) && !isset($_POST["country"]) && !isset($_POST["state"])){
    $company = $_POST["company"];

    $args = array(
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'company',
                'field'    => 'term_id',
                'terms'    => $company,
                )
            ),
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order'   => 'ASC',
        );
    $post_query = new WP_Query( $args );
    $countries = array();
    if ( $post_query->have_posts() ) {
        while($post_query->have_posts() ) {
            $post_query->the_post();
            $state_id = wp_get_post_terms($post_query->post->ID, 'category')[0]->parent;
            $country_id = get_term($state_id, 'category')->parent;
            if(!in_array($country_id,$countries))
                $countries[] = $country_id;

        }
    }
    foreach($countries as $country_id) {
        $country = get_term($country_id, 'category');
        //echo "<option value='{$country->term_id}'>{$country->name}</option>";
         echo "<div class='item' data-value='{$country->term_id}'>";
        print_term_image($country->term_id);
        echo "{$country->name}</div>";

    }



}

else if(isset($_POST["company"]) &&isset($_POST["country"]) && !isset($_POST["state"])){
    $country = $_POST["country"];
    $company = $_POST["company"];


    $args = array(
        'post_type' => 'post',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'company',
                'field'    => 'term_id',
                'terms'    => array($company),
                ),
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => array($country),
                )
            ),
        'posts_per_page' => -1

        );
    $post_query = new WP_Query( $args );
    $states = array();
    if ( $post_query->have_posts() ) {
    while($post_query->have_posts() ) {
        $post_query->the_post();
        $state_id = wp_get_post_terms($post_query->post->ID, 'category')[0]->parent;
        if(!in_array($state_id,$states))
            $states[] = $state_id;

    }
}

    foreach($states as $state_id) {
        $state = get_term($state_id, 'category');
        //echo "<option value='{$state->term_id}'>{$state->name}</option>";
        echo "<div class='item' data-value='{$state->term_id}'>";
        print_term_image($state->term_id);
        echo "{$state->name}</div>";

    }



}

else if(isset($_POST["country"]) && isset($_POST["company"]) && isset($_POST["state"])){
    $country = $_POST["country"];
    $company = $_POST["company"];
    $state = $_POST["state"];





    $args = array(
        'post_type' => 'post',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'company',
                'field'    => 'term_id',
                'terms'    => array($company),
                ),
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => array($state),
                )
            ),
        'posts_per_page' => -1

        );
    $post_query = new WP_Query( $args );
    $cities = array();

    while($post_query->have_posts() ) {
        $post_query->the_post();
        $city = wp_get_post_terms($post_query->post->ID, 'category')[0];

        //echo "<option value='";
        //the_permalink();
        //echo "'>{$city->name}</option>";
        echo "<div class='item' data-value='";
        the_permalink();
        echo "'>";
        print_term_image($city->term_id);
        echo "{$city->name}</div>";

    }

}


?>
