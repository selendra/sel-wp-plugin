<?php
/**
 * Plugin Name: Wordpress Login
 * Description: This is an example WP Login
 * Version: 1.0.1
 * Author: Srirajan
 * Author URI:
 * License: GPL
 */
 add_action( 'my_login', 'my_login' );

 add_shortcode( 'my_login', 'my_login' );




 function my_login_plugin_scripts() {
     wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/jquery-3.6.0.min.js', array( 'jquery' ), '1.0.0', true );
     wp_enqueue_script( 'mylogin', plugin_dir_url( __FILE__ ) . '/js/mylogin.js' );
	 wp_enqueue_script( 'mytest', plugin_dir_url( __FILE__ ) . '/js/mytest.js' );
	 wp_enqueue_script( 'mnemoniclogin10', plugin_dir_url( __FILE__ ) . '/js/mnemoniclogin10.js', "", null );
	 wp_enqueue_script( 'extensionlogin09', plugin_dir_url( __FILE__ ) . '/js/extensionlogin09.js', "", null );
	 wp_enqueue_script( 'emaillogin18', plugin_dir_url( __FILE__ ) . '/js/emaillogin18.js', "", null );
	 wp_enqueue_script( 'scanlogin22', plugin_dir_url( __FILE__ ) . '/js/scanlogin22.js', "", null );
     wp_localize_script( 'mylogin', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

     wp_register_script('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
     wp_enqueue_script('prefix_bootstrap');
     wp_register_style('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
     wp_enqueue_style('prefix_bootstrap');
	 
	 
	 
 }
 add_action( 'wp_enqueue_scripts', 'my_login_plugin_scripts' );

 add_action( 'wp_ajax_login_action', 'login_action' );
 add_action( 'wp_ajax_nopriv_login_action', 'login_action' );

 function login_action(){
   //echo $_REQUEST['user']." : ".$_REQUEST['pass'];
   //$user = get_user_by('login', $_REQUEST['user'] );
   if ( $user = get_user_by('login', $_REQUEST['user'] ) )
   {
	 if ( $_REQUEST['decision'] == 'true' ) {
     wp_clear_auth_cookie();
     wp_set_current_user ( $user->ID );
     wp_set_auth_cookie  ( $user->ID );
     echo "Success";
	 }
   } 
   else if ( $_REQUEST['create'] == 'yes'){
	    
     $userdata = array(
        'user_login' =>  $_REQUEST['user'],
        'user_email' =>  $_REQUEST['user'],
        'user_pass'  =>  wp_hash_password( $_REQUEST['pass'] ) // When creating an user, `user_pass` is expected.
     );

     $user_id = wp_insert_user( $userdata ) ;

     $user = get_user_by('login', $_REQUEST['user']);
	 if ( $_REQUEST['decision'] == 'true' ) {
     wp_clear_auth_cookie();
     wp_set_current_user ( $user->ID );
     wp_set_auth_cookie  ( $user->ID );

	 echo "Success"; 
	 }
   } 
   
 }
 
 
 




 function my_login ( $content ) {
   if(!is_user_logged_in()){
?>

<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util.js?ver=5.9.3' id='polkadotUtil-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util-crypto.js?ver=5.9.3' id='polkadotUtilCrypto-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-keyring.js?ver=5.9.3' id='polkadotKeyring-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-types.js?ver=5.9.3' id='polkadotTypes-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-api.js?ver=5.9.3' id='polkadotApi-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-extension-dapp.js?ver=5.9.3' id='polkadotExtensionDapp-js'></script>


 <link
            href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css"
            rel="stylesheet"
            type="text/css"
        />
        <script src="https://cdn.tailwindcss.com"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"
            integrity="sha512-is1ls2rgwpFZyixqKFEExPHVUUL+pPkBEPw47s/6NDQ4n1m6T/ySeDW3p54jp45z2EJ0RSOgilqee1WhtelXfA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js"
            integrity="sha512-BCMqEPl2dokU3T/EFba7jrfL4FxgY6ryUh4rRC9feZw4yWUslZ3Uf/lPZ5/5UlEjn4prlQTRfIPYQkDrLCZJXA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
		
		<script type="module" src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/socketfun.js' >

        </script>


<script>


const { bnToBn, u8aToHex } = polkadotUtil;
const { sha256AsU8a, blake2AsHex, randomAsHex, selectableNetworks } = polkadotUtilCrypto;
const { Keyring } = polkadotKeyring;
const { cryptoWaitReady } = polkadotUtilCrypto;
const { ApiPromise, WsProvider } = polkadotApi; //require('@polkadot/api');
//const { Keyring } = require('@polkadot/keyring');
const { randomAsU8a, randomAsNumber, signatureVerify } = polkadotUtilCrypto; // require( '@polkadot/util-crypto');
const { stringToU8a, stringToHex, hexToString } = polkadotUtil;
const { web3Accounts, web3Enable, web3FromAddress,
  web3ListRpcProviders,
        web3FromSource,
  web3UseRpcProvider
 } = polkadotExtensionDapp ; 

 
</script>




<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./style.css" rel="stylesheet" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <title>Login</title>
  </head>
  <!-- Desktop SHow -->
  <body>
    <!-- =================Navbar================ -->
    <nav>
      <div class="container-main">
        <center>
          <img src="images/Selendra-1 1.png" height="70px" />
        </center>
      </div>
    </nav>

    <div class="sub-main-title-bg">
      <center>
        URL verification
        <span
          ><a class="url-sel" href="https://accounts.selendra.com"
            >https://accounts.selendra.com</a
          ></span
        >
      </center>
    </div>
    <br />
    <div class="container-main revers">
      <div>
        <h4><b>Selendra Account Login</b></h4>
      </div>
      <br />
      <br />
      <div class="row gx-5">
        <div class="col-lg-7">
          <div>
            <button type="button" class="button-email">Email</button>
            <a class="button-phone" href="/phonelogin.html">Phone Number</a>
          </div>
          <br />
          <br />
          <form>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input
                type="email"
                class="form-controls"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
            </div>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label"
                >Password</label
              >
              <input
                type="password"
                class="form-controls"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
            </div>
            <button type="button" class="submit-btn">Submit</button>
          </form>
          <br />
          <div>
            <h6>Forgot Password?</h6>
            <h6>Register Now</h6>
          </div>
        </div>

        <div class="col-lg-5">
          <div>
            <center>
              <div><img src="/images/qr.png" height="150" /></div>
              <br />
              <h6><b>Login with QR Code</b></h6>
              <br />
              <p>
                Scan this code with the
                <span class="url-sel">Bitriel mobile app</span> to log in
                instantly.
              </p>
            </center>
          </div>
        </div>
      </div>
    </div>
    <!-- mobile -->
    <div class="container-main revers-mobile">
      <center>
        <h4>Selendra Account Login</h4>
      </center>
      <br />
      <br />
      <div>
        <div>
          <center>
            <div><img src="/images/qr.png" height="150" /></div>
            <br />
            <h6><b>Login with QR Code</b></h6>
            <br />
            <p>
              Scan this code with the
              <span class="url-sel">Bitriel mobile app</span> to log in
              instantly.
            </p>
          </center>
        </div>
        <br />
        <br />
        <div>
          <div>
            <button type="button" class="button-email">Email</button>
            <a class="button-phone" href="/phonelogin.html">Phone Number</a>
          </div>
          <br />
          <br />
          <form>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input
                type="email"
                class="form-controls"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
            </div>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label"
                >Password</label
              >
              <input
                type="password"
                class="form-controls"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
            </div>
            <button type="button" class="submit-btn">Submit</button>
          </form>
          <br />
          <div>
            <h6>Forgot Password?</h6>
            <h6>Register Now</h6>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>




      <div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Email login</div>
                          <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="emailloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="txtUser" name="txtUser" type="email" class="form-control" name="username" value="" placeholder="Email">
                                </div>

                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input id="txtPass" name="txtPass" type="password" class="form-control" name="password" placeholder="Password">
                                </div>

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                      
                                      
									  
									  <a id="emailtxtSubmit" name="emailtxtSubmit" onclick="emaillogin();" class="btn btn-success">Login  </a>
                                    </div>
                                </div>
								<div id="message" name="message">
								
								</div>
								
                            </form>
                          </div>
                      </div>
          </div>
      </div>
	  
	  <div class="container" >
            
             <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">QRcode login</div>
                          
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="scanloginform" class="form-horizontal" role="form">
							 <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="scantxtUser" name="scantxtUser" type="email" class="form-control" name="scanusername" value="" placeholder="Email">
                                </div>
                                <div style="margin-bottom: 25px" class="input-group">
                                
				<div style="float:right; display:none; " id="qrcode"></div>
                </div>				
								</div>

								
                
				
           <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
									 <div class="col-sm-12 controls">
                                      
                                      
			  <a id="validatescanSubmit" name="validatescanSubmit" onclick="validatescanlogin();" class="btn btn-success">Validate user  </a>
                                    </div>
                                    <div class="col-sm-12 controls">
			  <a id="scanSubmit" style="display:none;" name="scanSubmit" onclick="simulatescan();" class="btn btn-success">Simulate scan  </a>
                                    </div>
                                </div>
								<div id="scanmessage" name="scanmessage">
								
								</div>
								</div>
                      </div>
        </div>
		
	  <!-- div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Mnemonic login</div>
                          
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="mneloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="Publickey" name="Publickey" type="text" class="form-control" name="Publickey" value="" placeholder="Publickey">
                                </div>

                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input id="txtMnemonic" name="txtMnemonic" type="text" class="form-control" name="Mnemonic" value="" placeholder="Mnemonic">
                                </div>

                                <div style="margin-top:10px" class="form-group">
                                    
                                    <div class="col-sm-12 controls">
                                                                           
									  
									  <a id="mneSubmit" name="mnetxtSubmit" onclick="menomoniclogin();" class="btn btn-success">Login  </a>
                                    </div>
                                </div>
								<div id="mnemessage" name="mnemessage">
								
								</div>
                            </form>
                          </div>
                      </div>
          </div>
      </div -->
	  
	   <div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Extension login</div>
                          
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="extloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="pubkeyinextension" name="pubkeyinextension" type="text" class="form-control" name="pubkeyinextension" value="" placeholder="External Publickey">
                                </div>
							<div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="extnemail" name="extnemail" type="email" class="form-control"  value="" placeholder="Extn Email">
                                </div>
                                

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                                                           
									  
									  <a id="extsubmit" name="exttxtSubmit" onclick="extensionlogin();" class="btn btn-success">Login  </a>
									  
                                    </div>
                                </div>
								<div id="extmessage" name="extmessage">
								
								</div>
								
                            </form>
                          </div>
                      </div>
          </div>
      </div>
	  
	  
	  
<?php
    }
    else{
?>
        <center>Click <a href="<?php echo wp_logout_url();?>">here</a> to logout</center>
<?php
    }
 }
