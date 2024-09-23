<!DOCTYPE html>
<html>
<head>
    <title>User Form</title>
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

        .button:hover {
            background-color: #0056b3;
        }
		table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<?php
    //validation of data
    $UserID = $Name = $phoneNumber = $group = "";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
    	$UserID=val($_POST["UserID"]);
        $Name=val($_POST["Name"]);
        $phoneNumber=val($_POST["phoneNumber"]);
        $group=val($_POST["group"]);
        }
		function val($data){
			$data=trim($data);//remove unneccessary spaces
			$data=stripslashes($data);//remove unneccessary backslashes
			$data=htmlspecialchars($data);//secures data //action="./submit"
			return $data;
		}?>
	<?php htmlspecialchars($_SERVER["PHP_SELF"]);
		?>
	
    <h1>User Form</h1>
	<form name="employment" action="#" method="post" id = "user_form">
        <table width="600" border="0" cellspacing="1" cellpading="1">
            <tr>
                <td><h2>User Application</h2></td>
                <td></td>
            </tr>
            <tr>
                <td>UserID</td>
                <td><input type="text" name="UserID" maxlength="50"/></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="Name" maxlength="50"/></td>
            </tr>
            <tr>
                <td>phoneNumber</td>
                <td><input type="text" name="phoneNumber" maxlength="50"/></td>
            </tr>

            <tr>
                <td>Group</td>
                <td>
                    <select name="group" required>
                        <?php if (!empty($groups)): ?>
                            <?php foreach ($groups as $group): ?>
                                <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No groups available</option>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
			<a href="Groups_data" class="button">Groups</a>
            <tr>
                <td></td>
                <td>
                <td><input type="submit" name="submit" value="submit"/> </td>
                <td><input type="reset" name="reset" value="reset"/></td>
                </td>
            </tr>
        </table>
    </form>

	<div id="message"></div>
	<h1>User Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Group</th>
				<th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['UserID']; ?></td>
                    <td><?php echo $user['Name']; ?></td>
                    <td><?php echo $user['phoneNumber']; ?></td>
                    <td><?php echo $user['group_id']; ?></td> <!-- Display group id -->
					<td><?php echo $user['status'] == 1 ? '1' : '0'; ?></td>
                <td>
                    <button class="deleteBtn" data-id="<?php echo $user['id']; ?>">Delete</button>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<script>
        $(document).ready(function() {
            // Load groups into the dropdown on page load
            $.ajax({
                url: 'http://localhost/codeigniter_3/index.php/User/groups', // Adjust the URL as needed
                method: 'GET',
                dataType: 'json',
                success: function(groups) {
                    var options = '';
                    $.each(groups, function(index, group) {
                        options += '<option value="' + group.id + '">' + group.name + '</option>';
                    });
                    $('#group').html(options);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load groups:', error);
                    $('#message').text('Failed to load groups').css('color', 'red');
                }
            });

            // Handle form submission with AJAX
            $('#user_form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var form_data = $(this).serialize(); // Serialize form data

                $.ajax({
                    type: "POST",
                    url: "http://localhost/codeigniter_3/index.php/User/submit", // Adjust the URL as needed
                    data: form_data,
                    dataType: "json",
                    success: function(response) {
                        console.log('AJAX response:', response); // Log the response

                        if (response.status === 'success') {
                            $('#message').text(response.message).css('color', 'green');
                            
                            // Update user table
                            var rows = '';
                            if (Array.isArray(response.users) && response.users.length > 0) {
                            $.each(response.users, function(index, user) {
                                rows += '<tr>' +
                                    '<td>' + user.id + '</td>' +
                                    '<td>' + user.UserID + '</td>' +
                                    '<td>' + user.Name + '</td>' +
                                    '<td>' + user.phoneNumber + '</td>' +
                                    '<td>' + user.group_id + '</td>' +
									'<td>' + status + '</td>' +
                                '<td><button class="deleteBtn" data-id="' + user.id + '">Delete</button></td>' +
                                    '</tr>';
                            });
                        } else {
                            rows = '<tr><td colspan="5">No users found</td></tr>';
                        }
                            $('#userTable tbody').html(rows); // Update the table body
                        } else {
                            $('#message').text(response.message).css('color', 'red');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error); // Log AJAX errors
                        $('#message').text('An error occurred: ' + error).css('color', 'red');
                    }
                });
            });
        });

		$(document).on('click', '.deleteBtn', function() {
    var userId = $(this).data('id');

    // Send AJAX request to delete the user
    $.ajax({
        type: 'POST',
        url: 'http://localhost/codeigniter_3/index.php/User/delete_user', // Adjust URL
        data: { id: userId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#message').text(response.message).css('color', 'green');

                // Update user table
                var rows = '';
                if (Array.isArray(response.users) && response.users.length > 0) {
                    $.each(response.users, function(index, user) {
                        rows += '<tr>' +
                            '<td>' + user.id + '</td>' +
                            '<td>' + user.UserID + '</td>' +
                            '<td>' + user.Name + '</td>' +
                            '<td>' + user.phoneNumber + '</td>' +
                            '<td>' + user.group_id + '</td>' +
                            '<td>' + (user.status || 'N/A') + '</td>' +
                            '<td><button class="deleteBtn" data-id="' + user.id + '">Delete</button></td>' +
                        '</tr>';
                    });
                } else {
                    rows = '<tr><td colspan="5">No users found</td></tr>';
                }
                $('#userTable tbody').html(rows); // Update the table body
            } else {
                $('#message').text(response.message).css('color', 'red');
            }
        },
        error: function(xhr, status, error) {
            $('#message').text('An error occurred: ' + xhr.status + ' ' + error).css('color', 'red');
        }
    });
});
    </script>

<script>
    // Get the current time when the page loads
    var lastActivity = Date.now();

    // Monitor any keypress or click events to reset the last activity
    document.onkeypress = document.onclick = function() {
        lastActivity = Date.now();
    };

    // Check the inactivity every second
    setInterval(function() {
        var currentTime = Date.now();
        var timeDifference = (currentTime - lastActivity) / 1000; // Difference in seconds
        
        // If the user is inactive for more than 3 seconds, redirect to the login page
        if (timeDifference > 3) {
            window.location.href = "<?= base_url('login'); ?>"; // Redirect to login page
        }
    }, 1000);
</script>

</body>
</html>
