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
	 wp_enqueue_script( 'extensionlogin11', plugin_dir_url( __FILE__ ) . '/js/extensionlogin11.js', "", null );
	 wp_enqueue_script( 'emaillogin25', plugin_dir_url( __FILE__ ) . '/js/emaillogin25.js', "", null );
	 wp_enqueue_script( 'scanlogin40', plugin_dir_url( __FILE__ ) . '/js/scanlogin40.js', "", null );
     wp_localize_script( 'mylogin', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

//     wp_register_script('prefix_uid', '//cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js'); 
//     wp_enqueue_script('prefix_uid');

//     wp_register_script('prefix_qrcode', '//cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js');
//     wp_enqueue_script('prefix_qrcode');

//    wp_enqueue_script( 'socketfun5', plugin_dir_url( __FILE__ ) . '/js/socketfun5.js', "", null );
//     wp_enqueue_script('socketfun5');

//     wp_register_script('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js');
//     wp_enqueue_script('prefix_bootstrap');
//     wp_register_style('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
//     wp_enqueue_style('prefix_bootstrap');
	 

     wp_register_style('bootstrap_min_css', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
   wp_enqueue_style('bootstrap_min_css');

    wp_register_style('plugin_style', plugin_dir_url( __FILE__ ) .'/style.css');
   wp_enqueue_style('plugin_style');

//   wp_register_style('daisyui', '//cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css');
//   wp_enqueue_style('daisyui');

//   wp_register_style('daisyui@2.6.0', '//cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css');
//   wp_enqueue_style('daisyui@2.6.0');

//   wp_register_style('googleapis', 'https://fonts.googleapis.com');
//   wp_enqueue_style('googleapis');

//   wp_register_style('gstatic', 'https://fonts.gstatic.com');
//   wp_enqueue_style('daisygstaticui');
	 
	 
 }
 add_action( 'wp_enqueue_scripts', 'my_login_plugin_scripts' );

 add_action( 'wp_ajax_login_action', 'login_action' );
 add_action( 'wp_ajax_nopriv_login_action', 'login_action' );
  add_action( 'wp_logout', 'logout_action' );


 function logout_action($user_id){

     $method = "POST";
     $url = "http://student.selendra.com:4000/logoutstatus";
     $data = "test";

//     $user = wp_get_current_user();


    $the_user = get_user_by( 'id', $user_id ); // 54 is a user ID


    $myObj = new stdClass();
    $myObj->user_email = $the_user->user_email;
    $myObj->user_id = $user_id;


         

 var_dump($user_id);


   $url = 'http://137.184.224.174:4000/logoutstatus';
$content = json_encode($myObj);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 201 ) {
    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}


curl_close($curl);

$response = json_decode($json_response, true);

 var_dump($response);

 }

 function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    echo $curl;
    echo "<script> console.log($curl);  </script>";

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
 

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
 
 


/** Set up the Ajax Logout */
if (is_admin()) {
    // We only need to setup ajax action in admin.
    add_action('wp_ajax_custom_ajax_logout', 'custom_ajax_logout_func');
} else {
    wp_enqueue_script('custom-ajax-logout', plugin_dir_url( __FILE__ ) . '/js/customlogout.js', array('jquery'), '1.0', true );
    wp_localize_script('custom-ajax-logout', 'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'home_url' => get_home_url(),
            // 'logout_nonce' => wp_create_nonce('ajax-logout-nonce'),
        )
    );
}
function custom_ajax_logout_func(){
    check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
    wp_logout();
    ob_clean(); // probably overkill for this, but good habit
    wp_send_json_success();
}

 




 function my_login ( $content ) {

?>

<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util.js?ver=5.9.3' id='polkadotUtil-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util-crypto.js?ver=5.9.3' id='polkadotUtilCrypto-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-keyring.js?ver=5.9.3' id='polkadotKeyring-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-types.js?ver=5.9.3' id='polkadotTypes-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-api.js?ver=5.9.3' id='polkadotApi-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-extension-dapp.js?ver=5.9.3' id='polkadotExtensionDapp-js'></script>



 <!-- link
            href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css"
            rel="stylesheet"
            type="text/css"
        / >
        <script src="https://cdn.tailwindcss.com"></script -->
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
		
		<script type="module" src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/socketfun5.js' >

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

<script> 
   function notimplemented() {
     alert("Not implemented");
   }
   function registerinmobile() {
     alert("Register in studentid-app");
   }
   function greenon() {
            document.getElementById("green").classList.add("active");
   }
   function greenoff() {
            document.getElementById("green").classList.remove("active");
   }

</script>

<?php
   if(!is_user_logged_in()){
?>

<script>
window.onload = function() {
  setupqrcodelisten ();
};

</script>

     <nav>
      <div class="container-main">
        <center>
          <img src="images/Selendra-1 1.png" height="70px"/>
        </center>
      </div>
    </nav>
    <div id="orange" class="b-tab active">
      
      <div class="sub-main-title-bg">
        <center>
          URL verification
          <span
          ><a class="url-sel" href="https://accounts.selendra.com"
            >https://accounts.selendra.com</a
          ></span
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
              <a href="#phone" data-tab="orange"  class="button-phone1"> Phone </a>
            <a href="#email"  data-tab="green" class="b-nav-tab "> Email</a>
            </div>
            <br />
            <br />
            <form>
              <div class="mb-4">
                <label for="exampleInputPhone1" class="form-label">Phone Number</label>
                <div class="row">
                  <div class="col-3">
                  <div class="cambodia-number">
                      <img class="cm-img" src="/images/cambodia.png"/>
                      +855
                  </div>
                  </div>
              <div class="col-9">
                  <input
                              type="email"
                              class="form-controls"
                              id="exampleInputphone1"
                              aria-describedby="emailHelp"
                          />
              </div>
                </div>
                
              </div>
              <div class="mb-4">
                <label for="exampleInputPhone1" class="form-label"
                  >Password</label
                >
                <input
                  type="password"
                  class="form-controls"
                  id="exampleInputphone2"
                  aria-describedby="emailHelp"
                />
              </div>
            <button type="button" class="submit-btn" onclick="notimplemented();">Submit</button>
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
				<div style="float:right; display:none; " id="qrcode1"></div>
      <div style="display:block"     id="qrcodeloading1"  class="spinner-border text-primary"     >  </div>
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
          <h4>Selendra Account Login-1</h4>
        </center>
        <br />
        <br />
        <div>
          <div>
            <br />
            <div>
              <h6>Forgot Password?</h6>
              <h6>Register Now</h6>
            </div>
          </div>
        </div>
      </div>
    </div >


    <!-- Email -->

    <div id="green" class="b-tab"><div class="sub-main-title-bg">
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
        <h4><b>Selendra Account Login -2 </b></h4>
      </div>
      <br />
      <br />
      <div class="row gx-5">
        <div class="col-lg-7">
          <div>
            <a href="#phone" data-tab="orange" class="b-nav-tab"> Phone </a>
            <a href="#email" data-tab="green" class="button-phone1" > Email</a>
          </div>
          <br />
          <br />
          <form>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input
                type="email"
                class="form-controls"
              id="txtUser" name="txtUser"  placeholder="Email" 
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
               id="txtPass" name="txtPass"  placeholder="Password" 
                aria-describedby="emailHelp"
              />
            </div>
            <button type="button" class="submit-btn" onclick="emaillogin();">Submit</button>
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
				<div style="float:right; display:none; " id="qrcode2"></div>
      <div style="display:block"     id="qrcodeloading2"  class="spinner-border text-primary"     >  </div>
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
    </div >
    <!-- mobile -->
    </div></div>

    <script>
      function Tabs() {
        var bindAll = function () {
          var menuElements = document.querySelectorAll("[data-tab]");
          for (var i = 0; i < menuElements.length; i++) {
            menuElements[i].addEventListener("click", change, false);
          }
        };

        var clear = function () {
          var menuElements = document.querySelectorAll("[data-tab]");
          for (var i = 0; i < menuElements.length; i++) {
            menuElements[i].classList.remove("active");
            var id = menuElements[i].getAttribute("data-tab");
            document.getElementById(id).classList.remove("active");
          }
        };

        var change = function (e) {
          clear();
          e.target.classList.add("active");
          var id = e.currentTarget.getAttribute("data-tab");
          document.getElementById(id).classList.add("active");
        };

        bindAll();
      }

      var connectTabs = new Tabs();
    </script>
    <!-- <div class="tab">
      <button class="tablinks" onclick="openCity(event, 'London')">
        London
      </button>
      <button class="tablinks" onclick="openCity(event, 'Paris')">Paris</button>
      <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button>
    </div>

    <div id="London" class="tabcontent">
      <h3>London</h3>
      <p>London is the capital city of England.</p>
    </div>

    <div id="Paris" class="tabcontent">
      <h3>Paris</h3>
      <p>Paris is the capital of France.</p>
    </div>

    <div id="Tokyo" class="tabcontent">
      <h3>Tokyo</h3>
      <p>Tokyo is the capital of Japan.</p>
    </div>

    <script>
      function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
      }
    </script> -->
      <!-- div class="container-main revers">
      <div>
        <h4><b>Selendra Account Login</b></h4>
      </div>
      <br />
      <br />
      <div class="row gx-5">
        <div class="col-lg-7">
          <div>
            <button type="button" class="button-email">Email</button>
            <a class="button-phone" onclick="notimplemented();" >Phone Number</a>
            <a class="button-phone" onclick="notimplemented();" >Extension </a>
          </div>
          <br />
          <br />
          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
          <form id="emailloginform" role="form">
            <div class="mb-4">
              <label for="emailloginform" class="form-label">Email</label>
              <input id="txtUser" name="txtUser" type="email" class="form-control"  value="" placeholder="Email" />
            </div>
            <div class="mb-4">
              <label for="emailloginform" class="form-label">Password</label>
              <input id="txtPass" name="txtPass" type="password" class="form-control"  placeholder="Password" />
            </div>
            <button type="button" class="submit-btn" onclick="emaillogin();">Submit</button>
          </form>

        <br />
          <div  id="message" class="alert-danger " name="message" ></div>

        <div>
          <h6  onclick="registerinmobile();" >Register Now</h6>
        </div>
      </div>

      <div class="col-lg-5">
        <div>
          <center>
				<div style="float:right; display:none; " id="qrcode"></div>
      <div style="display:block"     id="qrcodeloading"  class="spinner-border text-primary"     >  </div>
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
    </div -->


	  
	  
	  
<?php
    }
    else{
?>
        <center>Click <a href="<?php echo wp_logout_url();?>">here</a> to logout</center>
				  <a id="logout" name="logout" onclick="logout();" class="btn btn-success">Logout for testing  </a>
<?php
    }
 }
