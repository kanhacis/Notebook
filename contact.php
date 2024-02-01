<title>Contact</title>

<?php
function handleContactForm()
{
    // Include navbar file
    include "navbar.php";

    // Include connection file
    include "connection.php";

    if (isset($_POST["sendMsg"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $insert_sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "Message sent successfully!";
            } else {
                echo "Something went wrong, Please try Again!";
            }
        }
        exit();
    }
}

// Call the function to handle the contact form
handleContactForm();
?>


<!-- Send message using ajax call start -->
<script>
    $(document).ready(function() {
        $("#contactForm").submit(function(e) {
            e.preventDefault();

            let name = $("#name").val();
            let email = $("#email").val();
            let subject = $("#subject").val();
            let message = $("#message").val();

            console.log(subject, message)

            if ((!name) || (!email) || (!subject)) {
                Swal.fire({
                    icon: "warning",
                    text: "All fields are required!",
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                let myData = {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message,
                    sendMsg: 1
                };

                $.ajax({
                    type: "POST",
                    url: window.location.href,
                    data: myData,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            text: "Message sent successfully!",
                            timer: 1000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('#contactForm').trigger("reset");
                    },
                    error: function() {
                        Swal.fire({
                            icon: "warning",
                            text: "Something went wrong, try again.."
                        })
                    }
                });
            }
        });
    });
</script>
<!-- Send message using ajax call end -->


<!-- Signup start -->
<section style="background-color: #f6f4f5; margin-bottom:-48px;">
    <div class="container py-5" style="width:40%">
        <form method="POST" id="contactForm">
            <div class="row my-3">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name" class="mb-2">Name</label>
                        <input type="text" class="form-control" name="name" id="name" style="height:50px" placeholder="Enter Name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email" class="mb-2">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" style="height:50px" placeholder="Enter email">
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-12">
                    <div class="form-group">
                        <label for="subject" class="mb-2">Subject</label>
                        <input type="text" class="form-control" name="subject" id="subject" style="height:50px" placeholder="Enter subject">
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-12">
                    <label for="message" class="mb-2">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="7"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="sendMsg" style="background-color:pink; color:black; border:none; height:50px;">Send message</button>
        </form>
    </div>
    <hr>
</section>
<!-- Signup end -->

<!-- Include footer start -->
<?php include "footer.php" ?>
<!-- Include footer end -->