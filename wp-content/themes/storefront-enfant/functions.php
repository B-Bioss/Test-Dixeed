<?php

// --------------------------------------------
// Chargement de la feuille du style ----------
// --------------------------------------------

function storefront_child_register_assets()
{

    // Déclare style.css à la racine du thème enfant
    wp_enqueue_style(
        'storefrontenfant',
        get_stylesheet_uri()
    );

    // Chargement de la feuille du style du theme parent
    wp_enqueue_style(
        'storefront-theme',
        get_template_directory_uri() . '/style.css'
    );

    // Chargement de la feuille de style complémentaire du thème enfant
    wp_enqueue_style(
        'storefrontenfant-custom',
        get_stylesheet_directory_uri() . '/assets/css/style.css'
    );
}
add_action('wp_enqueue_scripts', 'storefront_child_register_assets');


// -------------------------------------------------------------------------------------------------------------------
// Ajouter un champ supplémentaire sur la page Checkout avec sauvegarde de celui dans la base de données (sans plugin) 
// -------------------------------------------------------------------------------------------------------------------

// Crée un champ supplémentaire sur la page Checkout
add_filter('woocommerce_checkout_fields','custom_override_checkout_fields');
function custom_override_checkout_fields($fields) {
    $fields['billing']['votre_surnom_mignon'] = array(
        'label' => __('Votre surnom mignon', 'woocommerce'),
        'placeholder' => _x('', 'placeholder', 'woocommerce'),
        'required' => true,
        'class' => array('form-row-wide'), 
        'clear' => true
    );
    
    return $fields;
}

// Sauvegarde du champs supplémentaire dans la base de données
add_action( 'woocommerce_checkout_update_order_meta', 'custom_checkout_fields_update_order_meta' );
function custom_checkout_fields_update_order_meta( $order_id ) {
    update_post_meta( $order_id, 'votre_surnom_mignon', sanitize_text_field( $_POST['votre_surnom_mignon'] ) );
}