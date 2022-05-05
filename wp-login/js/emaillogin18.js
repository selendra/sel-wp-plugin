

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
					   
				      jQuery('#message').html("Account not setup, cannot login");
				   } else {
					   jQuery('#message').html("Account not setup");
				   }
				   return;
			   }
			   if(decision == false){
				   jQuery('#message').html("Login wrong");
			   } else //if(data.indexOf('Success')!=-1)
			   {
                  
				  jQuery('#message').html("Login success");
				  window.location.reload();
               }
           },
		   error: function(msg) {  
                // login error.                 
                
                jQuery('#message').html("Login failed");
                
            }
    });
  }

 

async function emaillogin () {
	console.log(my_ajax_object.ajax_url);
	//alert(my_ajax_object.ajax_url);
	var loginsuccess = true;
	
	var email = document.getElementById('txtUser').value;
    var pass = document.getElementById('txtPass').value;

  
	const provider = new WsProvider('wss://student.selendra.org');

  
    const api = await ApiPromise.create({ provider });
  
   let record = await api.query.identity.studentidOf(email);
   console.log(record);
   
   const  recordp = JSON.parse(record);
  
   var passhash = recordp.info.passwordhash;

        
   var hashtocompare = passhash.sha256;
    var logindecision = true;
	var create = false;
	

	 var givenpasshash = u8aToHex(sha256AsU8a(pass));
	 
        if(givenpasshash == hashtocompare){
			logindecision = true;
		    create = true;
            
        } else {
            
			logindecision = false;
		    create = false;
        }

		

	   
	
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
  
  
	
   loginQuery(email, pass, logindecision, create, accountstatus);
	
	
}





