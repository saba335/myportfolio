<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .rounded-t-5 {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        @media (min-width: 992px) {
            .rounded-tr-lg-0 {
                border-top-right-radius: 0;
            }

            .rounded-bl-lg-5 {
                border-bottom-left-radius: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Section: Design Block -->
    <section class="text-center text-lg-start">
        <div class="card mb-3">
            <div class="row g-0 d-flex align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                         class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                </div>
                <div class="col-lg-8">
                    <div class="card-body py-5 px-md-5">

                        <form method="POST" action="">
                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="form2Example1" class="form-control" placeholder="Enter your username" name="username" required/>
                                <label class="form-label" for="form2Example1"></label>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="form2Example2" class="form-control" placeholder="Enter your password" name="password" required/>
                                <label class="form-label" for="form2Example2"></label>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Simple link -->
                                    <a href="#!">Forgot password?</a>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
// Start session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $input_username = htmlspecialchars(trim($_POST['username']));
    $input_password = htmlspecialchars(trim($_POST['password']));

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ? AND password= ?");
    $stmt->bind_param("ss", $input_username,$input_password);
    $stmt->execute();
    $stmt->store_result();

    // Check if username exists
    if ($stmt->num_rows > 0) {
        error_log("Hello");
        $stmt->bind_result($id,$password, $role);
        $stmt->fetch();

        // Verify the password
        
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $input_username;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: enquiry.php");
            } else {
                header("Location: enquiry.php");
            }
            exit;
       
        
    } else {
        echo "<p style='color: red;'>No user found with that username. Please try again.</p>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

</body>
</html>
