<?php

function mos_greviews_admin_enqueue_scripts() {
    $page = @$_GET['page'];
    global $pagenow, $typenow;
    /*var_dump( $pagenow );
    //options-general.php( If under settings )/edit.php( If under post type )
    var_dump( $typenow );
    //post type( If under post type )
    var_dump( $page );
    //mos_greviews_settings( If under settings )*/

    if ( $pagenow == 'options-general.php' AND $page == 'mos_greviews_settings' ) {
        wp_enqueue_style( 'mos-greviews-admin', plugins_url( 'css/mos-greviews-admin.css', __FILE__ ) );

        //wp_enqueue_media();

        wp_enqueue_script( 'jquery' );

        /*Editor*/
        //wp_enqueue_style( 'docs', plugins_url( 'plugins/CodeMirror/doc/docs.css', __FILE__ ) );
        wp_enqueue_style( 'codemirror', plugins_url( 'plugins/CodeMirror/lib/codemirror.css', __FILE__ ) );
        wp_enqueue_style( 'show-hint', plugins_url( 'plugins/CodeMirror/addon/hint/show-hint.css', __FILE__ ) );

        wp_enqueue_script( 'codemirror', plugins_url( 'plugins/CodeMirror/lib/codemirror.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'css', plugins_url( 'plugins/CodeMirror/mode/css/css.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'javascript', plugins_url( 'plugins/CodeMirror/mode/javascript/javascript.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'show-hint', plugins_url( 'plugins/CodeMirror/addon/hint/show-hint.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'css-hint', plugins_url( 'plugins/CodeMirror/addon/hint/css-hint.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'javascript-hint', plugins_url( 'plugins/CodeMirror/addon/hint/javascript-hint.js', __FILE__ ), array( 'jquery' ) );
        /*Editor*/   	

        wp_enqueue_script( 'mos-greviews-functions', plugins_url( 'js/mos-greviews-functions.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'mos-greviews-admin', plugins_url( 'js/mos-greviews-admin.js', __FILE__ ), array( 'jquery' ) );
    }

}
add_action( 'admin_enqueue_scripts', 'mos_greviews_admin_enqueue_scripts' );

function mos_greviews_enqueue_scripts() {
    $mos_greviews_option = get_option( 'mos_greviews_options' );
    if ( @$mos_greviews_option['jquery'] ) {
        wp_enqueue_script( 'jquery' );
    }
    if ( @$mos_greviews_option['owlcarousel'] ) {
        /*Owl Carousel*/ 
        wp_enqueue_style( 'owl.carousel.min', plugins_url('plugins/owlcarousel/owl.carousel.min.css', __FILE__ ) );
        wp_enqueue_style( 'owl.theme.default.min', plugins_url('plugins/owlcarousel/owl.theme.default.min.css', __FILE__ ) );

        wp_enqueue_script('owl.carousel.min', plugins_url('plugins/owlcarousel/owl.carousel.min.js', __FILE__ ), array( 'jquery' ) ); 
        /*Owl Carousel*/ 
    }       
    
    wp_enqueue_style( 'mos-greviews', plugins_url( 'css/mos-greviews.css', __FILE__ ) );
    wp_enqueue_script( 'mos-greviews-functions', plugins_url( 'js/mos-greviews-functions.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mos-greviews', plugins_url( 'js/mos-greviews.js', __FILE__ ), array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'mos_greviews_enqueue_scripts' );

function mos_greviews_ajax_scripts() {
    wp_enqueue_script( 'mos-greviews-ajax', plugins_url( 'js/mos-greviews-ajax.js', __FILE__ ), array( 'jquery' ) );
    $ajax_params = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce' => wp_create_nonce( 'mos_greviews_verify' ),
    );
    wp_localize_script( 'mos-greviews-ajax', 'ajax_obj', $ajax_params );
}
add_action( 'wp_enqueue_scripts', 'mos_greviews_ajax_scripts' );
add_action( 'admin_enqueue_scripts', 'mos_greviews_ajax_scripts' );

function mos_greviews_scripts() {
    global $mos_greviews_option;
    if ( @$mos_greviews_option['css'] ) {
        ?>
        <style>
        <?php echo $mos_greviews_option['css'] ?>
        </style>
        <?php
    }
    if ( @$mos_greviews_option['js'] ) {
        ?>
        <style>
        <?php echo $mos_greviews_option['js'] ?>
        </style>
        <?php
    }
}
add_action( 'wp_footer', 'mos_greviews_scripts', 100 );

function mos_greviews_func( $atts = array(), $content = '' ) {
    $atts = shortcode_atts( array(
        'google_maps_review_cid' => '1174870231475777674', // Customer Identification ( CID )
        'show_only_if_with_text' => false, // true = show only reviews that have text
        'show_only_if_greater_x' => 0,     // ( 0-4 ) only show reviews with more than x stars
        'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review (and before first)
        'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
        'your_language_for_tran' => 'en',  // give you language for auto translate reviews
        'sort_by_reating_best_1' => true,  // true = sort by rating ( best first )
        'show_cname_as_headline' => true,  // true = show customer name as headline
        'show_age_of_the_review' => true,  // true = show the age of each review
        'show_txt_of_the_review' => true,  // true = show the text of each review
        'show_author_of_reviews' => true,  // true = show the author of each review
        'show_image_of_reviews'  => true,  // true = show the image of each review
        'view'                   => 'carousel', // carousel = show carousel mode
        'view_link'              => ''
    ), $atts, 'mos-greviews' );
    $cls = ($atts['view'] == 'carousel')?'owl-carousel owl-theme':'';
    $ch = curl_init( 'https://www.google.com/maps?cid='.$atts['google_maps_review_cid'] );
    /* GOOGLE REVIEWS BY cURL */
    if ( isset( $atts['your_language_for_tran'] ) and !empty( $atts['your_language_for_tran'] ) ) {
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Accept-Language: '.$atts['your_language_for_tran'] ) );
    }
    curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36' );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $result = curl_exec( $ch );
    curl_close( $ch );
    /* </cURL END> */
    $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
    /* REVIEW REGEX PATTERN */
    if ( preg_match( $pattern, $result, $match ) ) {
        /* CHECK IF REVIEWS FOUND */
        $match[1] = trim( $match[1], ' =;' );
        /* DIRTY JSON FIX */
        $reviews  = json_decode( $match[1] );
        /* 2. JSON DECODE */
        $reviews  = ltrim( $reviews[3][6], ")]}'" );
        /* DIRTY JSON FIX */
        $reviews  = json_decode( $reviews );
        /* 2. JSON DECODE */
        $customer = $reviews[6][11];
        /* POSITION OF REVIEWS */
        $reviews  = $reviews[6][52][0];
        /* POSITION OF REVIEWS */
    }
    /* END CHECK */
    $return = '';
    /* INI VAR */
    if ( isset( $reviews ) ) {
        /* CHECK REVIEWS */
        if ( isset( $atts['sort_by_reating_best_1'] ) and @$atts['your_lansort_by_reating_best_1guage_for_tran'] == true )                                /* CHECK SORT */
        array_multisort( array_map( function( $element ) {
            return $element[4];
        }
        , $reviews ), SORT_DESC, $reviews );
        /* SORT */
        $return .= '<div class="quote">';
        /* OPEN DIV */
        if ( isset( $atts['show_cname_as_headline'] ) and $atts['show_cname_as_headline'] == true ) $return .= '<div class="greviews-company-name">'.$customer.'</div>';
        /* CUSTOMER */
        if ( isset( $atts['show_rule_after_review'] ) and $atts['show_rule_after_review'] == true ) $return .= '<div class="mos-greviews '.$cls.'">';
        /* RULER */
        foreach ( $reviews as $review ) {
            // var_dump($review); die();
            
            /* START LOOP */
            $return .= '<div class="review-unit">';
            $return .= '<div class="card">';
            if ( isset( $atts['show_only_if_with_text'] ) and $atts['show_only_if_with_text'] == true and empty( $review[3] ) ) continue;
            /* CHECK TEXT */
            if ( isset( $atts['show_only_if_greater_x'] ) and $review[4] <= $atts['show_only_if_greater_x'] ) continue;
            /* CHECK RATING */
            $return .= '<div class="stars-area">';
            for ( $i = 1; $i <= $review[4]; ++$i ) $return .= '⭐';
            /* RATING */
            
            if ( isset( $atts['show_blank_star_till_5'] ) and $atts['show_blank_star_till_5'] == true ) for ( $i = 1; $i <= 5-$review[4]; ++$i ) $return .= '☆';
            /* RATING */
            $return .= '</div>';
            /* NEWLINE */
            if ( isset( $atts['show_txt_of_the_review'] ) and $atts['show_txt_of_the_review'] == true ) {
                //wp_trim_words( string $text, int $num_words = 55, string $more = null )
                // $words = str_word_count($review[3]);
                $trimmed = wp_trim_words( $review[3], $num_words = 10, ' <a class="show-full" href="#">Read More</a>' );
                // $return .= '<div class="content-area"><div class="trimmed">'.$trimmed. '</div><div class="full-content" style="display:none">' .$review[3].'</div></div>';
                $return .= '<div class="content-area"><div class="trimmed-content">'.$trimmed.'</div><div class="full-content" style="display:none">'.$review[3].' <a class="show-trimmed" href="#">Hide More</a></div></div>';
            }
            
            $return .= '</div /.card>';
            if ( isset( $atts['view_link'] ) ) $return .= '<a target="_blank" href="'.esc_url($atts['view_link']).'">';
            $return .= '<div class="review-unit-bottom">';
            /*IMAGE*/            
            if ( isset( $atts['show_image_of_reviews'] ) and $atts['show_image_of_reviews'] == true ) $return .= '<img class="review-img" src="'.$review[0][2].'" width="50" height="50" />';
            $return .= '<div class="review-unit-bottom-text">';
            /* TEXT */
            if ( isset( $atts['show_age_of_the_review'] ) and $atts['show_age_of_the_review'] == true ) $return .= '<div class="review-author">'.$review[0][1].' </div>';
            /* AUTHOR */
            //if ( isset( $atts['show_age_of_the_review'] ) and $atts['show_age_of_the_review'] == true and                             /* IF AUTHOR & AGE */
            //isset( $atts['show_age_of_the_review'] ) and $atts['show_age_of_the_review'] == true ) $return .= '<small> &mdash; </small>';
            /* PRINT — */
            if ( isset( $atts['show_age_of_the_review'] ) and $atts['show_age_of_the_review'] == true ) $return .= '<div class="review-time">'.$review[1].' </div>';
            $return .= '</div /.review-unit-bottom-text>';          
            $return .= '</div /.review-unit-bottom>';  
            if ( isset( $atts['view_link'] ) ) $return .= '</a>';
            /* AGE */
            // if ( isset( $atts['show_rule_after_review'] ) and $atts['show_rule_after_review'] == true ) // $return .= '<hr size="1">';
            $return .= '</div /.review-unit>';
            /* RULER */
        }
        /* END LOOP */
        $return .= '</div /.owl-carousel.owl-theme></div>';
        /* CLOSE DIV */
    }
    /* CHECK REVIEWS */
    return $return;
    /* RETURN DATA */

}
add_shortcode( 'mos-greviews', 'mos_greviews_func' );

$options = array(
    'google_maps_review_cid' => '1174870231475777674', // Customer Identification ( CID )
    'show_only_if_with_text' => false, // true = show only reviews that have text
    'show_only_if_greater_x' => 0,     // ( 0-4 ) only show reviews with more than x stars
    'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review (and before first)
    'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
    'your_language_for_tran' => 'en',  // give you language for auto translate reviews
    'sort_by_reating_best_1' => true,  // true = sort by rating ( best first )
    'show_cname_as_headline' => true,  // true = show customer name as headline
    'show_age_of_the_review' => true,  // true = show the age of each review
    'show_txt_of_the_review' => true,  // true = show the text of each review
    'show_author_of_reviews' => true,  // true = show the author of each review
);

/* -------------------- */
// echo getReviews( $options );
/* -------------------- */

function getReviews( $option ) {
    $ch = curl_init( 'https://www.google.com/maps?cid='.$option['google_maps_review_cid'] );
    /* GOOGLE REVIEWS BY cURL */
    if ( isset( $option['your_language_for_tran'] ) and !empty( $option['your_language_for_tran'] ) ) {
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Accept-Language: '.$option['your_language_for_tran'] ) );
    }
    curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36' );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $result = curl_exec( $ch );
    curl_close( $ch );
    /* </cURL END> */
    $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
    /* REVIEW REGEX PATTERN */
    if ( preg_match( $pattern, $result, $match ) ) {
        /* CHECK IF REVIEWS FOUND */
        $match[1] = trim( $match[1], ' =;' );
        /* DIRTY JSON FIX */
        $reviews  = json_decode( $match[1] );
        /* 2. JSON DECODE */
        $reviews  = ltrim( $reviews[3][6], ")]}'" );
        /* DIRTY JSON FIX */
        $reviews  = json_decode( $reviews );
        /* 2. JSON DECODE */
        $customer = $reviews[6][11];
        /* POSITION OF REVIEWS */
        $reviews  = $reviews[6][52][0];
        /* POSITION OF REVIEWS */
    }
    /* END CHECK */
    $return = '';
    /* INI VAR */
    if ( isset( $reviews ) ) {
        /* CHECK REVIEWS */
        if ( isset( $option['sort_by_reating_best_1'] ) and @$option['your_lansort_by_reating_best_1guage_for_tran'] == true )                                /* CHECK SORT */
        array_multisort( array_map( function( $element ) {
            return $element[4];
        }
        , $reviews ), SORT_DESC, $reviews );
        /* SORT */
        $return .= '<div class="quote">';
        /* OPEN DIV */
        if ( isset( $option['show_cname_as_headline'] ) and $option['show_cname_as_headline'] == true ) $return .= '<strong>'.$customer.'</strong><br>';
        /* CUSTOMER */
        if ( isset( $option['show_rule_after_review'] ) and $option['show_rule_after_review'] == true ) $return .= '<hr size="1">';
        /* RULER */
        foreach ( $reviews as $review ) {
            /* START LOOP */
            if ( isset( $option['show_only_if_with_text'] ) and $option['show_only_if_with_text'] == true and empty( $review[3] ) ) continue;
            /* CHECK TEXT */
            if ( isset( $option['show_only_if_greater_x'] ) and $review[4] <= $option['show_only_if_greater_x'] ) continue;
            /* CHECK RATING */
            for ( $i = 1; $i <= $review[4]; ++$i ) $return .= '⭐';
            /* RATING */
            if ( isset( $option['show_blank_star_till_5'] ) and $option['show_blank_star_till_5'] == true ) for ( $i = 1; $i <= 5-$review[4]; ++$i ) $return .= '☆';
            /* RATING */
            $return .= '<br>';
            /* NEWLINE */
            if ( isset( $option['show_txt_of_the_review'] ) and $option['show_txt_of_the_review'] == true ) $return .= $review[3].'<br>';
            /* TEXT */
            if ( isset( $option['show_age_of_the_review'] ) and $option['show_age_of_the_review'] == true ) $return .= '<div class="review-author">'.$review[0][1].' </div>';
            /* AUTHOR */
            //if ( isset( $option['show_age_of_the_review'] ) and $option['show_age_of_the_review'] == true and
            /* IF AUTHOR & AGE */
            //isset( $option['show_age_of_the_review'] ) and $option['show_age_of_the_review'] == true ) $return .= '<small> &mdash; </small>';
            /* PRINT — */
            if ( isset( $option['show_age_of_the_review'] ) and $option['show_age_of_the_review'] == true ) $return .= '<div class="review-date">'.$review[1].' </div>';
            /* AGE */
            if ( isset( $option['show_rule_after_review'] ) and $option['show_rule_after_review'] == true ) $return .= '<hr size="1">';
            /* RULER */
        }
        /* END LOOP */
        $return .= '</div>';
        /* CLOSE DIV */
    }
    /* CHECK REVIEWS */
    return $return;
    /* RETURN DATA */
}
