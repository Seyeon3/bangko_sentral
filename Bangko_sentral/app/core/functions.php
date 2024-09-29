<?php
// Explicit function created by programmer 

function formatBalance($amount) {
  // Ensure the amount is a number and format it
  if (is_numeric($amount)) {
      return '₱' . number_format($amount, 2); // Format with 2 decimal places
  } else {
      return '₱0.00'; // Default to zero if the input is not a number
  }
}


function getUserIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    // Check if the IP is from the shared Internet
    return $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    // Check for forwarded IP addresses
    return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ','); // Get the first IP in the list
  }

  // Return the remote IP address
  return $_SERVER['REMOTE_ADDR'];
}

function getUserOperatingSystem($user_agent)
{
  // Define an array to hold the operating system information
  $os_platform = "Unknown OS";

  // Check for different operating systems in the User-Agent string
  if (preg_match('/windows/i', $user_agent)) {
    $os_platform = 'Windows';
  } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
    $os_platform = 'Mac OS';
  } elseif (preg_match('/linux/i', $user_agent)) {
    $os_platform = 'Linux';
  } elseif (preg_match('/android/i', $user_agent)) {
    $os_platform = 'Android';
  } elseif (preg_match('/iphone|ipad|ipod/i', $user_agent)) {
    $os_platform = 'iOS';
  }

  return $os_platform;
}

function sessionFloatingAlert($type, $message)
{
  if (isset($_SESSION['floating_alert']) && $_SESSION['floating_alert'] === $message) {
    echo '
    <div id="sessionFloatingAlert" class="floating-alert alert alert-' . $type . ' d-flex w-100 shadow" role="alert">
      <span class="text mx-auto">' . $message . '.</span>
    </div>';
    unset($_SESSION['floating_alert']);
  }
}

function uppercaseFirstLetter($str)
{
  return ucfirst($str);
}

function manilaTimeZone($format)
{
  $manilaTimezone = new DateTimeZone('Asia/Manila');
  $currentDateTimeManila = new DateTime('now', $manilaTimezone);
  $formattedDateTime = $currentDateTimeManila->format($format);
  return $formattedDateTime;
}

function show($stuff)
{
  echo "<pre>";
  print_r($stuff);
  echo "</pre>";
}
function showAllSession()
{
  foreach ($_SESSION as $key => $value) {
    echo $key . ' = ' . $value . '<br>';
  }
}
function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $randomString;
}
function datePrettier($inputDate)
{
  $timestamp = strtotime($inputDate);
  if ($timestamp === false) {
    return "Invalid date format";
  }
  $formattedDate = date("F d, Y", $timestamp); // Use 'd' for two-digit day
  return $formattedDate;
}
function datePrettierWithTime($inputDate)
{
  $timestamp = strtotime($inputDate);
  if ($timestamp === false) {
    return "Invalid date format";
  }
  $formattedDate = date("F d, Y, g:i A", $timestamp); // Use 'd' for two-digit day
  return $formattedDate;
}
function relativeTime($timestamp)
{
  date_default_timezone_set('Asia/Manila');
  $currentTimestamp = time();
  $timestamp = strtotime($timestamp);
  $difference = $currentTimestamp - $timestamp;

  if ($difference < 60) {
    return "just now";
  } elseif ($difference < 3600) {
    $minutes = floor($difference / 60);
    return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
  } elseif ($difference < 86400) {
    $hours = floor($difference / 3600);
    return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
  } else {
    return date("F d, Y H:i A", $timestamp);
  }
}

function isNullDate($datetime)
{
  if ($datetime == null) {
    return "-- -- --";
  } else {
    return datePrettierWithTime($datetime);
  }
}
