<?php
defined("ABSPATH") or die();

global $product;


if (get_post_meta($product->get_id(), '_buy_x_get_x_enabled', true) === 'yes') {
    ?>
    <html>
    <head>
        <title></title>
        <style>
            .bxgx-free-message{
                font-family: "Poppins", sans-serif;
                color: seagreen;
                font-weight: 600;
            }
        </style>
    </head>
    <body>
    <div class="bxgx-free-message">
        <p class="bxgx-message"><?php echo esc_html__('Buy One, Get One for Free....!','buy-x-get-x'); ?></p>
    </div>
    </body>
    </html>

<?php
}