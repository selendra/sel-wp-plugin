
jQuery(document).ready(function(){
  jQuery('#txtSubmit').click(function(){
	var abc = mnlogin();
    jQuery.ajax({
           type:"POST",
           url: my_ajax_object.ajax_url,
           data: {
               action: "login_action",
               user: abc.user, //jQuery("#txtUser").val(),
               pass : abc.pass, // jQuery("#txtPass").val(),
           },
           success:function(data){
               if(data.indexOf('Success')!=-1){
                 window.location.reload();
               }
           }
    });
  });
});
