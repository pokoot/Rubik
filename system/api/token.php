<?php  if ( !defined("BASE_PATH")) exit("No direct script access allowed");

/**
 * Request and validates a token
 *
 * @uses Api
 * @package
 * @version $id$
 * @author Kim
 * @license Cellcity
 */
class Token extends Api {

    protected $secure = false;
    protected $required = array( "time" , "auth_key" , "module" , "udid"  );
    protected $model;
    protected $library;
    protected $language;
    protected $vendor;


    /**
     * Get the post parameters
     *
     * @access public
     * @return void
     */
    public function request(){
        $this->request["module"]        = post( "module" );
        $this->request["time"]          = post( "time" );
        $this->request["udid"]          = post( "udid" );
        $this->request["auth_key"]      = post( "auth_key" );
        $this->request["debug"]         = post( "debug" );

        debug_array( $this->request );

    }



    /**
     * Validate the key
     *
     * @access public
     * @return void
     */
    public function validate(){

        $error              = false;
        $error_code         = "400";
        $status_code        = $this->response["status"]["code"];
        $app_secret_key    = SHA1( MD5( SITE_KEY ) );

        $auth_key           = $this->request["auth_key"];
        $time               = $this->request["time"];
        $udid               = $this->request["udid"];

        // check if time is same as the time parameter being passed
        if( $time != $this->request["time"] ){
             return $this->error();
        }

        // check for 24 hours validity
        if( $time >= time() + ( 24 * 60  * 60 ) ){
            return $this->error();
        }


        $created_auth_key = MD5( $time . $app_secret_key . $udid );


        // check if the value is the same as the hash key
        if( $auth_key !== $created_auth_key ){

            return $this->error();
        }

        return true;
    }




    /**
     * Shows the erros message
     *
     * @access public
     * @return void
     */
    public function error(){

        $status = $this->get_status( "BAD_KEY" );

        $this->response["status"] = array(
            "code"      => $status["code"] ,
            "message"   => $status["message"]
        );


        return false;

    }




    /**
     * Renders the api
     *
     * @access public
     * @param mixed $datas
     * @return void
     */
    public function index(){

        $this->request();

        $valid = $this->validate();

        debug( "valid = $valid ");
        debug( "status code = " . $this->response["status"]["code"]  );

        if( $valid === true ){

            $token = token_create();
            debug( "token = $token " );

            $this->response["data"] = array( "token" => $token );
        }

        $this->show();
    }

}

?>
