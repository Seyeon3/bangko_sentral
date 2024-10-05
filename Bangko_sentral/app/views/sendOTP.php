<?php $this->loadView("components/head", $data); ?>

<body>
    <?php $this->loadView("components/top-navbar", $data); ?>

    <style>
        /* Card styling to give a clean look */
        .card {
            border: 1px solid #002366; /* Dark blue border */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 20px; /* Margin for spacing */
        }

        /* OTP button with dark blue background and white text */
        .btn-primary {
            background-color: #002366; /* Dark blue */
            border-color: #002366;
            font-weight: bold;
            color: white;
        }

        /* Hover effect for the button */
        .btn-primary:hover {
            background-color: #001a4e; /* Slightly darker blue */
            border-color: #001a4e;
        }

        /* Input fields */
        .form-control {
            border: 1px solid #d9d9d9; /* Light border for inputs */
        }

        .form-floating label {
            color: #002366; /* Dark blue label */
        }

        /* Input borders when focused */
        .form-control:focus {
            border-color: #002366;
            box-shadow: none;
        }

        /* Alert message styling for success and error */
        .alert {
            padding: 10px;
            border-radius: 5px; /* Rounded corners for alerts */
            margin-bottom: 20px; /* Spacing between alerts and other elements */
        }

        .alert-danger {
            background-color: #D52B1E; /* Red background for errors */
            color: white;
        }

        .alert-success {
            background-color: #28a745; /* Green background for success */
            color: white;
        }

        /* OTP form header */
        h3 {
            color: #002366; /* Dark blue for the header */
        }

        /* Customize the card padding */
        .card-body {
            padding: 20px; /* Padding for the card body */
        }

        /* Center the card in the page */
        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="d-flex">
        <div class="card" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <div class="text-center">
                    <h3>Verify OTP</h3>
                </div>

                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($data['error'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($data['message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <form action="PasswordReset/reset-process" method="POST">
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            id="otp"
                            name="otp"
                            placeholder="Enter OTP"
                            required>
                        <label for="otp">Enter OTP</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                    Submit
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php $this->loadView("components/scripts"); ?>
</body>

</html>
