

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

 

async function scanlogin () {
	console.log(my_ajax_object.ajax_url);
	//alert(my_ajax_object.ajax_url);
	var loginsuccess = true;
	
	var email = document.getElementById('scantxtUser').value;
	
    //var pass = document.getElementById('txtPass').value;

  
	const provider = new WsProvider('wss://student.selendra.org');

  
    const api = await ApiPromise.create({ provider });
  
   let record = await api.query.identity.studentidOf(email);
   console.log(record);
   
   const  recordp = JSON.parse(record);
  
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
   }else {
    console.log("Email "+ email + "  not registered" );
    accountstatus = 'noaccount'; 
		create = false;
	alert(" email  not registered");
   }
  
   
	
	loginQuery(email, "pass", logindecision, create, accountstatus);
	
	
}



async function emaillogin1 () {
  const provider = new WsProvider('wss://student.selendra.org');

  // Create the API and wait until ready
  const api = await ApiPromise.create({ provider });


const keyring = new Keyring({ type: 'sr25519' });

  // Add Alice to our keyring with a hard-deived path (empty phrase, so uses dev)
  const meo = keyring.addFromUri(masteruri);

  let alice = keyring.addFromUri(uriofid);



  const { nonce } = await api.query.system.account(meo.address);

  let record = await api.query.identity.studentidOf(email);

  if(record.inspect().inner) {
    let recordp = JSON.parse(record);
    console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));

  }else {
    console.log("Email "+ email + "  not registered" );
    alert(" email  not registered");
  }

 let recordp = JSON.parse(record);

  if(alice.address == recordp.accountId) {
    console.log("Valid mneomonic allow login");
    alert("valid address");

  }else {
    console.log("Invalid mneomonic provided");
    alert("invalid mneomonic");
  }

}


