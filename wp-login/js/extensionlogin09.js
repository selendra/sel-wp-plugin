

 function loginExtQuery(user, pass, decision, create, accountstatus, message) {
 	
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
					   
				      jQuery('#extmessage').html("Account not setup, cannot login");
				   } else {
					   jQuery('#extmessage').html("Account not setup : "+message);
				   }
				   return;
			   }
			   if(decision == false){
				   jQuery('#extmessage').html("Login wrong");
			   } else //if(data.indexOf('Success')!=-1)
			   {
                  
				  jQuery('#extmessage').html("Login success");
				  window.location.reload();
               }
           },
		   error: function(msg) {  
                // login error.                 
                
                jQuery('#extmessage').html("Login failed");
                
            }
    });
  }

 async function extensionlogin () {
	console.log(my_ajax_object.ajax_url);
	//alert(my_ajax_object.ajax_url);
	var loginsuccess = true;
	
	
	var pubkeyinextension = document.getElementById('pubkeyinextension').value;
    var extnemail = document.getElementById('extnemail').value;
	
	
	var logindecision = true;
	var accountstatus = 'noaccount'; 
	var email = extnemail;
	var alice;
	var record;
	
	var create = false;
  
  
	const provider = new WsProvider('wss://student.selendra.org');

  
    const api = await ApiPromise.create({ provider });
	
	const keyring = new Keyring({ type: 'sr25519' });

  
    console.log("test 10");
	
  try {
// this call fires up the authorization popup
const extensions = await web3Enable('Student-id app');

if (extensions.length === 0) {
    // no extension installed, or the user did not accept the authorization
    // in this case we should inform the use and give a link to the extension
	logindecision = false;
		create = false;
		accountstatus = 'noaccount';
      //loginExtQuery("notapplicable", "notused", logindecision, create, accountstatus, "No extensions installed");
	  alert("Install polkadot extension in browser https://polkadot.js.org/extension/ ");
    return;
}

// we are now informed that the user has at least one extension and that we
// will be able to show and use accounts
const allAccounts = await web3Accounts();

 // We arbitraily select the first account returned from the above snippet
// `account` is of type InjectedAccountWithMeta
const account = allAccounts[0];
if( allAccounts.length === 0) {
	logindecision = false;
		create = false;
		accountstatus = 'noaccount';
      // loginExtQuery("notapplicable", "notused", logindecision, create, accountstatus, "No accounts in extension");
	  alert("Create account in polkadot extension  ");
    return;
}

} catch (e) {
	  logindecision = false;
		create = false;
		accountstatus = 'noaccount';
      loginExtQuery("notapplicable", "notused", logindecision, create, accountstatus, "Error enabling extension");
	  return;
   }
   

try {
    console.log("test 15");
   record = await api.query.identity.emailId(pubkeyinextension);
    console.log("test 16");
   
   console.log(JSON.stringify(record));

  if(record.toHuman() != null) {
	  console.log("test 18");
    console.log(record.toHuman() + " is already linked to " + pubkeyinextension);
	email = record.toHuman();
  }else {
	  console.log("test 19");
   logindecision = false;
   accountstatus = 'noaccount'; 
   
   loginExtQuery("dummy", "notused", logindecision, create, accountstatus, "No matching email");
   return
  }

   } catch (err) {
	   console.log("test 20");
	   logindecision = false;
   accountstatus = 'noaccount'; 
	   loginExtQuery("dummy", "notused", logindecision, create, accountstatus, "Cannot parse input");
	   return;
   }
 
   

  
   let emailrecord = await api.query.identity.studentidOf(email);
   let recordp = JSON.parse(emailrecord);
   
   console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));

	var injector;
	try {
  
  
// to be able to retrieve the signer interface from this account
// we can use web3FromSource which will return an InjectedExtension type
   injector = await web3FromAddress(pubkeyinextension)
//const injector = await web3FromSource(account.meta.source);
	} catch (err) {
		logindecision = false;
		create = false;
		accountstatus = 'noaccount';
	//	loginExtQuery("dummy", "notused", logindecision, create, accountstatus, "Provided publickey not in extension");
	alert("Account does not exist in extension  ");
		return;
	}

// this injector object has a signer and a signRaw method
// to be able to sign raw bytes
const signRaw = injector?.signer?.signRaw;

const messagetosign = 'message to sign '+ randomAsU8a(10) ;// (Math.random() + 1).toString(36).substr(7);
if (!!signRaw) {
    // after making sure that signRaw is defined
    // we can use it to sign our message
    const { signature } = await signRaw({
        address: pubkeyinextension,

		 data: stringToHex(messagetosign),
        type: 'bytes'
    });
        console.log(hexToString(signature));
//    setSignature(hexToString(signature));
//    setSignmessage(messagetosign);

   console.log("y="+messagetosign);
   console.log("x="+signature);
   console.log("z="+pubkeyinextension);
   
  var verification = signatureVerify(stringToHex(messagetosign),signature, pubkeyinextension);
   
   console.log(JSON.stringify(verification));
   
//    if (verification.crypto !== 'none') {
	    if (verification.isValid == true) {
      
		logindecision = true;
		accountstatus = 'yesaccount';
		create = true;
		console.log("valid");
		loginExtQuery(email, "notused", logindecision, create, accountstatus, "");
      } else {
       
		logindecision = false;
		create = false;
		accountstatus = 'noaccount';
		console.log("not valid");
		loginExtQuery(email, "notused", logindecision, create, accountstatus, "Address not matching");
      }

    } 
  
}


		
  


	
	
	
 
   
  
   
   
   
 
