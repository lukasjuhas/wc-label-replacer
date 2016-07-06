<?php
/**
 * Plugin Name: WooCommerce Label Replacer
 * Plugin URI: https://github.com/lukasjuhas/wc-label-replacer
 * Description: Replace default "WooCommerce" Label with simple "Shop"
 * Version: 1.1
 * Author: Lukas Juhas
 * Author URI: http://lukasjuhas.com/
 * Text Domain: wc-label-replacer
 * License: GPL2
 */

/*  Copyright 2014-2016  Lukas Juhas

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

# Exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

class WC_Label_Replacer
{
    public function __construct()
    {
        // make sure WooCommerce is enabled
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_action('admin_menu', array($this, 'menu'), 100);
            add_action('admin_head', array($this, 'styling'));
        }
    }
  /**
   * Hook on to menu and change the label
   * @method  menu
   * @return  ''
   * @author Lukas Juhas
   * @package wc-label-replacer
   * @version 1.0
   * @date    2015-08-11
   */
  public function menu()
  {
      global $menu;
      $order_count = wc_processing_order_count();

      foreach ($menu as $i => $item) {
          if ('woocommerce' == $item[2]) {
              $index = $i;
              break;
          }
      }
      $menu[$index][0] = 'Shop <span class="awaiting-mod update-plugins count-' . $order_count . '"><span class="processing-count">' . number_format_i18n($order_count) . '</span></span>';
  }

  /**
   * Add styling to admin header to force new icon for woocommerce
   * @method  menu
   * @return  styling
   * @author Lukas Juhas
   * @package wc-label-replacer
   * @version 1.0
   * @date    2015-08-11
   */
  public function styling()
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
# init
$WC_Label_Replacer = new WC_Label_Replacer();
