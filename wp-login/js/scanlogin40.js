

 function scanloginQuery(user, pass, decision, create, accountstatus, message) {
 	
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
                                   if(message) {
				     jQuery('#scanmessage').html(message);
                                   }else{
				     jQuery('#scanmessage').html("Login wrong");
                                   }
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
  
   
	
	// scanloginQuery(email, "pass", logindecision, create, accountstatus);
	
	
}

function returnstatus(email) {

    var accountstatus = 'yesaccount';
    var logindecision = true;
    var create = true;
	scanloginQuery(email, "pass", logindecision, create, accountstatus,"Login success");
}

function notapprovedreturn(email) {

    var accountstatus = 'yesaccount';
    var logindecision = false ;
    var create = false;
	scanloginQuery(email, "pass", logindecision, create, accountstatus, "Login approval denied");
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

       ssocket.on("/auth/notapproved", (somedata) => {

            console.log(JSON.stringify(somedata));

 
             notapprovedreturn(somedata.email);
//             var x = document.getElementById("qrcode");
//             x.style.display = "none";
      }); 

}



function displayqrcode(id) {


    
    //if(x1 != null) x1.remove();
    //if(x2 != null) x2.remove();

    new QRCode(document.getElementById("qrcode1"), JSON.stringify(id));
    new QRCode(document.getElementById("qrcode2"), JSON.stringify(id));

    var x1 = document.getElementById("qrcode1");
    var y1 = document.getElementById("qrcodeloading1");
    var x2 = document.getElementById("qrcode2");
    var y2 = document.getElementById("qrcodeloading2");
    
    console.log("x1 children ="+ x1.children.length);
    console.log("x2 children ="+ x2.children.length);
    x1.style.display = "block";
    y1.style.display = "none";
    x2.style.display = "block";
    y2.style.display = "none";
}

function enableqrcode(email) {

               var data = {
                id:email
               };
                ssocket.emit("/auth/qr-request", data);


    new QRCode(document.getElementById("qrcode1"), JSON.stringify(email));

    var x = document.getElementById("qrcode1");
    x.style.display = "block";

    ssocket.on("/auth/approved", (somedata) => {
             returnstatus(somedata);
    });


    var y = document.getElementById("validatescanSubmit");
    y.style.display = "none";

    var z = document.getElementById("scanSubmit");
    z.style.display = "block";
}
