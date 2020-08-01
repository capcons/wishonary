<?php
/**
 * Sends requests to the Authorize.Net gateways.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetRequest
 */
abstract class AuthorizeNetRequest {
    
    protected $_api_login;
    protected $_transaction_key;
    protected $_post_data; 
    public $VERIFY_PEER = true; // attempt trust validation of SSL certificates when establishing secure connections.
    protected $_sandbox = true;
    protected $_logger = null;
    
    
    /**
     * Set the _setPostData
     */
    abstract protected function _setPostData();
    
    /**
     * Handle the response string
     */
    abstract protected function _handleResponse($string);
    
    /**
     * Get the post url. We need this because until 5.3 you
     * you could not access child constants in a parent class.
     */
    abstract protected function _getPostUrl();
    
    /**
     * Constructor.
     *
     * @param string $api_login_id       The Merchant's API Login ID.
     * @param string $transaction_key The Merchant's Transaction Key.
     */
    public function __construct($api_login_id = false, $transaction_key = false) {
        $this->_api_login = ($api_login_id ? $api_login_id : (defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID : ""));
        $this->_transaction_key = ($transaction_key ? $transaction_key : (defined('AUTHORIZENET_TRANSACTION_KEY') ? AUTHORIZENET_TRANSACTION_KEY : ""));
        $this->_sandbox = (defined('AUTHORIZE_NET_SANDBOX') ? AUTHORIZE_NET_SANDBOX : true);
       // $this->_logger = LogFactory::getLog(get_class($this));
    }
    
    /**
     * Alter the gateway url.
     *
     * @param bool $bool Use the Sandbox.
     */
    public function setSandbox($bool) {
        $this->_sandbox = $bool;
    }
    
    /**
     * Set a log file.
     *
     * @param string $filepath Path to log file.
     */
    public function setLogFile($filepath) {
        $this->_logger->setLogFile($filepath);
    }
    
    /**
     * Posts the request to AuthorizeNet & returns response.
     *
     * @return AuthorizeNetARB_Response The response.
     */
    protected function _sendRequest() {
        $this->_setPostData();
        $post_url = $this->_getPostUrl();
        $curl_request = curl_init($post_url);
        curl_setopt($curl_request, CURLOPT_PORT, 443);
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl_request, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, http_build_query($this->_post_data, '', '&'));

        if ($this->VERIFY_PEER) {
            curl_setopt($curl_request, CURLOPT_CAINFO, dirname(dirname(__FILE__)) . '/ssl/cert.pem');
        } else {
            if ($this->_logger) {
                $this->_logger->error("----Request----\nInvalid SSL option\n");
            }
			return false;
        }
        
        $response = curl_exec($curl_request);
        
        if ($this->_logger) {
            if ($curl_error = curl_error($curl_request)) {
                $this->_logger->error("----CURL ERROR----\n$curl_error\n\n");
            }
            // Do not log requests that could contain CC info.
            $this->_logger->info("----Request----\n{$this->_post_data}\n");
            $this->_logger->info("----Response----\n$response\n\n");
        }
        curl_close($curl_request);
        
        return $this->_handleResponse($response);
    }
}
