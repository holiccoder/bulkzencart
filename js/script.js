$(document).ready(function(){


	$error = $('<center><label class = "text-danger">请填写表单必填项目!</label></center>');

	$error1 = $('<center><label class = "text-danger">无效的用户名或者密码</label></center>');

	$loading = $('<center><img src = "images/loading.gif"></center>');

	$load_status= $('<center><label class = "text-success">稍等,正在处理中...</label></center>');

	$valid = $('<center><label class = "text-danger">网站域名已经存在!</label></center>');

	$mem_valid = $('<center><label class = "text-danger">Member name already exist!</label></center>');

	$club_valid = $('<center><label class = "text-danger">Club name already exist!</label></center>');

	$group_valid = $('<center><label class = "text-danger">Member already joined!</label></center>');

	$('#addserver').click(function(){

		$error.remove();

		$valid.remove();

		$serverip = $('#serverip').val();

		$serveruser = $('#serveruser').val();

		$serverpassword = $('#serverpassword').val();

		$serverapikey = $('#serverapikey').val();

		if($serverip == "" || $serveruser == "" || $serverpassword == "" || $serverapikey == "" ){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('valid_server.php', {serverip: $serverip },

					function(result){

					   console.log(result);

						if(result == "Success"){

							$valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'save_server.php',

								data: { serverip: $serverip,
									serveruser:$serveruser,
									serverpassword:$serverpassword,
									serverapikey:$serverapikey
									},

								success: function(data){
                                    console.log(data);
									window.location = 'servers.php';

								}

							});

						}

					}

				)

				$load_status.remove();

			}, 3000)

		}

	});

	

// Administrator Login	

	$('#login').click(function(){

		$error.remove();

		$error1.remove();

		$username  = $('#username').val();

		$password = $('#password').val();

		if($username == "" && $password == ""){

			$error.appendTo('#loading');

		}else{

			$loading.appendTo('#loading');

			setTimeout(function(){

				$.post('validate.php', {username: $username, password: $password},

					function(result){

						if(result == "Success"){

							window.location = 'home.php';

							$('#username').val('');

							$('#password').val('');

							$loading.remove();

						}else{

							$error1.appendTo('#loading');

							$('#username').val('');

							$('#password').val('');

							$loading.remove();

						}

					}

				)	

			}, 3000);	

		}

	});

	

//Administrator Registration	

	$('#signup').click(function(){

		$error.remove();

		$valid.remove();

		$domain = $('#domain').val();

		$serverid = $("#serverid option:selected").val();

		$name = $('#name').val();

		$currency = $("#currency").val();

		$storephone = $('storephone').val();

		$email = $('#email').val();

		$address = $('#address').val();

		$theme = $('#theme').val();

		$metatitle = $('#metatitle').val();

		$metakeywords = $('#metakeywords').val();

		$metadescription = $('#metadescription').val();

		if($domain == "" || $name == "" || $serverid == "" || $email == "" || $address == "" || $theme == "" || $metatitle == "" || $metakeywords == "" || $metadescription == ""){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('valid_signup.php', {domain: $domain
				  },

					function(result){

						if(result == "Success"){

							$valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'save_data.php',

								data: { domain: $domain,
									serverid:$serverid,
									name:$name,
									storephone:$storephone,
									address:$address,
									email:$email,
									theme:$theme,
									currency:$currency,
									metatitle:$metatitle,
									metakeywords:$metakeywords,
									metadescription:$metadescription},

								success: function(data){
                                    console.log(data);
									window.location = 'home.php';

								}

							});

						}

					}

				)

				$load_status.remove();

			}, 3000)

		}

	});

//Administrator Edit

	$('#acc_edit').click(function(){

		$admin_id = $('#admin_id').val();

		$error.remove();

		$valid.remove();

		$username = $('#username').val();

		$password = $('#password').val();

		if($username == "" || $password == ""){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('valid_signup.php', {username: $username},

					function(result){

						if(result == "Success"){

							$valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'account_edit_query.php?admin_id=' + $admin_id,

								data: {username: $username, password: $password},

								success: function(){

									window.location = 'account.php';

								}

							});

						}

					}

				)

				$load_status.remove();

			}, 3000)

		}

	});

// Member Registration

	$('#save_member').click(function(){

		$error.remove();

		$mem_valid.remove();

		$firstname = $('#firstname').val();

		$lastname = $('#lastname').val();

		if($firstname == "" || $lastname == ""){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('mem_validator.php', {firstname: $firstname, lastname: $lastname},

					function(result){

						if(result == "Success"){

							$mem_valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'save_member.php',

								data: {firstname: $firstname, lastname: $lastname},

								success: function(){

									window.location = 'member.php';

								}

							});

						}

					}

				)

			$load_status.remove();	

			}, 3000)

		}

	});

// Member Edit

$('#mem_edit').click(function(){

		$error.remove();

		$mem_id = $('#mem_id').val();

		$mem_valid.remove();

		$firstname = $('#firstname').val();

		$lastname = $('#lastname').val();

		if($firstname == "" || $lastname == ""){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('mem_validator.php', {firstname: $firstname, lastname: $lastname},

					function(result){

						if(result == "Success"){

							$mem_valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'mem_edit_query.php?mem_id=' + $mem_id,

								data: {firstname: $firstname, lastname: $lastname},

								success: function(){

									window.location = 'member.php';

								}

							});

						}

					}

				)

			$load_status.remove();	

			}, 3000)

		}

	});

// Club Registration

$('#save_club').click(function(){

		$error.remove();

		$club_valid.remove();

		$club = $('#club').val();

		if($club == "" ){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('club_validator.php', {club: $club},

					function(result){

						if(result == "Success"){

							$club_valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'save_club.php',

								data: {club: $club},

								success: function(){

									window.location = 'club.php';

								}

							});

						}

					}

				)

			$load_status.remove();	

			}, 3000)

		}

	});

// Club Edit

$('#club_edit').click(function(){

		$error.remove();

		$club_id = $('#club_id').val();

		$club_valid.remove();

		$club = $('#club').val();

		if($club == ""){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('club_validator.php', {club: $club},

					function(result){

						if(result == "Success"){

							$club_valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'club_edit_query.php?club_id=' + $club_id,

								data: {club: $club},

								success: function(){

									window.location = 'club.php';

								}

							});

						}

					}

				)

			$load_status.remove();	

			}, 3000)

		}

	});

	$('#save_group').click(function(){

		$error.remove();

		$group_valid.remove();

		$mem_id = $('#member').val();

		$club_id = $('#club').val();

		if($mem_id == "" ){

			$error.appendTo('#loading');

		}else{

			$load_status.appendTo('#loading');

			setTimeout(function(){

				$.post('group_validator.php', {mem_id: $mem_id, club_id: $club_id},

					function(result){

						if(result == "Success"){

							$group_valid.appendTo('#loading');

						}else{

							$.ajax({

								type: 'POST',

								url: 'save_group.php',

								data: {mem_id: $mem_id, club_id: $club_id},

								success: function(){

									window.location = 'group.php?club_id=' + $club_id;

								}

							});

						}

					}

				)

			$load_status.remove();	

			}, 3000)

		}

	});

});