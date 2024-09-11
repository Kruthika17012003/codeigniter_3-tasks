<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
</head>
<body>
    <h1>User Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Group</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['UserID']; ?></td>
                    <td><?php echo $user['Name']; ?></td>
                    <td><?php echo $user['phoneNumber']; ?></td>
                    <td><?php echo $user['group_name']; ?></td> <!-- Display group name -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

