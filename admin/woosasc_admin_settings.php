<?php

if (!defined('ABSPATH'))
    exit;

if (!class_exists('WOOSASC_settings')) {

    class WOOSASC_settings {

        protected static $WOOSASC_instance;
        
        function WOOSASC_create_posttype() {

            $labels = array(
                'name'                  => _x( 'Saved Carts', 'Post type general name', 'wc-save-and-share-cart' ),
                'singular_name'         => _x( 'Saved Cart', 'Post type singular name', 'wc-save-and-share-cart' ),
                'menu_name'             => _x( 'Saved Carts', 'Admin Menu text', 'wc-save-and-share-cart' ),
                'name_admin_bar'        => _x( 'Saved Carts', 'Add New on Toolbar', 'wc-save-and-share-cart' ),
                'add_new'               => __( 'Add New', 'wc-save-and-share-cart' ),
                'add_new_item'          => __( 'Add New Saved Cart', 'wc-save-and-share-cart' ),
                'new_item'              => __( 'New Saved Cart', 'wc-save-and-share-cart' ),
                'edit_item'             => __( 'Edit Saved Cart', 'wc-save-and-share-cart' ),
                'view_item'             => __( 'View Saved Cart', 'wc-save-and-share-cart' ),
                'all_items'             => __( 'All Saved Carts', 'wc-save-and-share-cart' ),
                'search_items'          => __( 'Search Saved Carts', 'wc-save-and-share-cart' ),
                'parent_item_colon'     => __( 'Parent Saved Carts:', 'wc-save-and-share-cart' ),
                'not_found'             => __( 'No carts found.', 'wc-save-and-share-cart' ),
                'not_found_in_trash'    => __( 'No carts found in Trash.', 'wc-save-and-share-cart' ),
                'archives'              => _x( 'Saved Carts archives', 'wc-save-and-share-cart' )
            );

            $args = array(
                        'labels'             => $labels,
                        'public'             => true,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'woosasc_cart' ),
                        'capability_type'    => 'post',
                        'has_archive'        => false,
                        'hierarchical'       => false,
                        'capabilities'       => array('create_posts' => false),
                        'map_meta_cap'       => true,
                        'menu_position'      => null,
                        'supports'           => array( 'title', 'author', 'custom-fields' ),
                    );

            register_post_type( 'woosasc_cart', $args );
            flush_rewrite_rules();
        }
        

        function WOOSASC_options_page() {
            add_submenu_page( 'edit.php?post_type=woosasc_cart', 'Settings', 'Settings', 'manage_options', 'woosasc-save-share-cart',array($this, 'WOOSASC_options_page_callback'));
        }

        function WOOSASC_options_page_callback() {
            global $woosasc_svg_icon;
        ?>    
            <div class="wrap">
                
                <div class="wrap woocommerce">
                    <form method="post">
                          <?php 
                          wp_nonce_field( 'woosasc_nonce_action', 'woosasc_nonce_field' );
                          $woosasc_btnpos = get_option( 'woosasc_btnpos', 'before_cart_table' );
                          ?>
                        <h3><?php echo __('Cart Share Settings','wc-save-and-share-cart');?></h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_btnpos_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_btnpos"><?php echo __('Share button position','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-select">
                                        <select name="woosasc_btnpos" id="woosasc_btnpos" class="regular-text" tabindex="-1" aria-hidden="true">
                                            <option value="sel_btn_post" <?php if($woosasc_btnpos == 'sel_btn_post') { echo 'selected'; } ?>><?php echo __('Select Button Position','wc-save-and-share-cart');?></option>
                                            <option value="before_cart_table" <?php if($woosasc_btnpos == 'before_cart_table') { echo 'selected'; } ?>><?php echo __('Before Cart Table','wc-save-and-share-cart');?></option>
                                            <option value="after_cart_table" <?php if($woosasc_btnpos == 'after_cart_table') { echo 'selected'; } ?>><?php echo __('After Cart Table','wc-save-and-share-cart');?></option>
                                            <option value="before_cart" disabled><?php echo __('Before Cart','wc-save-and-share-cart');?></option>
                                            <option value="after_cart" disabled><?php echo __('After Cart','wc-save-and-share-cart');?></option>
                                            <option value="beside_update_cart" disabled><?php echo __('Beside Update Cart Button','wc-save-and-share-cart');?></option>
                                        </select>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_scbtext_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scbtext"><?php echo __('Share cart button text','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_scbtext" id="woosasc_scbtext" type="text" class="regular-text" placeholder="Get Quote" value="<?php if(!empty(get_option( 'woosasc_scbtext' ))){ echo get_option( 'woosasc_scbtext' ); } else { echo 'Share cart'; } ?>">
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_scptitle_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scptitle"><?php echo __('Share cart page title','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_scptitle" id="woosasc_scptitle" type="text" class="regular-text" placeholder="Get Quote" value="<?php if(!empty(get_option( 'woosasc_scptitle' ))){ echo get_option( 'woosasc_scptitle' ); } else { echo 'Cart'; } ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3><?php echo __('Enable social media for sharing','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_sofb_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['facebook_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Facebook','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_sofb">
                                                    <input name="woosasc_sofb" id="woosasc_sofb" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sofb' )) && get_option( 'woosasc_sofb' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Facebook','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#4267B2" name="woosasc_facebook_color" value="#4267B2" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sott_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['twitter_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Twitter','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_sott">
                                                    <input name="woosasc_sott" id="woosasc_sott" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sott' )) && get_option( 'woosasc_sott' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Twitter','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#1DA1F2" name="woosasc_twitter_color" value="#1DA1F2" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sowa_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['whatsapp_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Whatsapp','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_sowa">
                                                    <input name="woosasc_sowa" id="woosasc_sowa" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sowa' )) && get_option( 'woosasc_sowa' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Whatsapp','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#25D366" name="woosasc_whatsapp_color" value="#25D366" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sowa_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['linkedin_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Linkedin','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_solinkedin">
                                                    <input name="woosasc_solinkedin" id="woosasc_solinkedin" type="checkbox" class="" value="1" disabled><?php echo __(' Enable Linkedin','wc-save-and-share-cart');?>
                                                    <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#0e76a8" name="woosasc_linkedin_color" value="#0e76a8" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sowa_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['instagram_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Instagram','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_soinsta">
                                                    <input name="woosasc_soinsta" id="woosasc_soinsta" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_soinsta' )) && get_option( 'woosasc_soinsta' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Instagram','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#F56040" name="woosasc_instagram_color" value="#F56040" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_soskp_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['skype_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Skype','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_soskp">
                                                    <input name="woosasc_soskp" id="woosasc_soskp" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_soskp' )) && get_option( 'woosasc_soskp' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Skype','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#00aff0" name="woosasc_skype_color" value="#00aff0" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_email_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['email_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Email','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_email">
                                                    <input name="woosasc_email" id="woosasc_email" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_email' )) && get_option( 'woosasc_email' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Email','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#cc473a" name="woosasc_email_color" value="#cc473a" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_ctc_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['copy_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Copy to clipboard','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_ctc">
                                                    <input name="woosasc_ctc" id="woosasc_ctc" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_ctc' )) && get_option( 'woosasc_ctc' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Copy to clipboard','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#333333" name="woosasc_copy_color" value="#333333" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_save_field">
                                    <th scope="row" class="titledesc"><?php echo $woosasc_svg_icon['save_svg'];?></th>
                                    <td class="forminp forminp-checkbox check_color_com">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Save','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_save">
                                                    <input name="woosasc_save" id="woosasc_save" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_save' )) && get_option( 'woosasc_save' ) == 1){ echo 'checked'; } ?>><?php echo __(' Enable Save','wc-save-and-share-cart');?>
                                                </label>
                                        </fieldset>
                                        <input type="text" class="color-picker" data-alpha="true" data-default-color="#333333" name="woosasc_save_color" value="#333333" disabled/>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_share_color_field">
                                    <th scope="row" class="titledesc"><?php echo __('Popup Header color','wc-save-and-share-cart');?></th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Popup Header color','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_popup_header_color">
                                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="#000000" name="woosasc_popup_header_color" value="#000000" disabled/>
                                                </label>
                                                <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_share_hover_color_field">
                                    <th scope="row" class="titledesc"><?php echo __('Popup Close icon Color','wc-save-and-share-cart');?></th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span><?php echo __('Popup Close icon Color','wc-save-and-share-cart');?></span></legend>
                                                <label for="woosasc_popup_close_color">
                                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="#898989" name="woosasc_popup_close_color" value="#898989" disabled/>
                                                </label>
                                                <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3><?php echo __('Email Cart Settings','wc-save-and-share-cart');?></h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_emailfaddress_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailfaddress"><?php echo __('Email from address','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-email">
                                        <input name="woosasc_emailfaddress" id="woosasc_emailfaddress" type="text" class="regular-text" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailfaddress' ))){ echo get_option( 'woosasc_emailfaddress' ); } ?>">
                                        <p class="description"><?php echo __('Enter address from which email will be sent','wc-save-and-share-cart');?></p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailfname_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailfname"><?php echo __('Email from name','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_emailfname" id="woosasc_emailfname" type="text" class="regular-text" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailfname' ))){ echo get_option( 'woosasc_emailfname' ); } ?>">
                                        <p class="description"><?php echo __('Enter name from which email will be sent','wc-save-and-share-cart');?></p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailsub_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailsub"><?php echo __('Email subject','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_emailsub" id="woosasc_emailsub" type="text" class="regular-text" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailsub' ))){ echo get_option( 'woosasc_emailsub' ); } ?>">
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailbody_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailbody"><?php echo __('Email Body','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <textarea rows="9" cols="60" name="woosasc_emailbody" id="woosasc_emailbody"><?php if(!empty(get_option( 'woosasc_emailbody' ))){ echo get_option( 'woosasc_emailbody' ); } ?></textarea>
                                        <p class="description"><?php echo __('Use placeholder {ct_link} for cart link, {wsc_blogname} for blogname and {wsc_siteurl} for website url.','wc-save-and-share-cart');?></p>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <h3><?php echo __('Save Cart Settings','wc-save-and-share-cart');?></h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_savedctitle_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scbtext"><?php echo __('Saved cart title','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_savedctitle" id="woosasc_savedctitle" type="text" class="regular-text" placeholder="" value="Saved carts" disabled>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                        <p class="description"><?php echo __('This would be visible in my account section.','wc-save-and-share-cart');?></p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_savedclable_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_savedclable"><?php echo __('Enter name for saved cart label','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_savedclable" id="woosasc_savedclable" type="text" class="regular-text" placeholder="" value="<?php if(!empty(get_option( 'woosasc_savedclable' ))){ echo get_option( 'woosasc_savedclable' ); } else { echo 'Enter name for saved cart'; } ?>">
                                        <p class="description"><?php echo __('This would be visible while user would be saving cart on front-end.','wc-save-and-share-cart');?></p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_popupheading_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_popupheading"><?php echo __('Popup heading text','wc-save-and-share-cart');?><span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_popupheading" id="woosasc_popupheading" type="text" class="regular-text" placeholder="" value="Share Cart & Save Cart" disabled>
                                        <label class="woosasc_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/save-and-share-cart-for-woocommerce-pro/" target="_blank">link</a></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="action" value="woosasc_save_option">
                            <input type="submit" value="Save Changes" name="submit" class="button-primary" id="woosasc-btn-space">
                    </form>
                </div>
            </div>
        <?php
        }
            
        function WOOSASC_save_options(){
            if( current_user_can('administrator') ) { 
                if(isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'woosasc_save_option'){
                    if(!isset( $_POST['woosasc_nonce_field'] ) || !wp_verify_nonce( $_POST['woosasc_nonce_field'], 'woosasc_nonce_action' ) ){
                        print 'Sorry, your nonce did not verify.';
                        exit;
                    } else {


                        if(isset($_REQUEST['woosasc_sofb']) && !empty($_REQUEST['woosasc_sofb'])) {
                            $woosasc_sofb = sanitize_text_field( $_REQUEST['woosasc_sofb'] );
                        } else {
                            $woosasc_sofb = '';
                        }

                        if(isset($_REQUEST['woosasc_sott']) && !empty($_REQUEST['woosasc_sott'])) {
                            $woosasc_sott = sanitize_text_field( $_REQUEST['woosasc_sott'] );
                        } else {
                            $woosasc_sott = '';
                        }

                        if(isset($_REQUEST['woosasc_sowa']) && !empty($_REQUEST['woosasc_sowa'])) {
                            $woosasc_sowa = sanitize_text_field( $_REQUEST['woosasc_sowa'] );
                        } else {
                            $woosasc_sowa = '';
                        }

                        if(isset($_REQUEST['woosasc_soinsta']) && !empty($_REQUEST['woosasc_soinsta'])) {
                            $woosasc_soinsta = sanitize_text_field( $_REQUEST['woosasc_soinsta'] );
                        } else {
                            $woosasc_soinsta = '';
                        }


                        if(isset($_REQUEST['woosasc_soskp']) && !empty($_REQUEST['woosasc_soskp'])) {
                            $woosasc_soskp = sanitize_text_field( $_REQUEST['woosasc_soskp'] );
                        } else {
                            $woosasc_soskp = '';
                        }

                        if(isset($_REQUEST['woosasc_email']) && !empty($_REQUEST['woosasc_email'])) {
                            $woosasc_email = sanitize_text_field( $_REQUEST['woosasc_email'] );
                        } else {
                            $woosasc_email = '';
                        }

                        if(isset($_REQUEST['woosasc_ctc']) && !empty($_REQUEST['woosasc_ctc'])) {
                            $woosasc_ctc = sanitize_text_field( $_REQUEST['woosasc_ctc'] );
                        } else {
                            $woosasc_ctc = '';
                        }

                        if(isset($_REQUEST['woosasc_save']) && !empty($_REQUEST['woosasc_save'])) {
                            $woosasc_save = sanitize_text_field( $_REQUEST['woosasc_save'] );
                        } else {
                            $woosasc_save = '';
                        }


                        update_option('woosasc_btnpos', sanitize_text_field( $_REQUEST['woosasc_btnpos'] ), 'yes');
                        update_option('woosasc_scbtext', sanitize_text_field( $_REQUEST['woosasc_scbtext'] ), 'yes');
                        update_option('woosasc_scptitle',  sanitize_text_field( $_REQUEST['woosasc_scptitle'] ), 'yes');
                        update_option('woosasc_sofb', $woosasc_sofb, 'yes');
                        update_option('woosasc_sott', $woosasc_sott, 'yes');
                        update_option('woosasc_sowa', $woosasc_sowa, 'yes');
                        update_option('woosasc_soinsta', $woosasc_soinsta, 'yes');
                        update_option('woosasc_soskp', $woosasc_soskp, 'yes');
                        update_option('woosasc_email', $woosasc_email, 'yes');
                        update_option('woosasc_ctc', $woosasc_ctc, 'yes');
                        update_option('woosasc_save', $woosasc_save, 'yes');
                        update_option('woosasc_emailfaddress',sanitize_text_field( $_REQUEST['woosasc_emailfaddress']),'yes');
                        update_option('woosasc_emailfname',sanitize_text_field( $_REQUEST['woosasc_emailfname']),'yes');
                        update_option('woosasc_emailsub',sanitize_text_field( $_REQUEST['woosasc_emailsub']),'yes');
                        update_option('woosasc_emailbody', sanitize_textarea_field( $_REQUEST['woosasc_emailbody'] ));
                        update_option('woosasc_savedclable',sanitize_text_field( $_REQUEST['woosasc_savedclable']),'yes');
                    }
                }
            }
        }

        function recursive_sanitize_text_field($array) {
            foreach ( $array as $key => &$value ) {
                if ( is_array( $value ) ) {
                    $value = $this->recursive_sanitize_text_field($value);
                }else{
                    $value = sanitize_text_field( $value );
                }
            }
            return $array;
        }

        function disable_new_posts() {
            global $submenu;
            unset($submenu['edit.php?post_type=woosasc_cart'][10]);
        }
        

        function remove_row_actions( $actions )
        {
            if( get_post_type() === 'woosasc_cart' ){
                unset( $actions['edit'] );
                unset( $actions['inline hide-if-no-js'] );
            }
            return $actions;
        }

        function WOOSASC_support_and_rating_notice() {
            $screen = get_current_screen();
            if( 'edit.php?post_type=woosasc_cart' == $screen->parent_file) {
                ?>
                <div class="woosasc_ratess_open">
                    <div class="woosasc_rateus_notice">
                        <div class="woosasc_rtusnoti_left">
                            <h3>Rate Us</h3>
                            <label>If you like our plugin, </label>
                            <a target="_blank" href="https://wordpress.org/support/plugin/pre-order-for-woocommerce/reviews/?filter=5">
                                <label>Please vote us</label>
                            </a>
                            
                            <label>,so we can contribute more features for you.</label>
                        </div>
                        <div class="woosasc_rtusnoti_right">
                            <img src="<?php echo WOOSASC_PLUGIN_DIR;?>/images/review.png" class="woosasc_review_icon">
                        </div>
                    </div>
                    <div class="woosasc_support_notice">
                        <div class="woosasc_rtusnoti_left">
                            <h3>Having Issues?</h3>
                            <label>You can contact us at</label>
                            <a target="_blank" href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress">
                                <label>Our Support Forum</label>
                            </a>
                        </div>
                        <div class="woosasc_rtusnoti_right">
                            <img src="<?php echo WOOSASC_PLUGIN_DIR;?>/images/support.png" class="woosasc_review_icon">
                        </div>
                    </div>
                </div>
                <div class="woosasc_donate_main">
                   <img src="<?php echo WOOSASC_PLUGIN_DIR;?>/images/coffee.svg">
                   <h3>Buy me a Coffee !</h3>
                   <p>If you like this plugin, buy me a coffee and help support this plugin !</p>
                   <div class="woosasc_donate_form">
                        <a class="button button-primary ocwg_donate_btn" href="https://www.paypal.com/paypalme/shayona163/" data-link="https://www.paypal.com/paypalme/shayona163/" target="_blank">Buy me a coffee !</a>
                   </div>
                </div>
                <?php
            }
        }

        function WOOSASC_register_meta_boxes() {
            add_meta_box( 'woosasc_cart_items', __( '<strong class="cart_metabox_title">CART ITEMS</strong>', 'wc-save-and-share-cart' ), array($this, 'WOOSASC_my_display_callback'), 'woosasc_cart' );
        }

        function WOOSASC_my_display_callback(){
            $product_id = get_post_meta(get_the_id(),'cart_item_ids',true);
            $var_id = get_post_meta(get_the_id(),'cart_item_varids',true);
            $qtys = get_post_meta(get_the_id(),'cart_item_qtys',true);
            $subtotal = get_post_meta(get_the_id(),'cart_item_subtotal',true);
            $cart_subtotal = get_post_meta(get_the_id(),'cart_subtotal',true);
            ?>
            <table class="cart_product_main">
                <tbody class="cart_product_inner">
                    <tr class="cart_item_header">
                        <th><?php echo __('No.','wc-save-and-share-cart');?></th>
                        <th><?php echo __('Image','wc-save-and-share-cart');?></th>
                        <th><?php echo __('Name','wc-save-and-share-cart');?></th>
                        <th><?php echo __('Quentity','wc-save-and-share-cart');?></th>
                        <th><?php echo __('Subtotal','wc-save-and-share-cart');?></th>
                    </tr>
                    <?php
                    $x = 1;
                    foreach ($product_id as $key => $pro_id) {
                        if (!empty($pro_id) && empty($var_id[$key])) {
                            $product = wc_get_product( $pro_id );
                        }elseif (!empty($pro_id) && !empty($var_id[$key])) {
                            $product = wc_get_product( $var_id[$key] );
                        }
                        ?>
                        <tr class="cart_item_detail">
                            <td class="product_number"><?php echo $x;?></td>
                            <td class="product_image">
                                <img class="pro_image_inner" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" />
                            </td>
                            <td class="product_name">
                                <span class="pro_name"><?php echo $product->get_name();?></span>
                            </td>
                            <td class="product_quentity">
                                <span class="pro_qty"><?php echo $qtys[$key];?></span>
                            </td>
                            <td class="product_subtotal">
                                <span class="pro_subtotal"><?php echo wc_price($subtotal[$key]);?></span>
                            </td>
                        </tr>
                        <?php
                        $x++;
                    }
                    ?>
                    <tr class="cart_item_footer">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cart_subtitle"><?php echo __('Cart Subtotal','wc-save-and-share-cart');?></td>
                        <td class="cart_subtotal">
                            <span class="cart_subtotal"><?php echo wc_price($cart_subtotal);?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
        }

        function init() {
            add_action( 'init', array($this, 'WOOSASC_create_posttype'));
            add_action( 'admin_menu',  array($this, 'WOOSASC_options_page'));
            add_action( 'init',  array($this, 'WOOSASC_save_options'));
            add_action('admin_menu', array($this,'disable_new_posts'));
            add_filter( 'post_row_actions', array($this,'remove_row_actions'), 10, 1 );
            add_action( 'admin_notices', array($this, 'WOOSASC_support_and_rating_notice' ));
            add_action( 'add_meta_boxes', array($this, 'WOOSASC_register_meta_boxes') );
        }

        public static function WOOSASC_instance() {
            if (!isset(self::$WOOSASC_instance)) {
                self::$WOOSASC_instance = new self();
                self::$WOOSASC_instance->init();
            }
            return self::$WOOSASC_instance;
        }
    }
    WOOSASC_settings::WOOSASC_instance();
}