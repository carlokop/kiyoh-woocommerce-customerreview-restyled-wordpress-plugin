<?php

//create widget kiyoh_review
class kiyoh_review extends WP_Widget
{

    function __construct()
    {
        $this->copyRatingSprite();
        parent::__construct('kiyoh_review', 'Kiyoh review', array('description' => 'show Kiyoh review'));
    }

    public function widget($args, $instance)
    {
        $method = kiyoh_getOption('kiyoh_option_send_method');
        if ($method == 'kiyoh') {
            $this->widget_new($args, $instance);
        } else {
            $this->widget_old($args, $instance);
        }
    }

    public function widget_new($args, $instance)
    {
        $data = $this->receiveData($instance);
        if (isset($data->company->total_score)):
            $rating_percentage = $data->company->total_score * 10;
            $maxrating = 10;
            $url = $data->company->url;
            $rating = $data->company->total_score;
            $reviews = $data->company->total_reviews;
            $image_dir = plugins_url("/", __FILE__)
            ?>

            <?php echo $args['before_widget']; ?>
            
            <style>
                /* @import url("<?php echo plugin_dir_url(__FILE__); ?>css/public.css"); */
                @import url("<?php echo plugin_dir_url(__FILE__); ?>css/custom.css");
            </style>


            <!-- begin -->
            <div class="kv-widget-wrapper" id="kv-widget" itemprop="itemReviewed" itemscope="" itemtype="https://schema.org/Organization">
                <meta itemprop="name" content="<?php echo get_bloginfo('name')?>">
                <meta itemprop="url" content="<?php echo get_bloginfo('url')?>">
                <div class="row" itemprop="aggregateRating" itemscope="itemscope" itemtype="http://schema.org/AggregateRating">
                    <meta itemprop="worstRating" content="1">
                    <meta itemprop="bestRating" content="<?php echo $maxrating; ?>">
                    <meta itemprop="ratingcount" content="<?php echo $reviews; ?>">
                    <div class="left">
                        <div class="score_container" style="background: url(<?php echo plugin_dir_url(__FILE__); ?>img/kv_shape.svg);">
                            <div class="score"><span itemprop="ratingValue"><?php echo $rating; ?><span></div>
                        </div>

                        <div class="starrating">
                            <ul>
                                <?php 
                                    $rating = $rating/2;
                                    for($i=0; $i<5; $i++) {
                                        echo "<li>";
                                        echo '<?xml version="1.0" encoding="utf-8"?>';
                                        echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
                                        echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">';
                                        
                                        if($rating >= 1) {
                                            // full star 
                                            echo '<g><path d="M500,34l151.4,306.8L990,390L745,628.8L802.8,966L500,806.8L197.2,966L255,628.8L10,390l338.6-49.2L500,34z"/><path d="M198.6,963.5l57.5-335.1L12.6,391l336.5-48.9L499.6,37.3v768L198.6,963.5z"/></g>';
                                        } elseif($rating >= 0.33) {
                                            //half star
                                            echo '<g><path d="M803.6,966.7L499.2,825.4L196.4,966.7l41.9-333.9L10,392.1l9.3-4.7c10.9-4.7,257.8-51.3,316.8-62.1c21.7-38.8,155.3-281.1,155.3-281.1l7.8-10.9l163.1,293.5L990,390.5L760.1,634.3L803.6,966.7z M38,399.8l215.9,228.3L215,940.3l284.2-132L785,941.9l-40.4-312.2l215.9-229.9L653,339.3l-1.6-3.1L499.2,64.4c-28,51.3-138.2,250-150.6,271.8l-1.6,3.1h-3.1C236.8,361,83,390.5,38,399.8z"/><path d="M499.2,48.8v767.2L205.7,954.3l40.4-323L24,395.2L342.4,333L499.2,48.8z"/></g>';
                                        } else {
                                            //empty star
                                            echo '<g><g><path d="M990,390l-338.6-49.2L500,34L348.6,340.8L10,390l245,238.8L197.2,966L500,806.8L802.8,966L745,628.8L990,390z M500,731.1L286.1,843.6L327,605.4L154,436.8L393.1,402L500,185.4L606.9,402L846,436.8L673,605.4l40.8,238.1L500,731.1z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></g>';
                                        }
                                        $rating--;

                                        echo '</svg>';
                                        echo "</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="right">
                        <p class="kiyoh">Kiyoh</p>
                        <div class="rating" ><?php echo sprintf(__('out of %s, based on', 'kiyoh-customerreview'), $reviews) ?><?php echo __('customer reviews', 'kiyoh-customerreview'); ?></div>
                    </div>
                </div>
            </div>

            <!-- einde -->

            <script>
                //sets small class to small sized widget
                var kvWidget = document.querySelector("#kv-widget");
                if(kvWidget.clientWidth < 320) {
                    kvWidget.classList.add("small");
                }
            </script>




	        <!-- <div class="kiyoh-shop-snippets">
                <div class="rating-box">
                    <div class="rating" style="width:<?php echo $rating_percentage; ?>%"></div>
                </div>
                <div class="kiyoh-schema" itemprop="itemReviewed" itemscope="" itemtype="https://schema.org/Organization">
                    <meta itemprop="name" content="<?php echo get_bloginfo('name')?>">
                    <meta itemprop="url" content="<?php echo get_bloginfo('url')?>">
                    <div itemprop="aggregateRating" itemscope="itemscope" itemtype="http://schema.org/AggregateRating">
                        <meta itemprop="worstRating" content="1">
                        <meta itemprop="bestRating" content="<?php echo $maxrating; ?>">
                        <p>
                            <a href="<?php echo $url; ?>" target="_blank" class="kiyoh-link">
                                <?php echo __('Rating', 'kiyoh-customerreview') ?> <span
                                    itemprop="ratingValue"><?php echo $rating; ?></span> <?php echo sprintf(__('out of %s, based on', 'kiyoh-customerreview'), $maxrating) ?>
                                <span
                                    itemprop="ratingCount"><?php echo $reviews; ?></span> <?php echo __('customer reviews', 'kiyoh-customerreview'); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div> -->
            



	        <?php echo $args['after_widget']; ?>
        <?php endif;
    }

    public function widget_old($args, $instance)
    {
        extract($args);
        $link_rate = $instance['link_rate'];
        $width = $instance['width'];
        $height = $instance['height'];
        $ssl = $instance['ssl'];
        $border = $instance['border'];
        $language = $instance['language'];


        if ($language == "English") {
            $language = ($language == "English") ? 'com' : 'nl';
        }
        $ssl = ($ssl == 'On') ? '' : '&usessl=0';
        $border = ($border == 'On') ? '' : '&border=0';
        echo '<iframe scrolling="no" src="' . $link_rate . $border . $ssl . '" width="' . $width . '" height="' . $height . '" border="0" frameborder="0"></iframe>';
    }

    public function form($instance)
    {
        $method = kiyoh_getOption('kiyoh_option_send_method');
        if ($method == 'kiyoh') {
            $this->form_new($instance);
        } else {
            $this->form_old($instance);
        }
    }

    public function form_new($instance)
    {
        $company_id = (isset($instance['company_id'])) ? $instance['company_id'] : '';
        $server = kiyoh_getOption('kiyoh_option_server');
        if($server=='klantenvertellen.nl' || $server=='newkiyoh.com'){?>
            <p> </p>
            <?php
        } else {
            ?>
            <p style="padding: 0 0 10px;">
                <label
                    for="<?php echo $this->get_field_id('company_id'); ?>"><?php echo __('Company Id', 'kiyoh-customerreview'); ?></label>
                <input id="<?php echo $this->get_field_id('company_id'); ?>"
                       name="<?php echo $this->get_field_name('company_id'); ?>"
                       value="<?php echo esc_attr($company_id); ?>" type="text" style="width:100%;" required/><br>
                <span><?php echo __('Enter here your "Company Id" as registered in your KiyOh account.', 'kiyoh-customerreview'); ?></span>
            </p>
            <?php
        }
    }

    public function form_old($instance)
    {
        $link_rate = (isset($instance['link_rate'])) ? $instance['link_rate'] : '';
        $width = (isset($instance['width'])) ? $instance['width'] : 210;
        $height = (isset($instance['height'])) ? $instance['height'] : 217;
        $ssl = (isset($instance['ssl'])) ? $instance['ssl'] : "On";
        $border = (isset($instance['border'])) ? $instance['border'] : "On";
        $language = (isset($instance['language'])) ? $instance['language'] : 'English';
        ?>
        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('link_rate'); ?>">Link rate</label>
            <input id="<?php echo $this->get_field_id('link_rate'); ?>"
                   name="<?php echo $this->get_field_name('link_rate'); ?>" value="<?php echo esc_attr($link_rate); ?>"
                   type="text" style="width:100%;"/><br>
        </p>
        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('width'); ?>">Width(px)</label>
            <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>"
                   value="<?php echo esc_attr($width); ?>" type="text" style="width:100%;"/><br>
        </p>
        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('height'); ?>">Height(px)</label>
            <input id="<?php echo $this->get_field_id('height'); ?>"
                   name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr($height); ?>"
                   type="text" style="width:100%;"/><br>
        </p>

        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('ssl'); ?>">SSL</label>
            <select id="<?php echo $this->get_field_id("ssl"); ?>" name="<?php echo $this->get_field_name("ssl"); ?>">
                <option value="On"<?php selected($instance["ssl"], "On"); ?>>On</option>
                <option value="Off"<?php selected($instance["ssl"], "Off"); ?>>Off</option>
            </select>
        </p>
        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('border'); ?>">Border</label>
            <select id="<?php echo $this->get_field_id("border"); ?>"
                    name="<?php echo $this->get_field_name("border"); ?>">
                <option value="On"<?php selected($instance["border"], "On"); ?>>On</option>
                <option value="Off"<?php selected($instance["border"], "Off"); ?>>Off</option>
            </select>
        </p>
        <p style="padding: 0 0 10px;">
            <label for="<?php echo $this->get_field_id('language'); ?>">Language</label>
            <select id="<?php echo $this->get_field_id("language"); ?>"
                    name="<?php echo $this->get_field_name("language"); ?>">
                <option value="English"<?php selected($instance["language"], "English"); ?>>English</option>
                <option value="Dutch"<?php selected($instance["language"], "Dutch"); ?>>Dutch</option>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['link_rate'] = strip_tags($new_instance['link_rate']);
        $instance['width'] = strip_tags($new_instance['width']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['ssl'] = strip_tags($new_instance['ssl']);
        $instance['border'] = strip_tags($new_instance['border']);
        $instance['language'] = strip_tags($new_instance['language']);
        $instance['company_id'] = strip_tags($new_instance['company_id']);
        return $instance;
    }

    public function receiveDataNow($instance)
    {
        $company_id = '';
        if(isset($instance['company_id'])){
            $company_id = $instance['company_id'];
        }
        $kiyoh_connector = kiyoh_getOption('kiyoh_option_connector');
        $kiyoh_server = kiyoh_getOption('kiyoh_option_server');
        $args = array('timeout'=>1);
        $file = 'https://www.' . $kiyoh_server . '/xml/recent_company_reviews.xml?connectorcode=' . $kiyoh_connector . '&company_id=' . $company_id;
        if($kiyoh_server=='klantenvertellen.nl' || $kiyoh_server=='newkiyoh.com'){
            $server = 'klantenvertellen.nl';
            if ($kiyoh_server=='newkiyoh.com'){
                $server = 'kiyoh.com';
            }
            $location_id = kiyoh_getOption('Klantenvertellen_option_locationId');
            $hash = kiyoh_getOption('Klantenvertellen_option_hash');
            $file = "https://{$server}/v1/publication/review/external/location/statistics?locationId=" . $location_id;
            $args = array_merge($args,array('headers' => array(
                'X-Publication-Api-Token'=> $hash )));
        }

        $output = wp_remote_get($file,$args);

        if (is_array($output) && $output['body'] != "Too many requests. Please try again later.") {
            update_option('kiyoh_cache_con_data', $output['body']);
        }
    }

    public function receiveData($instance)
    {
        $data = get_option('kiyoh_cache_con_data');
        $datajson = json_decode($data,true);
        if ( empty($data) || !$datajson) {
            $this->receiveDataNow($instance);
            $data = get_option('kiyoh_cache_con_data');
        }

        $time = get_option('kiyoh_cache_con_update');

        if ((time() - $time) > 600) {
            wp_schedule_single_event(time() + 10, 'receiveDataCron_event', array('instance'=>$instance));
            update_option('kiyoh_cache_con_update', time());
        }

        try {
            $sever = kiyoh_getOption('kiyoh_option_server');
            if ($sever=='klantenvertellen.nl' || $sever=='newkiyoh.com'){
                $datajson = json_decode($data,true);
                if (!$datajson || ($datajson && !isset($datajson['averageRating']))){
                    throw new \Exception('incorrect review response');
                }
                $dataxml = new StdClass();
                $company = new StdClass();
                $company->total_score = $datajson['averageRating'];
                $company->url = $datajson['viewReviewUrl'];
                $company->total_reviews = $datajson['numberReviews'];
                $dataxml->company = $company;
            } else {
                if (is_array($data)) {
                    if (isset($data['body'])) {
                        $data = $data['body'];
                    } else {
                        $data = '';
                    }
                }
                $dataxml = simplexml_load_string($data);
            }
        } catch (Exception $e) {
            $dataxml = '';
            update_option('kiyoh_cache_con_update', '0');
            update_option('kiyoh_cache_con_data', '');
        }

        return $dataxml;
    }

    public function copyRatingSprite()
    {
        $upload_dir = wp_upload_dir();
        $dest = $upload_dir['basedir'] . '/rating-sprite.png';
        if (!file_exists($dest)) {
            $source = plugin_dir_path(__FILE__) . 'img/rating-sprite.png';
            copy($source, $dest);
            chmod($dest, '644');
        }
    }
}
