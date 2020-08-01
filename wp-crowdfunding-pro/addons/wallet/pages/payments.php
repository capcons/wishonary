<?php
defined('ABSPATH') || exit;

if ( ! empty($_GET['payment_campaign_id'])){
    include WPCF_WALLET_DIR_PATH.'pages/payment_details_by_campaign.php';
} else{
    include WPCF_WALLET_DIR_PATH.'pages/all_campaigns.php';
}