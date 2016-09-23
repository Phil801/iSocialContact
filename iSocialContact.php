<?php
/*
  Plugin Name: iSocialContact
  Description: iPhone Style Contact and Social Info Display
  Plugin URI: http://phil801.com/projects/isocialcontact-plugin/
  Version: 1.15
  Author: Phil Burns
  License: None
 */

class iSocialContact extends WP_Widget {

    function iSocialContact() {
        $widget_ops = array('classname' => 'iSocialContact', 'description' => 'iPhone Style Contact and Social Info Display');
        $this->WP_Widget('iSocialContact', 'iSocialContact', $widget_ops);
        $pluginurl = plugins_url(basename(__FILE__, '.php'), dirname(__FILE__));

        wp_register_style('icontact-css', plugin_dir_url(__FILE__) . 'images/icontact.css', false, phil801_get_version(), 'all');
        if (!isset($disabled_styles['icontact-css'])) {
            wp_enqueue_style('icontact-css');
        }

    }

    function form($instance) {
        $defaults = icontact_get_defaults();
        $instance = wp_parse_args($instance, $defaults);

        $m = 0;
        for ($i = 1; $i < 6; $i++) {
            ?>
            <p>
                <strong><label for="Row"<?php echo $i; ?> >Row <?php echo $i; ?> Icons:</label></strong>
            </p>
            <?php
            for ($l = 1; $l < 5; $l++) {
                $m++;
                if ($m > 19) {
                    break;
                }
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id('icontypes') . '-' . $m; ?>">Select Icon <?php echo $m; ?></label>
                    <select id="<?php echo $this->get_field_id('icontypes') . '-' . $m; ?>" class="widefat" name="<?php echo $this->get_field_name('icontypes') . '[' . $m . ']'; ?>">
                        <?php getdropdown($instance['icontypes'][$m]); ?>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('iconlinks') . '-' . $m; ?>">Link for Icon<input class="widefat" id="<?php echo $this->get_field_id('iconlinks') . '-' . $m; ?>" name="<?php echo $this->get_field_name('iconlinks') . '[' . $m . ']'; ?>" type="text" value="<?php echo attribute_escape($instance['iconlinks'][$m]); ?>" />
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('icontitles') . '-' . $m; ?>">Popup Text for Icon<input class="widefat" id="<?php echo $this->get_field_id('icontitle') . '-' . $m; ?>" name="<?php echo $this->get_field_name('icontitles') . '[' . $m . ']'; ?>" type="text" value="<?php echo attribute_escape($instance['icontitles'][$m]); ?>" />
                    </label>
                </p>
                <?php
            }
        }
        return $instance;
    }

    function update($new_instance, $old_instance) {
        $instance = icontact_get_defaults();

        file_put_contents('/wp_results.txt', print_r($instance, true));
        file_put_contents('/wp_results.txt', print_r($old_instance, true), FILE_APPEND);
        file_put_contents('/wp_results.txt', print_r($new_instance, true), FILE_APPEND);

        for ($i = 1; $i < 20; $i++) {
            $instance['icontypes'][$i] = $old_instance['icontypes'][$i];
            $instance['iconlinks'][$i] = $old_instance['iconlinks'][$i];
            $instance['icontitles'][$i] = $old_instance['icontitles'][$i];
        };

        for ($i = 1; $i < 20; $i++) {
            $instance['icontypes'][$i] = $new_instance['icontypes'][$i];
            $instance['iconlinks'][$i] = $new_instance['iconlinks'][$i];
            $instance['icontitles'][$i] = $new_instance['icontitles'][$i];
        };

        return $instance;
    }

    function widget($args, $instance) {

        extract($args, EXTR_SKIP);
        echo $before_widget;

        for ($i = 1; $i < 21; $i++) {
            $icontypes[$i] = $instance['icontypes'][$i];
            $iconlinks[$i] = $instance['iconlinks'][$i];
            $icontitles[$i] = $instance['icontitles'][$i];
        };
        ?>

        <div id="contactwidget"> 
            <div class="itoolbar">
                <div class="iphone" >
                    <div class="toprow">
                        <?php
                        for ($i = 1; $i < 5; $i++) {
                            ?>
                            <a target="_parent" href="<?php echo $iconlinks[$i]; ?>"><img src="<?php echo b_geticontype($icontypes[$i]); ?>" title="<?php echo $icontitles[$i]; ?>"></a>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="floatrow">
                        <?php
                        for ($i = 5; $i < 9; $i++) {
                            ?>
                            <a target="_parent" href="<?php echo $iconlinks[$i]; ?>"><img src="<?php echo b_geticontype($icontypes[$i]); ?>" title="<?php echo $icontitles[$i]; ?>"></a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="floatrow">
                        <?php
                        for ($i = 9; $i < 13; $i++) {
                            ?>
                            <a target="_parent" href="<?php echo $iconlinks[$i]; ?>"><img src="<?php echo b_geticontype($icontypes[$i]); ?>" title="<?php echo $icontitles[$i]; ?>"></a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="floatrow">
                        <?php
                        for ($i = 13; $i < 17; $i++) {
                            ?>
                            <a target="_parent" href="<?php echo $iconlinks[$i]; ?>"><img src="<?php echo b_geticontype($icontypes[$i]); ?>" title="<?php echo $icontitles[$i]; ?>"></a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="dockrow">
                        <?php
                        for ($i = 17; $i < 20; $i++) {
                            ?>
                            <a target="_parent" href="<?php echo $iconlinks[$i]; ?>"><img src="<?php echo b_geticontype($icontypes[$i]); ?>" title="<?php echo $icontitles[$i]; ?>"></a>
                            <?php
                        }
                        ?>
                        <a target="_parent" href="<?php echo $iconlinks[20]; ?>"><img src="<?php echo b_geticontype($icontypes[20]); ?>" title="<?php echo $icontitles[20]; ?>"></a>
                    </div>
                </div>
            </div>
        </div>		
        <?php
        echo $after_widget;
    }

}

function icontact_get_defaults() {
    $icontypes2 = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13,
        14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20);

    $iconlinks2 = array(1 => 'http://www.facebook.com/[username]', 2 => 'http://www.linkedin.com/in/[username]',
        3 => 'http://www.youtube.com/[channel_name]', 4 => '', 5 => 'http://plus.google.com',
        6 => 'http://myskype.info/[skype user]', 7 => 'http://www.twitter.com/[username]',
        8 => 'http://www.pinterest.com/[username]', 9 => 'http://www.taleo.com', 10 => 'http://www.stumbleupon.com/stumbler/[username]',
        11 => 'http://www.flickr.com/[username]', 12 => 'http://www.americanpreppersnetwork.com', 13 => 'http://www.phil801.com',
        14 => 'http://www.ancestry.com', 15 => 'http://calendar.google.com',
        16 => 'http://www.americanpreppersnetwork.com', 17 => 'mailto:user@domain.com?Subject=subject line',
        18 => 'tel:[phone number]', 19 => 'http://www.flickr.com',
        20 => 'http://phil801.com/projects/isocialcontact-plugin/');

    $icontitles2 = array(1 => 'My Facebook', 2 => 'My Linkedin', 3 => 'My Youtube', 4 => 'My RSS', 5 => 'My Google Plus', 6 => 'My Skype',
        7 => 'My Twitter', 8 => 'My Pinterest', 9 => 'My Taleo', 10 => 'My StumbleUpon', 11 => 'My Flickr', 12 => 'Prepping',
        13 => 'My Homepage', 14 => 'My Ancestry', 15 => 'My Calendar',
        16 => 'My Company', 17 => 'Email Me', 18 => 'Call Me', 19 => 'My Pictures', 20 => 'Download this plugin');

    $defaults2 = array('icontypes' => $icontypes2, 'iconlinks' => $iconlinks2, 'icontitles' => $icontitles2);

    return $defaults2;
}

function getdropdown($selectid) {

    $cat_options = array();
    $cat_options[] = '<option value="BLANK"' . ($selectid == "BLANK" ? ' selected' : '') . '>Select one...</option>';
    $cat_options[] = '<option value="1"' . ($selectid == "1" ? ' selected' : '') . '>Facebook</option>';
    $cat_options[] = '<option value="2"' . ($selectid == "2" ? ' selected' : '') . '>LinkedIn</option>';
    $cat_options[] = '<option value="3"' . ($selectid == "3" ? ' selected' : '') . '>YouTube</option>';
    $cat_options[] = '<option value="4"' . ($selectid == "4" ? ' selected' : '') . '>RSS Feed</option>';
    $cat_options[] = '<option value="5"' . ($selectid == "5" ? ' selected' : '') . '>Google Plus</option>';
    $cat_options[] = '<option value="6"' . ($selectid == "6" ? ' selected' : '') . '>Skype</option>';
    $cat_options[] = '<option value="7"' . ($selectid == "7" ? ' selected' : '') . '>Twitter</option>';
    $cat_options[] = '<option value="8"' . ($selectid == "8" ? ' selected' : '') . '>Pinterest</option>';
    $cat_options[] = '<option value="9"' . ($selectid == "9" ? ' selected' : '') . '>Taleo UP</option>';
    $cat_options[] = '<option value="10"' . ($selectid == "10" ? ' selected' : '') . '>Stumble Upon</option>';
    $cat_options[] = '<option value="11"' . ($selectid == "11" ? ' selected' : '') . '>Flickr</option>';
    $cat_options[] = '<option value="12"' . ($selectid == "12" ? ' selected' : '') . '>Company Site</option>';
    $cat_options[] = '<option value="13"' . ($selectid == "13" ? ' selected' : '') . '>Blog</option>';
    $cat_options[] = '<option value="14"' . ($selectid == "14" ? ' selected' : '') . '>Ancestry</option>';
    $cat_options[] = '<option value="15"' . ($selectid == "15" ? ' selected' : '') . '>Calendar</option>';
    $cat_options[] = '<option value="16"' . ($selectid == "16" ? ' selected' : '') . '>APN</option>';
    $cat_options[] = '<option value="17"' . ($selectid == "17" ? ' selected' : '') . '>E-Mail</options>';
    $cat_options[] = '<option value="18"' . ($selectid == "18" ? ' selected' : '') . '>Phone</options>';
    $cat_options[] = '<option value="19"' . ($selectid == "19" ? ' selected' : '') . '>Pictures</options>';
    echo implode('', $cat_options);
}

function b_geticontype($icontype) {
    $plugindir = plugin_dir_url(__FILE__);
    switch ($icontype) {
        case 1:
            $result = $plugindir . "images/bfacebook2.png";
            break;
        case "2":
            $result = $plugindir . "images/bLinkedIn.png";
            break;
        case "3":
            $result = $plugindir . "images/bYouTube.png";
            break;
        case "4":
            $result = $plugindir . "images/brss.png";
            break;
        case "5":
            $result = $plugindir . "images/bgoogplus2.png";
            break;
        case "6":
            $result = $plugindir . "images/bskype2.png";
            break;
        case "7":
            $result = $plugindir . "images/bTwitter.png";
            break;
        case "8":
            $result = $plugindir . "images/bpinterest2.png";
            break;
        case "9":
            $result = $plugindir . "images/bUp.png";
            break;
        case "10":
            $result = $plugindir . "images/bstumble.png";
            break;
        case "11":
            $result = $plugindir . "images/bflickr.png";
            break;
        case "12":
            $result = $plugindir . "images/bbusiness.png";
            break;
        case "13":
            $result = $plugindir . "images/bblog.png";
            break;
        case "14":
            $result = $plugindir . "images/bancestry.png";
            break;
        case "15":
            $result = $plugindir . "images/bcal.png";
            break;
        case "16":
            $result = $plugindir . "images/bapnshield.png";
            break;
        case "17":
            $result = $plugindir . "images/bMail.png";
            break;
        case "18":
            $result = $plugindir . "images/bPhone.png";
            break;
        case "19":
            $result = $plugindir . "images/bPhotos.png";
            break;
        case "20":
            $result = $plugindir . "images/bgetplugin.png";
            break;
        default:
            $result = $plugindir . "images/btransparent.png";
    }

    return $result;
}

function phil801_get_version() {
    if (!function_exists('get_plugins')) {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
    $plugin_file = basename(( __FILE__));
    return $plugin_folder[$plugin_file]['Version'];
}

add_action('widgets_init', create_function('', 'return register_widget("iSocialContact");'));
?>