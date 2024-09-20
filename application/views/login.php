<!DOCTYPE html>
<html>
<head>
    <title>Login_form</title>
	<style>
		.button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
	</style>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <!-- <button type="submit">Login</button> -->
		<a href="User_form" class="button">Login</a>
    </form>
    
    <div id="loginError"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?= base_url('login/validate') ?>", // Login validation URL
            data: $('#loginForm').serialize(),
            success: function(response) {
                if (response === 'success') {
                    // Redirect to the user form page upon successful login
                    window.location.href = "<?= base_url('User/index') ?>";
                } else {
                    $('#loginError').html('<p style="color:red;">Invalid Username or Password</p>');
                }
            }
        });
    });
</script>

</body>
</html>
