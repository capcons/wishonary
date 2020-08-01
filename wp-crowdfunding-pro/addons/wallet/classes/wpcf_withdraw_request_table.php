<?php
defined('ABSPATH') || exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WPCF_Withdraw_Request_Table extends WP_List_Table {
    public function __construct() {
        parent::__construct( array(
            'ajax' 		=> true
        ));
        $this->wpcf_withdraw_data_items();
        $this->display();
    }

    function get_columns() {
        $columns = array(
            'tid'    			=> __( 'ID' , 'wp-crowdfunding-pro' ),
            'title'     		=> __( 'Title' , 'wp-crowdfunding-pro' ),
            'user'   			=> __( 'User' , 'wp-crowdfunding-pro' ),
            'amount'	        => __( 'Amount' , 'wp-crowdfunding-pro' ),
            //'method'	        => __( 'Method' , 'wp-crowdfunding-pro' ),
            'fund_collection'   => __( 'Fund Raised (%)' , 'wp-crowdfunding-pro' ),
            'fund_goal'   		=> __( 'Fund Goal' , 'wp-crowdfunding-pro' ),
            'campaign_type'   	=> __( 'Campaign Type' , 'wp-crowdfunding-pro' ),
            'action'   			=> __( 'Action' , 'wp-crowdfunding-pro' ),
        );
        return $columns;
    }

    function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'tid':
            case 'title':
            case 'user':
            case 'amount':
            //case 'method':
            case 'fund_collection':
            case 'fund_goal':
            case 'campaign_type':
            case 'action':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    function wpcf_withdraw_data_items() {

        $currentPage 	= $this->get_pagenum();
        if( isset($_GET['paged']) ){ $page_numb = $_GET['paged']; }
        $example_data 	= array();
        $perPage 		= 10;
        $args 			= array(
            'post_type'         => 'wpneo_withdraw',
            'post_status'       => array( 'publish' ),
            'posts_per_page'    => $perPage,
            'paged'				=> $currentPage
        );
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) :
            while ( $the_query->have_posts() ) : $the_query->the_post();
                global $post;

                //$post_id 	= get_post_meta( get_the_ID(),'withdraw_post_id',true );
                // Author Name
                $fname 		= get_the_author_meta('first_name');
                $lname 		= get_the_author_meta('last_name');
                $full_name 	= '';
                if( empty($fname)){ $full_name = $lname; }
                    elseif( empty( $lname )){ $full_name = $fname;
                } else {  $full_name = "{$fname} {$lname}"; }

                $raised_percent 	= wpcf_function()->get_raised_percent( $post->post_parent ); // Raised Percent
                $fund_raised  		= wpcf_function()->fund_raised( $post->post_parent );
                $fund_raised 		= $fund_raised ? wc_price($fund_raised) : wc_price(0); // Fund Raised
                $funding_goal 		= wc_price(get_post_meta( $post->post_parent, '_nf_funding_goal', true)); // Funding Goal

                $method 		= '';
                $campaign_end 	= get_post_meta( $post->post_parent, 'wpneo_campaign_end_method' , true);
                if( $campaign_end 		== 'target_goal' ){ $method = __('Target Goal','wp-crowdfunding-pro'); }
                elseif( $campaign_end 	== 'target_date' ){ $method = __('Target Date','wp-crowdfunding-pro'); }
                elseif( $campaign_end 	== 'target_goal_and_date' ){ $method = __('Target Goal and Date','wp-crowdfunding-pro'); }
                elseif( $campaign_end 	== 'never_end' ){ $method = __('Campaign Never End','wp-crowdfunding-pro'); }

                // Message
                $message = strip_tags( get_the_content() );
                if( $message != '' ){
                    $message = '<button class="label-default wpcf-message">'.__('Message', 'wp-crowdfunding-pro').'</button><div id="light" class="wpcf-message-content">' . $message .'<span class="wpcf-message-close">'.__("close","wp-crowdfunding").'</span>';
                }

                // Paid & Pending
                $request 	= get_post_meta( get_the_ID(),'withdraw_request_status',true );
                if( $request == 'paid' ){
                    $request = '<button class="label-success wpneo-request-pending" data-post-id="'.get_the_ID().'">'.__("Decline","wp-crowdfunding").'</button>';
                } else {
                    $request = '<button class="label-warning wpneo-request-paid" data-post-id="'.get_the_ID().'">'.__("Approve","wp-crowdfunding").'</button>';
                }

                $amount = get_post_meta(get_the_ID(), 'wpneo_wallet_withdrawal_amount', true);
                /* $withdraw_method = get_post_meta(get_the_ID(), 'wpneo_wallet_withdrawal_method', true);
                $withdraw_method_btn = '';
                if( !empty($withdraw_method) ) {
                    $withdraw_method = json_decode( $withdraw_method );
                    $method_details = '';
                    foreach( $withdraw_method as $key => $value ) {
                        $method_details .= '<p>'.ucwords(str_replace("_", " ", $key)).': '.$value;
                    } 
                    $withdraw_method_btn = '<button class="label-default wpcf-message">'.__($withdraw_method->method_name, 'wp-crowdfunding-pro').'</button><div id="light" class="wpcf-message-content">' . $method_details .'<span class="wpcf-message-close">'.__("close","wp-crowdfunding").'</span>';
                } */
                $arr = array(
                    'tid'				=> $post->post_parent,
                    'title'				=> '<a href="'.get_permalink($post->post_parent).'">'.get_the_title().'</a>',
                    'user'				=> '<a href="#">'.$full_name.'</a>',
                    'amount'	        => wc_price($amount),
                    //'method'	        => $withdraw_method_btn,
                    'fund_collection'	=> '<span class="label-info">'.$fund_raised. '('.$raised_percent.'%) </span>',
                    'fund_goal'			=> '<span class="label-success">'.$funding_goal.'</span>',
                    'campaign_type'		=> $method,
                    'action'			=> $request.' '.$message.'</div>',
                );
                $example_data[] = $arr;
            endwhile;

            wp_reset_postdata();
        else:
            echo "<p>".__( 'Sorry, no withdraw request found.','wp-crowdfunding-pro' )."</p>";
        endif;

        $columns 		= $this->get_columns();
        $hidden 		= array();
        $sortable 		= $this->get_sortable_columns();
        $totalItems 	= count($example_data);
        $this->set_pagination_args( array(
            'total_pages' 	=> $the_query->max_num_pages,
            'per_page'    	=> $perPage
        ) );
        $data 			= array_slice($example_data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items 	= $example_data;
    }
}
