<?php
/**
 * Plugin Name: WooCommerce Label Replacer
 * Plugin URI: https://github.com/lukasjuhas/wc-label-replacer
 * Description: Replace default "WooCommerce" Label with simple "Shop" and simplified icon.
 * Version: 1.3
 * Author: Lukas Juhas
 * Author URI: http://itsluk.as
 * Text Domain: wc-label-replacer
 * License: GPL2
 */

/*  Copyright 2014-2017  Lukas Juhas

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WooCommerce Label Replacer
 *
 */
class WC_Label_Replacer
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // make sure WooCommerce is enabled
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_action('admin_menu', [$this, 'menu'], 100);
            add_action('admin_head', [$this, 'styles']);
        }
    }

    /**
     * Hook on to menu and change the label
     *
     * @since 1.0
     * @return void
     */
    public function menu()
    {
        global $menu;
        $order_count = wc_processing_order_count();

        foreach ($menu as $i => $item) {
            if ($item[2] == 'woocommerce') {
                $index = $i;
                break;
            }
        }

        $menu[$index][0] = sprintf(
            'Shop <span class="awaiting-mod update-plugins count-%s"><span class="processing-count">%s</span></span>',
            $order_count,
            number_format_i18n($order_count)
        );
    }

    /**
     * Add styles to admin header to force new icon for woocommerce
     *
     * @since 1.0
     * @return void
     */
    public function styles()
    {
        echo '
            <style>
                #adminmenuwrap #adminmenu #toplevel_page_woocommerce .menu-icon-generic div.wp-menu-image::before {
                    font-family: dashicons !important;
                    content: "\f323" !important;
                }
            </style>
        ';
    }
}

// init
$WC_Label_Replacer = new WC_Label_Replacer();
