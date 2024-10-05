<?php
class ResetProcessController extends Controller
{
    public function __construct()
    {
        // Ensure that only logged-in users can access the password reset page
        if (!$this->isActiveUserLoggedIn()) {
            header("Location: " . PAGE . "login"); // Redirect to login page if not logged in
            exit();
        }
    }

    // Default method to show the password reset form
    public function index()
    {
        $data['current_page'] = "Reset Password"; // Set current page for navigation highlighting
        $this->loadView("PasswordReset", $data);
    }

    // Process the password reset form
    public function resetPassword()
    {
        $data['current_page'] = "Reset Password"; // Set current page for navigation highlighting

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the submitted passwords
            $currentPassword = trim($_POST['current_password']);
            $newPassword = trim($_POST['new_password']);

            // Load the UserModel to interact with the database
            $USER = $this->loadModel("UserModel");

            // Check if the current password is correct
            if ($USER->checkPassword($_SESSION['user_id'], $currentPassword)) {
                // Update the password
                if ($USER->updatePassword($_SESSION['user_id'], password_hash($newPassword, PASSWORD_DEFAULT))) {
                    $data['message'] = "Password reset successfully!";
                } else {
                    $data['error'] = "Failed to update password. Please try again.";
                }
            } else {
                $data['error'] = "Current password is incorrect.";
            }
        }

        // Reload the form with any messages or errors
        $this->loadView("PasswordReset", $data);
    }
}
?>