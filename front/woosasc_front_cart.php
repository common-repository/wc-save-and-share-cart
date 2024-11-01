<?php

if (!defined('ABSPATH'))
    exit;

if (!class_exists('WOOSASC_front')) {

    class WOOSASC_front {

        protected static $WOOSASC_instance;

        function WOOSASC_add_share_cart_button() {
            
            if(!empty(get_option( 'woosasc_scbtext' ))) {
                $woosasc_scbtext = get_option( 'woosasc_scbtext' );
            } else {
                $woosasc_scbtext = 'Share Cart';
            }

            echo '<button class="button button-primary" id="woosasc_share_cart">'.$woosasc_scbtext.'</button>';
        }

        function WOOSASC_popup_div_footer(){
            ?>
            <div id="woosasc_sharecart_popup" class="woosasc_sharecart_popup_class">
            </div>
            <?php
        }

        function WOOSASC_sharecart_popup_html() {

            global $woocommerce,$woosasc_svg_icon;
            $items = WC()->cart->cart_contents;
            
            $woosasc_cart_hash = $_COOKIE['woocommerce_cart_hash'];

            if(!empty(get_option( 'woosasc_scptitle' ))) {
                $cart_page_title =  get_option( 'woosasc_scptitle' );
            }else {
                $cart_page_title = 'Cart';
            }

			$args = array(
			  'name'        => $woosasc_cart_hash,
			  'post_type'   => 'woosasc_cart',
			  'post_status' => 'publish',
			  'numberposts' => 1
			);

			$my_posts = get_posts($args);

			if ( empty($my_posts) ) {				
				$post_id = wp_insert_post(array (
	                'post_type' => 'woosasc_cart',
	                'post_title' => $cart_page_title,
	                'post_name' => $woosasc_cart_hash,
	                'post_status' => 'publish',
	                'comment_status' => 'closed',
	                'ping_status' => 'closed',
	            ));

	            if ($post_id) {
	                add_post_meta($post_id, 'woosasc_cart_data', $items);
	            }
			} else {
				$post_id = $my_posts[0]->ID;
			}
			
            $cart_link = get_permalink($post_id);

            $facebook_color = '#4267B2';
            $twitter_color = '#1DA1F2';
            $whatsapp_color = '#25D366';
            $linkedin_color = '#0e76a8';
            $instagram_color = '#F56040';
            $skype_color = '#00aff0';
            $email_color = '#cc473a';
            $copy_color = '#333333';
            $save_color = '#333333';

            ?>
            <div class="woosasc_scp_close_modal-content">
                <div class="woosasc_scp_inner_div">
                    <span class="woosasc_scp_close"><?php echo $woosasc_svg_icon['close_popup_icon'];?></span>
                    <ul id="woosac_scp_ul">
                        <div class="woosasc_scp_header_div"> 
                            <h3 class="woosasc_scp_header_inner_div">Share Cart & Save Cart</h3>
                        </div>                        
                        <?php
                        if(!empty(get_option( 'woosasc_sofb' )) && get_option( 'woosasc_sofb' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a target="_blank" title="Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink($post_id));?>">
                                <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['facebook_svg'];?></span>
                                <span class="woosasc_social_text" style="color: <?php echo $facebook_color;?>;">Facebook</span>
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_sott' )) && get_option( 'woosasc_sott' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a target="_blank" title="Twitter" href="https://twitter.com/intent/tweet?url=<?php echo $cart_link; ?>">
                            <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['twitter_svg'];?></span>
                            <span class="woosasc_social_text" style="color: <?php echo $twitter_color;?>;">Twitter</span>
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_sowa' )) && get_option( 'woosasc_sowa' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a target="_blank" title="Whatsapp" href="https://web.whatsapp.com/send?text=<?php echo $cart_link; ?>">
                            <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['whatsapp_svg'];?></span>
                            <span class="woosasc_social_text" style="color: <?php echo $whatsapp_color;?>;">Whatsapp</span>
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_soinsta' )) && get_option( 'woosasc_soinsta' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a target="_blank" title="Instagram" href="https://www.instagram.com/sharer.php?u=<?php echo $cart_link; ?>">
                            <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['instagram_svg'];?></span>
                            <span class="woosasc_social_text" style="color: <?php echo $instagram_color;?>;">Instagram</span>
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_soskp' )) && get_option( 'woosasc_soskp' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a target="_blank" title="Skype" href="https://web.skype.com/share?url=<?php echo $cart_link; ?>">
                            <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['skype_svg'];?></span>
                            <span class="woosasc_social_text" style="color: <?php echo $skype_color;?>;">Skype</span>
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_email' )) && get_option( 'woosasc_email' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a id="woosasc_send_mail" title="Email" target="_blank" href="#">
                                <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['email_svg'];?></span>
                                <span class="woosasc_social_text" style="color: <?php echo $email_color;?>;">Email</span>
                                <input type="hidden" name="woosasc_cart_hash_email" id="woosasc_cart_hash_email" value="<?php echo $woosasc_cart_hash; ?>">
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_ctc' )) && get_option( 'woosasc_ctc' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a id="woosasc_copyclipboard" title="Copy to clipboard" target="_blank" href="#" data-msg="Link copied.">
                                <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['copy_svg'];?></span>
                                <span class="woosasc_social_text" style="color: <?php echo $copy_color;?>;">Copy to clipboard</span>
                                <input type="hidden" name="woosasc_copylink" id="woosasc_copylink" value="<?php echo $cart_link; ?>">
                            </a>
                        </li>
                        <?php
                        }
                        if(!empty(get_option( 'woosasc_save' )) && get_option( 'woosasc_save' ) == 1) {
                        ?>
                        <li class="woosac_scp_li">
                            <a id="woosasc_save" title="Save" target="_blank" href="#">
                                <span class="woosasc_icon_svg"><?php echo $woosasc_svg_icon['save_svg'];?></span>
                                <span class="woosasc_social_text" style="color: <?php echo $save_color;?>;">Save</span>
                                <input type="hidden" name="woosasc_cart_hash_save" id="woosasc_cart_hash_save" value="<?php echo $woosasc_cart_hash; ?>">
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php   
            die(); 
        }

        function WOOSASC_save_cart_popup_html() {
            global $woosasc_svg_icon;
        	$cartHash = sanitize_text_field($_REQUEST['carthash']);

	        ob_start();
	        ?>
	        <span class="woosasc_scp_close"><?php echo $woosasc_svg_icon['close_popup_icon'];?></span>
	        <ul class="savecart_ul">
				<div class="woosasc_scp_header_div">
				<?php 
					if(!empty(get_option( 'woosasc_savedclable' ))) {
						$saved_cart_label = get_option( 'woosasc_savedclable' ); 
					} else { 
						$saved_cart_label = 'Save Cart'; 
					}
				?>
                    <h3 class="woosasc_scp_header_inner_div"><?php echo $saved_cart_label;?></h3>
				</div>
	        	<li class="savecart_li">
	        		<input type="text" name="wssc_sv_title" id="wssc_sv_title" placeholder="Cart Title">
	        	</li>
	        	<li class="savecart_li">
	        		<textarea placeholder="Cart Description" name="wssc_sv_desc" id="wssc_sv_desc"></textarea>
	        	</li>
	        	<li class="savecart_li">
                    <p class="ocsasc_error_sc" style="display: none;">Please fill all fields</p>
	        		<button id="wssc_sv_btn" class="button button-primary">Save Cart</button>
	        		<input type="hidden" name="wssc_sv_hash" id="wssc_sv_hash" value="<?php echo $cartHash; ?>">
	        	</li>
	        </ul>
	        <?php
	        $savecart_ul = ob_get_clean();
	        echo $savecart_ul;
	        die(); 
        }
        
        function WOOSASC_save_cart_func_html() {
        	$cartHash = sanitize_text_field($_REQUEST['carthash']);
        	$cartTitle = sanitize_text_field($_REQUEST['carttitle']);
        	$cartDesc = sanitize_text_field($_REQUEST['cartdesc']);

            $cart = WC()->cart;

            $product_id = array();
            $variation_id = array();
            $quantity = array();
            $line_subtotal = array();
            foreach ($cart->cart_contents as $cart_item) {
                $product_id[] = $cart_item['product_id'];
                $variation_id[] = $cart_item['variation_id'];
                $quantity[] = $cart_item['quantity'];
                $line_subtotal[] = $cart_item['line_subtotal'];
            }

        	$args = array(
			  'name'        => $woosasc_cart_hash,
			  'post_type'   => 'woosasc_cart',
			  'post_status' => 'publish',
			  'numberposts' => 1
			);

			$my_posts = get_posts($args);
			$post_id = $my_posts[0]->ID;
	        
	       	$update = wp_update_post( array(
			    'ID'           => $post_id,
			    'post_type'    => 'woosasc_cart',
			    'post_status'  => 'publish',
			    'post_title'   => $cartTitle,
			    'post_content' => $cartDesc,
			    'comment_status' => 'closed',
	            'ping_status' => 'closed',
		    ) );

            update_post_meta($post_id,'cart_item_ids',$product_id);
            update_post_meta($post_id,'cart_item_varids',$variation_id);
            update_post_meta($post_id,'cart_item_qtys',$quantity);
            update_post_meta($post_id,'cart_item_subtotal',$line_subtotal);
            update_post_meta($post_id,'cart_subtotal',$cart->subtotal);

	       	echo 'Cart Saved Successfully.';

	        die(); 
        }
        
        function WOOSASC_send_mail_popup_html() {
            global $woosasc_svg_icon;
        	$cartHash = sanitize_text_field($_REQUEST['carthash']);

            $args = array(
              'name'        => $cartHash,
              'post_type'   => 'woosasc_cart',
              'post_status' => 'publish',
              'numberposts' => 1
            );

            $my_posts = get_posts($args);
            $post_id = $my_posts[0]->ID;
            $cart_link = get_permalink($post_id);

            
            if(!empty(get_option( 'woosasc_emailsub' ))) {
                $woosasc_emailsub = get_option( 'woosasc_emailsub' );
            } else {
                $woosasc_emailsub = '';
            }

            if(!empty(get_option( 'woosasc_emailbody' ))) {
                $woosasc_emailbody = get_option( 'woosasc_emailbody' );
            } else {
                $woosasc_emailbody = '';
            }

            $woosasc_emailbody       = str_replace( '{ct_link}', $cart_link, $woosasc_emailbody );
            $woosasc_emailbody       = str_replace( '{wsc_blogname}', get_bloginfo('name'), $woosasc_emailbody );
            $woosasc_emailbody       = str_replace( '{wsc_siteurl}', get_bloginfo('url'), $woosasc_emailbody );


	        ob_start();
	        ?>
	        <span class="woosasc_scp_close"><?php echo $woosasc_svg_icon['close_popup_icon'];?></span>
	        <form method="post" name="wssc_eml_form" id="wssc_eml_form" action="/">
		        <ul class="sendmail_ul">
                    <div class="woosasc_scp_header_div">
                        <h3 class="woosasc_scp_header_inner_div">Send Mail</h3>
                    </div>
		        	<li class="sendmail_li">
		        		<input type="text" name="wssc_eml_add" id="wssc_eml_add" placeholder="Email Address">
		        	</li>
		        	<li class="sendmail_li">
		        		<input type="text" name="wssc_eml_sub" id="wssc_eml_sub" placeholder="Email Subject" 
                            value="<?php echo $woosasc_emailsub; ?>">
		        	</li>
		        	<li class="sendmail_li">
		        		<textarea placeholder="Email Content" name="wssc_eml_cont" id="wssc_eml_cont"><?php echo $woosasc_emailbody; ?></textarea>
		        	</li>
		        	<li class="sendmail_li">
                        <p class="ocsasc_error_mail" style="display: none;">Please fill all fields</p>
		        		<button id="wssc_eml_btn" class="button button-primary">Send Mail</button>
		        		<input type="hidden" name="wssc_eml_hash" id="wssc_eml_hash" value="<?php echo $cartHash; ?>">
		        		<input type="hidden" name="action" value="send_mail_func">
		        	</li>
		        </ul>
		    </form>
	        <?php
	        $sendmail_ul = ob_get_clean();
	        echo $sendmail_ul;
	        die();
        }

        function WOOSASC_send_mail_func_html() {

            $woosasc_emailfaddress = get_option( 'woosasc_emailfaddress' );
            $woosasc_emailfname = get_option( 'woosasc_emailfname' );

            $response = 'Email sent successfully.';

            $to         = sanitize_text_field($_POST['wssc_eml_add']);
            $subject    = sanitize_text_field($_POST['wssc_eml_sub']);
            $body       = sanitize_textarea_field($_POST['wssc_eml_cont']);
            apply_filters( 'wp_mail_from', function( $email ){
                            
                $from_email = $woosasc_emailfaddress;
                if( !empty($from_email) )
                    $email = $from_email;
                
                return $email;

            });

            apply_filters( 'wp_mail_from_name', function( $name ){
                            
                $from_name  = !empty($woosasc_emailfname);
                if( !empty($from_name) )
                    $name = $from_email;

                return $name;

            });

            $email_body    = apply_filters( 'woosasc_email_body', $body );

            $mail_sent = wp_mail( $to, $subject, $email_body );

            if(!$mail_sent){

                $response = 'Email couldn\'t be sent.';
            }

            echo $response;
            die;
        }

        function WOOSASC_share_cart_single_page( $content ) {
            $filtered_content = '';
            if ( is_singular( 'woosasc_cart' ) ) {

                global $post,$woosasc_svg_icon;
                $cart = get_post_meta( $post->ID, 'woosasc_cart_data' );

                if ( ! empty( $cart ) ) {

                    $cart = $cart[0];

                    ob_start();
                    ?>

                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">

                        <thead>
                            <tr>
                                <th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                                <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                                <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                                <th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach( $cart as $item_key => $item ){

                                    $product   = apply_filters( 'woocommerce_cart_item_product', $item['data'], $item, $item_key );
                                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $item['product_id'], $item, $item_key );

                                    if ( $product && $product->exists() && $item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $item, $item_key ) ) {
                                        
                                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink( $item ) : '', $item, $item_key );?>
                                        
                                        <tr class="woocommerce-cart-form__cart-item">

                                            <td class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('thumbnail'), $item, $item_key );

                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( $thumbnail );
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
                                            }
                                            ?>

                                            </td>

                                            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $product->get_name(), $item, $item_key ) . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product->get_name() ), $item, $item_key ) );
                                            }

                                            do_action( 'woocommerce_after_cart_item_name', $item, $item_key );

                                            
                                            echo wc_get_formatted_cart_item_data( $item );

                                            
                                            if ( $product->backorders_require_notification() && $product->is_on_backorder( $item['quantity'] ) ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
                                            }
                                            ?>
                                            </td>

                                            <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                                <?php
                                                    echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $item, $item_key );
                                                ?>
                                            </td>

                                            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                            <?php
                                            if ( $product->is_sold_individually() ) {
                                                $product_quantity = 1;
                                            } else {
                                                $product_quantity = $item['quantity'];
                                            }

                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $item_key, $item );
                                            ?>
                                            </td>

                                            <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
                                                <?php
                                                    echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $product, $item['quantity'] ), $item, $item_key );
                                                ?>
                                            </td>

                                        </tr><?php
                                    }
                            } ?>
                        </tbody>
                    </table>

                    <div class="woosasc_scb_main">
                        
                        <div class="woosasc_scb_div">
                            <ul class="woosasc_scb_ul">
                                <?php
                                if(!empty(get_option( 'woosasc_sofb' )) && get_option( 'woosasc_sofb' ) == 1) {
                                ?>
                                <li class="woosac_scp_li">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>">
                                        <span class="woosasc_icon_svg_share_cart"><?php echo $woosasc_svg_icon['facebook_svg'];?></span>
                                    </a>
                                </li>
                                <?php
                                }
                                if(!empty(get_option( 'woosasc_sott' )) && get_option( 'woosasc_sott' ) == 1) {
                                ?>
                                <li class="woosac_scp_li">
                                    <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_the_permalink(); ?>">
                                        <span class="woosasc_icon_svg_share_cart"><?php echo $woosasc_svg_icon['twitter_svg'];?></span>
                                    </a>
                                </li>
                                <?php
                                }
                                if(!empty(get_option( 'woosasc_sowa' )) && get_option( 'woosasc_sowa' ) == 1) {
                                ?>
                                <li class="woosac_scp_li">
                                    <a target="_blank" href="https://web.whatsapp.com/send?text=<?php echo get_the_permalink(); ?>">
                                        <span class="woosasc_icon_svg_share_cart"><?php echo $woosasc_svg_icon['whatsapp_svg'];?></span>
                                    </a>
                                </li>
                                <?php
                                }
                                if(!empty(get_option( 'woosasc_soskp' )) && get_option( 'woosasc_soskp' ) == 1) {
                                ?>
                                <li class="woosac_scp_li">
                                    <a target="_blank" href="https://web.skype.com/share?url=<?php echo get_the_permalink(); ?>">
                                        <span class="woosasc_icon_svg_share_cart"><?php echo $woosasc_svg_icon['skype_svg'];?></span>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        
                        <div class="woosasc_load">
                            <a class="button btn" href="<?php echo get_home_url(); ?>/?action=load_cart&wsc_id=<?php echo get_the_ID(); ?>">Load this cart</a>
                        </div>

                    </div>

                    <?php
                    $filtered_content = ob_get_clean();
                }
            }

            return ( $filtered_content ) ? $filtered_content : $content;
        }

        function WOOSASC_add_saved_carts_endpoint() {
            add_rewrite_endpoint( 'saved-carts', EP_ROOT | EP_PAGES );
        }

        function WOOSASC_add_saved_carts() {

            if(!empty($_GET['action']) && $_GET['action'] == 'remove_cart') {
 
                $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                 
                $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $url = substr($url, 0, strpos($url, "?"));

                $wsc_id = sanitize_text_field($_GET['wsc_id']);

                wp_delete_post( $wsc_id, true );
                wp_redirect($url);
                exit;
            }

            if(!empty($_GET['action']) && $_GET['action'] == 'load_cart') {

                $wsc_id = sanitize_text_field($_GET['wsc_id']);
                $cart = get_post_meta( $wsc_id, 'woosasc_cart_data' );

                if ( ! empty( $cart ) ) {
                    $cart = $cart[0];

                    $cart_page = wc_get_page_id( 'cart' );
                    WC()->cart->empty_cart();

                    foreach ( $cart as $key => $item ) {
                        WC()->cart->add_to_cart( $item['product_id'], $item['quantity'], $item['variation_id'], $item['variation'] );
                    }

                    wp_redirect( get_permalink( $cart_page ) );
                    die( 1 );
                }
            }

            if(!empty(get_option( 'woosasc_btnpos' ))) {
                $woosasc_btnpos = get_option( 'woosasc_btnpos' );
            } else {
                $woosasc_btnpos = 'sel_btn_post';
            }

            if($woosasc_btnpos == 'before_cart_table') {
                add_action('woocommerce_before_cart_table', array($this, 'WOOSASC_add_share_cart_button'));
            }

            if($woosasc_btnpos == 'after_cart_table') {
                add_action('woocommerce_after_cart_table', array($this, 'WOOSASC_add_share_cart_button'));
            }

            if($woosasc_btnpos == 'before_cart') {
                add_action('woocommerce_before_cart', array($this, 'WOOSASC_add_share_cart_button'));
            }

            if($woosasc_btnpos == 'after_cart') {
                add_action('woocommerce_after_cart', array($this, 'WOOSASC_add_share_cart_button'));
            }

            if($woosasc_btnpos == 'beside_update_cart') {
                add_action('woocommerce_cart_actions', array($this, 'WOOSASC_add_share_cart_button'));
            }
        }
          
         
        function WOOSASC_add_saved_carts_query_vars( $vars ) {
            $vars[] = 'saved-carts';
            return $vars;
        }

  
        function WOOSASC_add_saved_carts_link_my_account( $items ) {
            $items['saved-carts'] = 'Saved carts';
            return $items;
        }

          
        function WOOSASC_add_saved_carts_content() {
            
            ob_start();
            $woosasc_myac_link = get_page_link();
            ?>
            <table class="woosasc_myac_table">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Cart Name</th>
                        <th>Cart Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $args = array(
                        'author' => get_current_user_id(),
                        'post_type'        => 'woosasc_cart',
                        'posts_per_page'   => -1,
                        'category'         => '',
                        );
                    $query = new WP_Query( $args ); 
                    if ( $query->have_posts() ) {
                        $i=1;
                        while ( $query->have_posts() ) {
                        $query->the_post(); 
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td><a href="<?php echo $woosasc_myac_link; ?>saved-carts/?action=remove_cart&wsc_id=<?php echo get_the_ID(); ?>">Remove Cart</a></td>
                    </tr>
                    <?php
                        $i++;
                        }
                    }
                    wp_reset_query();
                    ?>
                </tbody>
            </table>
            <?php
            echo $sc_content = ob_get_clean();
        }


        function init() {
            add_action('wp_footer', array( $this, 'WOOSASC_popup_div_footer' ));
            add_action('wp_ajax_sharecart_popup', array( $this, 'WOOSASC_sharecart_popup_html' ));
            add_action('wp_ajax_nopriv_sharecart_popup', array( $this, 'WOOSASC_sharecart_popup_html'));
            add_action('wp_ajax_save_cart_popup', array( $this, 'WOOSASC_save_cart_popup_html' ));
            add_action('wp_ajax_nopriv_save_cart_popup', array( $this, 'WOOSASC_save_cart_popup_html'));
            add_action('wp_ajax_save_cart_func', array( $this, 'WOOSASC_save_cart_func_html' ));
            add_action('wp_ajax_nopriv_save_cart_func', array( $this, 'WOOSASC_save_cart_func_html'));
            add_action('wp_ajax_send_mail_popup', array( $this, 'WOOSASC_send_mail_popup_html' ));
            add_action('wp_ajax_nopriv_send_mail_popup', array( $this, 'WOOSASC_send_mail_popup_html'));
            add_filter( 'the_content', array($this, 'WOOSASC_share_cart_single_page'), 99 );
            add_action('wp_ajax_send_mail_func', array( $this, 'WOOSASC_send_mail_func_html' ));
            add_action('wp_ajax_nopriv_send_mail_func', array( $this, 'WOOSASC_send_mail_func_html'));
            add_action( 'init', array( $this, 'WOOSASC_add_saved_carts_endpoint' ));
            add_action( 'wp', array( $this, 'WOOSASC_add_saved_carts' ));
            add_filter( 'query_vars', array( $this, 'WOOSASC_add_saved_carts_query_vars'), 0);
            add_filter( 'woocommerce_account_menu_items', array( $this, 'WOOSASC_add_saved_carts_link_my_account' ));
            add_action( 'woocommerce_account_saved-carts_endpoint', array( $this, 'WOOSASC_add_saved_carts_content' ));
        }


        public static function WOOSASC_instance() {
            if (!isset(self::$WOOSASC_instance)) {
                self::$WOOSASC_instance = new self();
                self::$WOOSASC_instance->init();
            }
            return self::$WOOSASC_instance;
        }
    }
    WOOSASC_front::WOOSASC_instance();
}