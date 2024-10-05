<?php $this->loadView("components/head", $data); ?>

<body>
    <?php $this->loadView("components/top-navbar", $data); ?>

    <style>
        .card {
            border: 1px solid #002366; /* Dark blue border */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 20px; /* Margin for spacing */
        }

        .btn-primary {
            background-color: #002366; /* Dark blue */
            border-color: #002366;
            font-weight: bold;
            color: white;
        }

        .btn-primary:hover {
            background-color: #001a4e; /* Slightly darker blue */
            border-color: #001a4e;
        }

        .form-control {
            border: 1px solid #d9d9d9; /* Light border for inputs */
        }

        .form-floating label {
            color: #002366; /* Dark blue label */
        }

        .form-control:focus {
            border-color: #002366;
            box-shadow: none;
        }

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

        h3 {
            color: #002366; /* Dark blue for the header */
        }

        .card-body {
            padding: 20px; /* Padding for the card body */
        }

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
                    <h3>Reset Password</h3>
                </div>

                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($data['error'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= PAGE; ?>PasswordReset" method="POST"> <!-- Ensure this matches your routing -->
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control"
                            id="current_password"
                            name="current_password"
                            placeholder="Current Password"
                            required>
                        <label for="current_password">Current Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control"
                            id="new_password"
                            name="new_password"
                            placeholder="New Password"
                            required>
                        <label for="new_password">New Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php $this->loadView("components/scripts"); ?>
</body>
</html>
