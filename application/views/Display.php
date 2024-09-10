<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Submitted Data</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Submitted User Information</h1>
    <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve and sanitize form data
            $UserID = htmlspecialchars($_POST['UserID']);
            $Name = htmlspecialchars($_POST['Name']);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            $group = htmlspecialchars($_POST['group']);
    ?>
        <table>
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>UserID</td>
                    <td><?php echo $UserID; ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $Name; ?></td>
                </tr>
                <tr>
                    <td>PhoneNumber</td>
                    <td><?php echo $phoneNumber; ?></td>
                </tr>
                <tr>
                    <td>group</td>
                    <td><?php echo $group; ?></td>
                </tr>
            </tbody>
        </table>
    <?php
        } else {
            echo "<p>No data received. Please submit the form first.</p>";
        }
    ?>
</body>
</html>
