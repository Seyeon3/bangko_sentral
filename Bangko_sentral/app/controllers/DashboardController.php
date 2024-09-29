<?php
class DashboardController extends Controller
{
  public function __construct()
  {
    if (!isset($_SESSION['user_id'])) {
      header("Location: " . PAGE);
      exit();
    }
  }

  function index()
  {
    $data['current_page'] = "Dashboard";
    
    // Load the UserModel to interact with the database
    $USER = $this->loadModel("UserModel");

    // Fetch login attempts, accounts, withdrawals, and deposits data
    $data['login_attempts_table'] = $USER->selectAllLoginAttempts();
    $data['accounts_table'] = $USER->selectAllAccounts();
    $data['withdrawals_table'] = $USER->selectAllWithdrawals();
    $data['deposits_table'] = $USER->selectAllDeposits();

    // Calculate the total number of users
    $data['total_users'] = count($data['accounts_table']);

    // Calculate total deposits and total withdrawals
    $data['total_deposits'] = 0;
    foreach ($data['deposits_table'] as $deposit) {
      $data['total_deposits'] += $deposit->amount;
    }

    $data['total_withdrawals'] = 0;
    foreach ($data['withdrawals_table'] as $withdrawal) {
      $data['total_withdrawals'] += $withdrawal->amount;
    }

    // Load the view and pass the data
    $this->loadView("dashboard", $data);
  }
  
  function invalid_page()
  {
    $data['current_page'] = "Invalid Page";
    $this->loadView("404", $data);
  }
}
