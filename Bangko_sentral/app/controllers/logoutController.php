<?php

class LogoutController extends Controller
{
  function index()
  {
    session_destroy();
    header("Location:" . PAGE);
    exit();
  }
}
