<?php
class RegisterController extends Controller
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
    $data['current_page'] = "Register";
    $data['register_form_success_message'] = $_SESSION['register_form_success_message'] ?? null;
    $data['register_form_errors_messages'] = $_SESSION['register_form_errors_messages'] ?? null;

    //errors red border
    $data['input_full_name_red_border'] = !empty($data['register_form_errors_messages']) && in_array("Full Name must be greater than 3 characters and less than 20 characters.", $_SESSION['register_form_errors_messages']) ? 'is-invalid' : '';
    $data['input_username_red_border'] = !empty($data['register_form_errors_messages']) && in_array("Username must be greater than 3 characters and less than 20 characters.", $_SESSION['register_form_errors_messages']) ? 'is-invalid' : '';
    $data['input_password_red_border'] = !empty($data['register_form_errors_messages']) && in_array("Password must contain at least one uppercase letter, one lowercase letter, and one number.", $_SESSION['register_form_errors_messages']) ? 'is-invalid' : '';
    $data['checkbox_recaptcha_red_border'] = !empty($data['register_form_errors_messages']) && in_array("reCAPTCHA verification failed. Please try again.", $_SESSION['register_form_errors_messages']) ? 'border-danger' : '';

    //save input
    $data['input_full_name_value'] = $_SESSION['input_full_name'] ?? '';
    $data['input_username_value'] = $_SESSION['input_username'] ?? '';

    $this->loadView("register", $data);

    unset($_SESSION['register_form_errors_messages']);
    unset($_SESSION['input_full_name']);
    unset($_SESSION['input_username']);
    unset($_SESSION['register_form_success_message']);
  }

  function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $_SESSION['register_form_errors_messages'] = [];
      $_SESSION['input_full_name'] = htmlspecialchars($_POST['full_name'], ENT_QUOTES, 'UTF-8');
      $_SESSION['input_username'] = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');

      //validation
      if (strlen($_SESSION['input_full_name']) < 3 || strlen($_SESSION['input_full_name']) > 20) {
        $_SESSION['register_form_errors_messages'][] = "Full Name must be greater than 3 characters and less than 20 characters.";
      }

      if (strlen($_SESSION['input_username']) < 3 || strlen($_SESSION['input_username']) > 20) {
        $_SESSION['register_form_errors_messages'][] = "Username must be greater than 3 characters and less than 20 characters.";
      }

      // Check for password complexity (at least one number, one uppercase letter, one lowercase letter)
      if (
        !preg_match('/[A-Z]/', $_POST['password']) ||
        !preg_match('/[a-z]/', $_POST['password']) ||
        !preg_match('/[0-9]/', $_POST['password'])
      ) {
        $_SESSION['register_form_errors_messages'][] = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
      }

      if (!empty($_SESSION['register_form_errors_messages'])) {
        header('Location: ' . PAGE . 'register');
        exit();
      }

      // reCAPTCHA verification
      $recaptcha_secret = "6Lc4n1IqAAAAAIpW28YulU6ZoSQ2mZn0RYJTfrdR";
      $recaptcha_response = $_POST['g-recaptcha-response'];
      $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
      $response_data = json_decode($verify_response);

      if (!$response_data->success) {
        // reCAPTCHA validation failed
        $_SESSION['register_form_errors_messages'][] = "reCAPTCHA verification failed. Please try again.";
        header('Location: ' . PAGE . 'register');
        exit();
      }

      $REGISTER = $this->loadModel("UserModel");
      $returnResult = $REGISTER->create($_POST);

      if ($returnResult) {
        $_SESSION['register_form_success_message'] = "Registration Successful.";
        unset($_SESSION['input_full_name']);
        unset($_SESSION['input_username']);
        header('Location: ' . PAGE . 'register');
        exit();
      } else {
        $_SESSION['register_form_errors_messages'][] = "Registration Failed.";
        header('Location: ' . PAGE . 'register');
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
