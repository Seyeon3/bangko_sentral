<?php
class SendOTPController extends Controller
{
    public function __construct()
    {
        // Ensure that logged-in users cannot access the password reset page
        if ($this->isActiveUserLoggedIn()) {
            header("Location: " . PAGE . "dashboard");
            exit();
        }
    }

    // Default method to show the OTP form
    public function index() 
    {
        $this->showOTPForm();
    }

    // Show OTP form
    public function showOTPForm()
    {
        $data['current_page'] = "Verify OTP";
        $this->loadView("sendOTP", $data);
    }

    // Send OTP to the user's email
    public function sendOTP()
    {
        $data['current_page'] = "Reset Password";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            // Validate the email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Load the UserModel to interact with the database
                $USER = $this->loadModel("UserModel");
                $user = $USER->findByEmail($email);

                if ($user) {
                    // Generate OTP
                    $otp = random_int(100000, 999999); // 6-digit OTP

                    // Store OTP in the database (associate with user)
                    $USER->storeOtp($user->id, $otp);

                    // Send OTP to email
                    $this->sendEmail($email, $otp);

                    $data['message'] = "An OTP has been sent to your email.";
                } else {
                    $data['error'] = "Email address not found.";
                }
            } else {
                $data['error'] = "Please enter a valid email address.";
            }
        }

        // Reload the form with the message or error
        $this->loadView("ForgotPass", $data);
    }

    // Verify the OTP entered by the user
   public function verifyOTP()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $otp = trim($_POST['otp']);

        // Load the UserModel
        $USER = $this->loadModel("UserModel");
        $storedOtp = $USER->getOtpByUserId($_SESSION['user_id']); // Get stored OTP

        if ($otp == $storedOtp) {
            // OTP is correct, allow password reset
            $_SESSION['otp_verified'] = true; // Set session variable to indicate verification
            header("Location: " . PAGE . "reset-password"); // Redirect to reset password page
            exit();
        } else {
            $data['error'] = "Invalid OTP. Please try again.";
            $this->loadView("sendOTP", $data); // Reload form with error
        }
    }
}

    // Helper method to send the OTP email
    private function sendEmail($email, $otp)
    {
        $subject = "Password Reset OTP";
        $message = "Your OTP for password reset is: $otp";
        $headers = "From: no-reply@yourdomain.com";

        // Send OTP to user's email
        mail($email, $subject, $message, $headers);
    }
}
?>
