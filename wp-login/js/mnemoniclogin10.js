

 function loginMneQuery(user, pass, decision, create, accountstatus, message) {
 	
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
					   
				      jQuery('#mnemessage').html("Account not setup, cannot login");
				   } else {
					   jQuery('#mnemessage').html("Account not setup : "+message);
				   }
				   return;
			   }
			   if(decision == false){
				   jQuery('#mnemessage').html("Login wrong");
			   } else //if(data.indexOf('Success')!=-1)
			   {
                  
				  jQuery('#mnemessage').html("Login success");
				  window.location.reload();
               }
           },
		   error: function(msg) {  
                // login error.                 
                
                jQuery('#mnemessage').html("Login failed");
                
            }
    });
  }

 
 
  

async function menomoniclogin () {
	console.log(my_ajax_object.ajax_url);
	//alert(my_ajax_object.ajax_url);
	var loginsuccess = true;
	
	
	var publickey = document.getElementById('Publickey').value;
    var txtMnemonic = document.getElementById('txtMnemonic').value;
	var logindecision = true;
	var accountstatus = 'noaccount'; 
	var email ;
	var alice;
	var record;
	
	
	const provider = new WsProvider('wss://student.selendra.org');

  
    const api = await ApiPromise.create({ provider });
	
	const keyring = new Keyring({ type: 'sr25519' });

  
    console.log("test 10");
 
    try {
    console.log("test 11");
	alice = keyring.addFromUri(txtMnemonic);

	console.log("test 12");
	}catch(err) {
		console.log("test 13");
	  logindecision = false;
      accountstatus = 'noaccount'; 
   
	  loginMneQuery("dummy", "notused", logindecision, create, accountstatus, "Invalid mnemonic");
	  return;
	}
  
  console.log("test 14");
  
   try {
    console.log("test 15");
   record = await api.query.identity.emailId(publickey);
    console.log("test 16");
   console.log(JSON.stringify(record));
   } catch (err) {
	    console.log("test 17");
		 logindecision = false;
         accountstatus = 'noaccount'; 
		 loginMneQuery("dummy", "notused", logindecision, create, accountstatus, "Cannot parse publickey input");
	   return;
   }
   
   try {

  if(record.toHuman() != null) {
    console.log(record.toHuman() + " is already linked to " + publickey);
	email = record.toHuman();
  }else {
   logindecision = false;
   accountstatus = 'noaccount'; 
   
   loginMneQuery("dummy", "notused", logindecision, create, accountstatus, "No matching email");
   return
  }

   } catch (err) {
	   loginMneQuery("dummy", "notused", logindecision, create, accountstatus, "Cannot parse input");
	   return;
   }
  
	

    var accountstatus;
	 var logindecision = true;
	var create = false;
  

  
   let emailrecord = await api.query.identity.studentidOf(email);
   let recordp = JSON.parse(emailrecord);
   
   console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));

   if(emailrecord.inspect().inner) {
	
	if(alice.address == recordp.accountId) {
		logindecision = true;
		accountstatus = 'yesaccount';
		create = true;
		loginMneQuery(email, "notused", logindecision, create, accountstatus, "");
	}else {
		logindecision = false;
		create = false;
		accountstatus = 'noaccount';
		loginMneQuery(email, "notused", logindecision, create, accountstatus, "Address not matching");
	}
    
    
   }else {
    console.log("Email "+ email + "  not registered" );
     
	
	alert(" email  not registered");
	loginMneQuery(email, "notused", logindecision, create, accountstatus, "Email not registered");
   }
  
  	
	
	
	
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


