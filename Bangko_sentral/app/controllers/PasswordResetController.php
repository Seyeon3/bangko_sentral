<?php
class PasswordResetController extends Controller
{
    public function __construct()
    {
        // Redirect if user is logged in
        if (isset($_SESSION['user_id'])) {
            header("Location: " . PAGE . "dashboard");
            exit();
        }
    }

    // Default method to display the reset password page
    public function index()
    {
        $data['current_page'] = "Send OTP";
        $data['form_errors'] = $_SESSION['reset_form_errors'] ?? null;
        $data['email_value'] = $_SESSION['input_email'] ?? '';

        // Load the reset view
        $this->loadView("PasswordReset", $data);

        // Clear session data after use
        unset($_SESSION['reset_form_errors'], $_SESSION['input_email']);
    }

    // Method to handle OTP sending
    public function verifyOTP()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['reset_form_errors'] = [];
            $_SESSION['input_email'] = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

            // Validate email
            if (empty($_SESSION['input_email'])) {
                $_SESSION['reset_form_errors'][] = "Email is required.";
            } elseif (!filter_var($_SESSION['input_email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['reset_form_errors'][] = "Invalid email format.";
            }

            // If validation errors exist, redirect back
            if (!empty($_SESSION['reset_form_errors'])) {
                header('Location: ' . PAGE . 'PasswordReset');
                exit();
            }

            // Load the UserModel to check if email exists
            $USER = $this->loadModel("UserModel");
            $userData = $USER->findByEmail($_SESSION['input_email']);

            if ($userData) {
                // Generate OTP
                $otp = random_int(100000, 999999); // Secure OTP generation

                // Store OTP in the database (ensure you have this method in UserModel)
                $USER->storeOtp($userData->user_id, $otp);

                // Send OTP via email (implement your email sending logic)
                $this->sendOtpEmail($userData->email, $otp);

                // Redirect to the OTP confirmation page
                header('Location: ' . PAGE . 'sendOTP');
                exit();
            } else {
                $_SESSION['reset_form_errors'][] = "No account found with that email address.";
                header('Location: ' . PAGE . 'PasswordReset');
                exit();
            }
        } else {
            // Handle invalid request methods
            $this->invalid_page();
        }
    }

    // Function to send the OTP via email
    private function sendOtpEmail($email, $otp)
    {
        $subject = "Your OTP Code for Password Reset";
        $message = "Your OTP is: $otp. Please use this to reset your password.";
        $headers = "From: no-reply@yourdomain.com";

        // Send the email
        mail($email, $subject, $message, $headers);
    }

    // Handle invalid pages
    public function invalid_page()
    {
        $data['current_page'] = "Invalid Page";
        $this->loadView("404", $data);
    }
}
?>
