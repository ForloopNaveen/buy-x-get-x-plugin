<?php

namespace Bxgx\App\Controller\Admin;

defined("ABSPATH") or die();

class Main
{

    public static function addSubMenuInProductTab(){
        add_submenu_page(
            'edit.php?post_type=product',
            'Buy-x-Get-x',
            'Buy-X-Get-X',
            'manage_options',
            'buy-x-get-x',
            [self::class, 'buyxGetxProductPage'],
            10
        );
    }

    public static function buyxGetxProductPage() {
        $file_path = BXGX_PLUGIN_PATH.'App/View/';
        wc_get_template(
            'Main.php',
            array(),
            '',
            $file_path
        );
    }

    public static function enqueueScriptsAndStyles() {
        wp_enqueue_style('bxgx-style', BXGX_PLUGIN_URL . 'Assets/css/style.css');
        wp_enqueue_script('script', BXGX_PLUGIN_URL . 'Assets/js/script.js', array('jquery'), null, true);


        wp_localize_script('script', 'BxgxScript', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    public static function saveBuyxGetxProducts() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['selected_products'])) {
                $selected_products = explode(',', sanitize_text_field($_POST['selected_products']));
                foreach ($selected_products as $product_id) {
                    update_post_meta($product_id, '_buy_x_get_x_enabled', 'yes');
                }
                echo "Product added Successfully!";

            } elseif (isset($_POST['unselected_products'])) {
                $unselected_products = explode(',', sanitize_text_field($_POST['unselected_products']));
                foreach ($unselected_products as $product_id) {
                    update_post_meta($product_id, '_buy_x_get_x_enabled', 'no');
                }
                echo "Product removed Successfully!";

            }
        }
    }


    public static function displayFreeProductMessageInFrontend() {
        $file_path = BXGX_PLUGIN_PATH.'App/View/';
        wc_get_template(
            'displayProduct.php',
            array(),
            '',
            $file_path
        );
    }



    public static function addFreeProductToCart($cart_item_key, $product_id, $quantity) {
            if (get_post_meta($product_id, '_buy_x_get_x_enabled', true) === 'yes') {
            $free_product_id = $product_id;
            $found = false;

            foreach (WC()->cart->get_cart() as $key => $values) {
                if ($values['product_id'] == $free_product_id && isset($values['is_free'])) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                WC()->cart->add_to_cart($free_product_id, $quantity, 0, array(), array('is_free' => true, 'main_product_key' => $cart_item_key));
            }

        }
    }

    /**
     * This is a function to set our free product price into zero
     *
     * @param $cart
     * @return void
     */
    public static function setFreeProductPriceToZero($cart) {
        foreach ($cart->get_cart() as $cart_item) {
            if (isset($cart_item['is_free'])) {
                $cart_item['data']->set_price(0);

            }
        }
    }

    /**
     * This function is used to synchronize our free product quantity to our main product
     *
     * @param $cart_item_key
     * @param $quantity
     * @param $cart
     * @param $old_quantity
     * @return void
     */

    public static function synchronizeFreeProductQuantity($cart_item_key, $quantity,$old_quantity ,$cart) {
        foreach ($cart->get_cart() as $key => $cart_item) {
            if (isset($cart_item['is_free']) && $cart_item['main_product_key'] == $cart_item_key) {
                WC()->cart->set_quantity($key, $quantity);

            }
        }
    }

    /**
     * This function is used to if I remove our main product in the cart at the same time I want to remove our free product also..
     *
     * @param $cart_item_key
     * @param $cart
     * @return void
     */
    public static function removeFreeProductWhenMainRemoved($cart_item_key, $cart) {
        foreach ($cart->get_cart() as $key => $cart_item) {
            if (isset($cart_item['is_free']) && $cart_item['main_product_key'] == $cart_item_key) {
                $cart->remove_cart_item($key);
          }
        }
    }

    /**
     * This function is used to display the free product indication in the cart section
     *
     * @param $item_data
     * @param $cart_item
     * @return mixed
     */
    public static function displayFreeProductInfo($item_data, $cart_item)
    {
        if (isset($cart_item['is_free']) && $cart_item['is_free'] === true) {

            $item_data[] = array(
                'key' => esc_html__('Free Gift', 'buy-x-get-x'),
                'value' => esc_html__('This product is free with your purchase', 'buy-x-get-x')
            );

        }
        return $item_data;
    }

}



