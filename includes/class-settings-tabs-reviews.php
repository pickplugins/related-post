<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

if( ! class_exists( 'settings_tabs_reviews' ) ) {
    class settings_tabs_reviews{

        public  $title = 'Related post';

        public function __construct(){
            add_action('admin_footer', array($this, 'display_popup'));

        }



        function display_popup(){

            wp_enqueue_style('font-awesome-5');

            $related_post_info = get_option('related_post_info');
            $review_status = isset($related_post_info['review_status']) ? $related_post_info['review_status'] : '';
            $remind_date = isset($related_post_info['remind_date']) ? $related_post_info['remind_date'] : '';

            $admin_url = get_admin_url();

            $gmt_offset = get_option('gmt_offset');
            $today_date = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));


            if(!empty($review_status)){
                if($review_status == 'done'){ return;}
                if($review_status == 'remind_later' && (strtotime($today_date) < strtotime($remind_date)) ){ return;}

            }else{
                $related_post_info['review_status'] = 'remind_later';
                $related_post_info['remind_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));
                update_option('related_post_info', $related_post_info);

                return;
            }

            ?>
            <div class="settings-tabs-reviews">
                <div class="actions">
                    <span class="hide"><i class="fas fa-times"></i></span>

                </div>

                <div class="title">
                    Hope you enjoy <strong>Related Post</strong> plugin <i class="far fa-smile"></i>
                </div>

                <?php
                //echo '<pre>'.var_export(strtotime($today_date) > strtotime($remind_date), true).'</pre>';
                ?>

                <div class="content">
                    <p class="">We wish your 2 minutes to write your feedback about the related post plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

                    <a target="_blank" href="https://wordpress.org/support/plugin/related-post/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>
                    <a href="<?php echo wp_nonce_url($admin_url.'admin.php?page=related_post_settings&review_status=done', 'related_post_review_notice', '_wpnonce'); ?>" class="button"><i class="far fa-thumbs-up"></i> Already did</a>
                    <a  href="<?php echo wp_nonce_url($admin_url.'admin.php?page=related_post_settings&review_status=remind_later', 'related_post_review_notice', '_wpnonce'); ?>" class="button"><i class="far fa-bell"></i> Remind me later</a>

                    <p>Do you have any issue, please contact our support team by creating a support ticket.</p>
                    <a target="_blank" href="https://www.pickplugins.com/create-support-ticket/?ref=dashboard" class="button"><i class="far fa-question-circle"></i> Create support ticket</a> <a target="_blank" href="https://www.pickplugins.com/documentation/related-post/?ref=dashboard" class="button"><i class="far fa-file-code"></i> Documentation</a> <a target="_blank" href="https://www.pickplugins.com/documentation/related-post/tutorials/?ref=dashboard" class="button"><i class="fab fa-youtube"></i> Tutorials</a>
                </div>


            </div>

            <script>
                jQuery(document).ready(function($){
                    $(document).on('click', ".settings-tabs-reviews .hide", function() {
                        $(this).parent().parent().fadeOut();
                    })
                })
            </script>

            <style type="text/css">
                .settings-tabs-reviews{
                    position: fixed;
                    right: 15px;
                    bottom: 15px;
                    width: 500px;
                    background: #fff;
                    padding: 0px;
                    box-shadow: 0 0 6px 3px rgba(183, 183, 183, 0.4);
                    z-index: 9999;
                    border: 1px solid #3f51b5;
                }

                .settings-tabs-reviews p{
                    font-size: 15px;
                }

                .settings-tabs-reviews .hide{
                    color: #fff;
                    padding: 2px 8px;
                    background: #e21d1d;
                    margin: 7px 4px;
                    display: inline-block;
                    cursor: pointer;
                }

                .settings-tabs-reviews .title{
                    font-size: 17px;
                    border-bottom: 1px solid #ddd;
                    padding: 10px;
                    background: #3F51B5;
                    color: #fff;
                }

                .settings-tabs-reviews .content{
                    padding: 10px;
                }

                .settings-tabs-reviews .actions{
                    position: absolute;
                    top: 0;
                    right: 0;
                }

                @media only screen and ( min-width: 0px ) and ( max-width: 767px ){
                    .settings-tabs-reviews{
                        width: 100%;
                        right: 0;
                        bottom: 0;
                    }
                }


            </style>
            <?php

        }

    }


}

new settings_tabs_reviews();