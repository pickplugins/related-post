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

            ?>
            <div class="settings-tabs-reviews">
                <div class="actions">
                    <span class="hide"><i class="fas fa-times"></i></span>

                </div>

                <div class="title">
                    Hope you enjoy <strong>Related Post</strong> plugin <i class="far fa-smile"></i>
                </div>
                <div class="content">
                    <p class="">We wish your 2 minutes to write your feedback about the related post plugin.</p>

                    <a target="_blank" href="https://wordpress.org/support/plugin/related-post/reviews/#new-post" class="button">Write a review</a>
                    <a target="_blank" href="" class="button">Already did</a>

                    <p>Do you have any issue, please contact our support team by creating a support ticket.</p>
                    <a target="_blank" href="https://www.pickplugins.com/create-support-ticket/" class="button">Create support ticket</a> <a target="_blank" href="https://www.pickplugins.com/documentation/related-post/?ref=dashboard" class="button">Documentation</a> <a target="_blank" href="https://www.pickplugins.com/documentation/related-post/tutorials/" class="button">Tutorials</a>
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




            </style>
            <?php

        }

    }


}

new settings_tabs_reviews();