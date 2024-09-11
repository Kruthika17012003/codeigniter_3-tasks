<!DOCTYPE html>
<html lang="en">
<head>
    <title>AJAX Form in CodeIgniter</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>
    <h2>Submit Form via AJAX</h2>
    <form id="myForm" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <div id="response"></div> <!-- Response container -->

    <script>
        $(document).ready(function(){
            $('#myForm').on('submit', function(e){
                e.preventDefault(); // Prevent the form from refreshing the page

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: "<?= base_url('form/submit_form') ?>", // URL to the controller method
                    type: "POST",
                    data: formData,
                    success: function(response){
                        $('#response').html(response); // Update the response div with the result
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
</body>
</html>
