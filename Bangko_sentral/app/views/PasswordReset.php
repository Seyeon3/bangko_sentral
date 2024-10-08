<?php $this->loadView("components/head", $data); ?>

<body>

  <?php $this->loadView("components/top-navbar", $data); ?>

  <style>
    /* Card styling for the reset password form */
    .card {
      border: 1px solid #002366;
      /* Dark blue border */
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Reset Password button with dark blue background and white text */
    .btn-primary {
      background-color: #002366;
      /* Dark blue */
      border-color: #002366;
      font-weight: bold;
      color: white;
    }

    /* Hover effect for the button */
    .btn-primary:hover {
      background-color: #001a4e;
      /* Slightly darker blue */
      border-color: #001a4e;
    }

    /* Input fields */
    .form-control {
      border: 1px solid #d9d9d9;
      /* Light border for inputs */
    }

    .form-floating label {
      color: #002366;
      /* Dark blue label */
    }

    /* Input borders when focused */
    .form-control:focus {
      border-color: #002366;
      box-shadow: none;
    }

    /* Error borders for input fields */
    .form-control.is-invalid {
      border-color: #D52B1E;
      /* Red error border */
    }

    /* Alert message styling for error */
    .alert {
      background-color: #D52B1E;
      /* Red background */
      color: white;
    }

    /* Form header styling */
    h3 {
      color: #002366;
      /* Dark blue for the header */
    }

    /* Customize the card padding */
    .card-body {
      padding: 20px;
    }

    /* Forgot password link styling */
    .forgot-password {
      text-align: center;
      margin-top: 10px;
    }

    .forgot-password a {
      color: #002366;
      text-decoration: none;
    }

    .forgot-password a:hover {
      text-decoration: underline;
    }
  </style>

  <div class="container d-flex flex-column align-items-center p-3">
    <div class="card w-100" style="max-width:400px;">
      <div class="card-body p-3">
        <div class="text-center">
          <h3>Reset Password</h3>
        </div>

        <?php if (!empty($data['form_errors'])) : ?>
          <div id="alertPlaceholder">
            <div class="alert alert-danger" role="alert">
              <ul class="mb-0">
                <?php foreach ($data['form_errors'] as $message): ?>
                  <li class="text-break"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endif; ?>

        <form action="<?= PAGE ?>PasswordReset/verifyOTP" method="POST">
          <div class="form-floating mb-3">
            <input
              id="inputEmail"
              type="email"
              class="form-control <?= !empty($data['form_errors']) ? 'is-invalid' : '' ?>"
              placeholder="name@example.com"
              value="<?= htmlspecialchars($data['email_value'], ENT_QUOTES, 'UTF-8') ?>"
              name="email"
              required>
            <label for="inputEmail">Email Address</label>
          </div>
          <div
            class="mb-3 d-flex justify-content-center border rounded p-3 <?= !empty($data['checkbox_recaptcha_red_border']) ? htmlspecialchars($data['checkbox_recaptcha_red_border'], ENT_QUOTES, 'UTF-8') : ''; ?>"
            style="background-image: url('assets/img/bg_for_recaptcha.png');">
            <div class="g-recaptcha" data-sitekey="6Lc4n1IqAAAAAFUyj58fyk15QKbvus58MDuevuv0"></div>
          </div>

          <div>
            <button id="buttonResetPassword" type="submit" class="btn btn-primary btn-lg w-100">
              <span class="button-text">Send OTP</span>
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <?php $this->loadView("components/scripts"); ?>
</body>

</html>