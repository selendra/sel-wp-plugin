
window.onload = function() {
  // run code
  setupqrcodelisten ();
};

 function loginQuery(user, pass, decision, create, accountstatus) {
 	
    jQuery.ajax({
           type:"POST",
           url: my_ajax_object.ajax_url,
           data: {
               action: "login_action",
               user: user, 
               pass : pass,
			   create: create? 'yes': 'no',
			   decision: decision? 'true': 'false',
           },
           success:function(data){
			   console.log(JSON.stringify(data));
			   if(accountstatus == 'noaccount')
			   {
				   if(create == 'yes') {
					   
				      jQuery('#scanmessage').html("Account not setup, cannot login");
				   } else {
					   jQuery('#scanmessage').html("Account not setup");
				   }
				   return;
			   }
			   if(decision == false){
				   jQuery('#scanmessage').html("Login wrong");
			   } else //if(data.indexOf('Success')!=-1)
			   {
                  
				  jQuery('#scanmessage').html("Login success");
				  window.location.reload();
               }
           },
		   error: function(msg) {  
                // login error.                 
                
                jQuery('#scanmessage').html("Login failed");
                
            }
    });
  }

 
async function simulatescan () {

    var email = document.getElementById('scantxtUser').value;
    var scanid = document.getElementById('scanid').value;

/*
    const provider = new WsProvider('wss://student.selendra.org');
    const api = await ApiPromise.create({ provider });
    let record = await api.query.identity.studentidOf(email);
    if(record.inspect().inner) {
    let recordp = JSON.parse(record);
    console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));
    
      if wallet-address matching recordp.accountId then validate success
    */

     
     var data = {id: scanid,
           email: email,
           pubkey: ''
     };

     ssocket.emit("/auth/qr-scan",  data );



}

async function validatescanlogin() {
   console.log(my_ajax_object.ajax_url);

   var loginsuccess = true;
	
   var email = document.getElementById('scantxtUser').value;
	

  
    const provider = new WsProvider('wss://student.selendra.org');
    const api = await ApiPromise.create({ provider });
  
   let record = await api.query.identity.studentidOf(email);
   console.log(record);
   
   // const  recordp = JSON.parse(record);
  
   //var passhash = recordp.info.passwordhash;

        
   //var hashtocompare = passhash.sha256;
    var logindecision = true;
    var create = false;
	

	// var givenpasshash = u8aToHex(sha256AsU8a(pass));
	 
	
   var accountstatus;
   
   if(record.inspect().inner) {
   let recordp = JSON.parse(record);
    console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));
    accountstatus = 'yesaccount';
    enableqrcode(email) ;
   }else {
    console.log("Email "+ email + "  not registered" );
    accountstatus = 'noaccount'; 
		create = false;
	alert(" email  not registered");
   }
  
   
	
	// loginQuery(email, "pass", logindecision, create, accountstatus);
	
	
}

function returnstatus(email) {

    var accountstatus = 'yesaccount';
    var logindecision = true;
    var create = true;
	loginQuery(email, "pass", logindecision, create, accountstatus);
}

function setupqrcodelisten ()
{
       ssocket.on("connect", () => {
         var id = QrID;
         console.log(QrID);
         ssocket.emit("/auth/qr-request", id);
         displayqrcode(id);
       });

       ssocket.on("/auth/approved", (somedata) => {

            console.log(JSON.stringify(somedata));

 
             returnstatus(somedata.email);
//             var x = document.getElementById("qrcode");
//             x.style.display = "none";
       });

}



function displayqrcode(id) {


    new QRCode(document.getElementById("qrcode"), JSON.stringify(id));

    var x = document.getElementById("qrcode");
    x.style.display = "block";

    var y = document.getElementById("qrcodeloading");
    y.style.display = "none";
}

function enableqrcode(email) {

               var data = {
                id:email
               };
                ssocket.emit("/auth/qr-request", data);


    new QRCode(document.getElementById("qrcode"), JSON.stringify(email));

    var x = document.getElementById("qrcode");
    x.style.display = "block";

            ssocket.on("/auth/approved", (somedata) => {
             returnstatus(somedata);
            });


    var y = document.getElementById("validatescanSubmit");
    y.style.display = "none";

    var z = document.getElementById("scanSubmit");
    z.style.display = "block";
}
