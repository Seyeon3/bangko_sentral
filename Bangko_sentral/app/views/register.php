<?php $this->loadView("components/head", $data); ?>

<body>

  <style>
    /* Card styling to give a clean look */
    .card {
      border: 1px solid #002366;
      /* Dark blue border */
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Register button with dark blue background and white text */
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
    .alert-danger {
      background-color: #D52B1E;
      /* Red background */
      color: white;
    }

    /* Success alert styling */
    .alert-success {
      background-color: #28a745;
      /* Green background for success */
      color: white;
    }

    /* Register form header */
    h3 {
      color: #002366;
      /* Dark blue for the header */
    }

    /* Customize the card padding */
    .card-body {
      padding: 20px;
    }
  </style>

  <?php $this->loadView("components/top-navbar", $data); ?>
  <div class="container d-flex flex-column align-items-center p-3">
    <div class="card w-100" style="max-width:400px;">
      <div class="card-body p-3">
        <div class="text-center">
          <h3>Register</h3>
        </div>
        <?php if (!empty($data['register_form_success_message'])) : ?>
          <div id="alertPlaceholder">
            <div class="alert alert-success" role="alert">
              <div>
                <i class="bi bi-check-circle me-3"></i>
                <span><?= $data['register_form_success_message'] ?></span>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($data['register_form_errors_messages'])) : ?>
          <div id="alertPlaceholder">
            <div class="alert alert-danger" role="alert">
              <ul class="mb-0">
                <?php foreach ($data['register_form_errors_messages'] as $message): ?>
                  <li class="text-break"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endif; ?>

        <form action="register/create" method="POST">
          <div class="mb-3 form-floating">
            <input
              type="text"
              class="form-control <?= $data['input_full_name_red_border'] ?>"
              id="full_name"
              name="full_name"
              placeholder=""
              value="<?= $data['input_full_name_value'] ?>"
              required>
            <label for="name" class="form-label">Full Name</label>
          </div>
          <div class="mb-3 form-floating">
            <input
              type="text"
              class="form-control <?= $data['input_username_red_border'] ?>"
              id="username"
              name="username"
              placeholder=""
              value="<?= $data['input_username_value'] ?>"
              required>
            <label for="username" class="form-label">Username</label>
          </div>
          <div class="mb-3 form-floating">
            <input
              type="password"
              class="form-control <?= $data['input_password_red_border'] ?>"
              id="password"
              name="password"
              placeholder=""
              value=""
              required>
            <label for="password" class="form-label">Password</label>
          </div>
          <div
            class="mb-3 d-flex justify-content-center border rounded p-3 <?= $data['checkbox_recaptcha_red_border'] ?>"
            style="background-image: url('assets/img/bg_for_recaptcha.png');">
            <div class="g-recaptcha" data-sitekey="6Lc4n1IqAAAAAFUyj58fyk15QKbvus58MDuevuv0"></div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg w-100">Register</button>
        </form>

      </div>
    </div>
  </div>

  <?php $this->loadView("components/scripts"); ?>

</body>

</html>