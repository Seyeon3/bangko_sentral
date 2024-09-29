<?php
class LoginController extends Controller
{

  public function __construct()
  {
    if (isset($_SESSION['user_id'])) {
      header("Location: " . PAGE . "dashboard");
      exit();
    }
  }
  function index() //default method
  {
    $data['current_page'] = "Login";
    $data['login_form_errors_messages'] = $_SESSION['login_form_errors_messages'] ?? null;
    $data['input_username_red_border'] = !empty($data['login_form_errors_messages']) && in_array("Username is invalid.", $_SESSION['login_form_errors_messages']) ? 'is-invalid' : '';
    $data['input_password_red_border'] = !empty($data['login_form_errors_messages']) && in_array("Password is invalid.", $_SESSION['login_form_errors_messages']) ? 'is-invalid' : '';
    $data['checkbox_recaptcha_red_border'] = !empty($data['login_form_errors_messages']) && in_array("reCAPTCHA verification failed. Please try again.", $_SESSION['login_form_errors_messages']) ? 'border-danger' : '';
    $data['input_username_value'] = $_SESSION['input_username'] ?? '';
    
    $this->loadView("login", $data);

    unset($_SESSION['login_form_errors_messages']);
    unset($_SESSION['input_username']);
  }

  function authenticate()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Initialize session variables
      $_SESSION['login_form_errors_messages'] = [];
      $_SESSION['input_username'] = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');

      // Validate input fields first
      if (empty($_SESSION['input_username'])) {
        $_SESSION['login_form_errors_messages'][] = "Username is required.";
      }

      $inputPassword = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
      if (empty($inputPassword)) {
        $_SESSION['login_form_errors_messages'][] = "Password is required.";
      }

      // If there are validation errors, redirect back to the login page
      if (!empty($_SESSION['login_form_errors_messages'])) {
        header('Location: ' . PAGE . 'login');
        exit();
      }

      // reCAPTCHA verification
      $recaptcha_secret = "6Lc4n1IqAAAAAIpW28YulU6ZoSQ2mZn0RYJTfrdR";
      $recaptcha_response = $_POST['g-recaptcha-response'];
      $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
      $response_data = json_decode($verify_response);

      if (!$response_data->success) {
        // reCAPTCHA validation failed
        $_SESSION['login_form_errors_messages'][] = "reCAPTCHA verification failed. Please try again.";
        header('Location: ' . PAGE . 'login');
        exit();
      }

      // Proceed with user authentication if reCAPTCHA is successful
      $USER = $this->loadModel("UserModel");
      $returnData = $USER->selectUser(['username' => $_SESSION['input_username']]);

      if ($returnData) {
        $hashedPassword = $returnData[0]->password; // Assuming $returnData is an array of objects

        if (password_verify($inputPassword, $hashedPassword)) {
          // Successful authentication
          $_SESSION['user_id'] = $returnData[0]->user_id;
          $_SESSION['username'] = $returnData[0]->username;
          $_SESSION['full_name'] = $returnData[0]->full_name;
          $USER->insertLoginAttempt($_SESSION['input_username'], true);
          header('Location: ' . PAGE . 'dashboard'); // Redirect to the dashboard page
          exit();
        } else {
          // Password is invalid
          $_SESSION['login_form_errors_messages'][] = "Password is invalid.";
          $USER->insertLoginAttempt($_SESSION['input_username'], false);
          header('Location: ' . PAGE . 'login');
          exit();
        }
      } else {
        // Username is invalid
        $_SESSION['login_form_errors_messages'][] = "Username is invalid.";
        header('Location: ' . PAGE . 'login');
        exit();
      }
    } else {
      // Invalid request method
      header("Location: " . PAGE . "invalid_page");
      exit();
    }
  }




  function invalid_page() //invalid the page if the method if doesn't exist
  {
    $data['current_page'] = "Invalid Page";
    $this->loadView("404", $data);
  }
}
