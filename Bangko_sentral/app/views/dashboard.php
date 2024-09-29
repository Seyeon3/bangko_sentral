<?php $this->loadView("components/head", $data); ?>

<body>
  <div class="d-flex flex-row">
    <?php $this->loadView("components/admin-panel-aside-nav-left", $data); ?>

    <style>
      /* Dashboard Layout */
      body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa; /* Light background */
      }

      .container-fluid {
        background-color: #ffffff; /* White background for main content */
        border-left: 1px solid #002366;
      }

      .d-flex .aside-nav-left {
        background-color: #002366;
        color: #fff;
        width: 250px;
        min-height: 100vh;
        padding: 15px;
      }

      .aside-nav-left a {
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        display: block;
      }

      .aside-nav-left a:hover {
        background-color: #001a4e;
        border-radius: 5px;
      }

      /* Metric Card Styles */
      .metric-card {
        display: flex;
        align-items: center;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        color: #333;
      }

      .metric-icon {
        font-size: 2rem;
        color: #002366;
        margin-right: 15px;
      }

      .metric-info {
        flex-grow: 1;
      }

      .metric-info h4 {
        font-size: 1.2rem;
        color: #002366;
        margin-bottom: 5px;
        font-weight: bold;
      }

      .metric-info span {
        font-size: 1.5rem;
        font-weight: bold;
      }

      /* Media Queries for responsiveness */
      @media (max-width: 768px) {
        .metric-icon {
          font-size: 1.5rem;
        }

        .metric-info h4 {
          font-size: 1rem;
        }

        .metric-info span {
          font-size: 1.2rem;
        }
      }
    </style>

    <div class="container-fluid" style="height:100vh; overflow:auto;">
      <main class="p-4">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Metric Cards Section -->
        <div class="row mb-4">
          <!-- Total Users Card -->
          <div class="col-lg-4 col-md-6">
            <div class="metric-card">
              <i class="bi bi-person-fill metric-icon"></i>
              <div class="metric-info">
                <h4>Total Users</h4>
                <span><?php echo htmlspecialchars($data['total_users']); ?></span>
              </div>
            </div>
          </div>

          <!-- Total Deposits Card -->
          <div class="col-lg-4 col-md-6">
            <div class="metric-card">
              <i class="bi bi-piggy-bank-fill metric-icon"></i>
              <div class="metric-info">
                <h4>Total Deposits</h4>
                <span><?php echo htmlspecialchars(formatBalance($data['total_deposits'])); ?></span>
              </div>
            </div>
          </div>

          <!-- Total Withdrawals Card -->
          <div class="col-lg-4 col-md-6">
            <div class="metric-card">
              <i class="bi bi-wallet2 metric-icon"></i>
              <div class="metric-info">
                <h4>Total Withdrawals</h4>
                <span><?php echo htmlspecialchars(formatBalance($data['total_withdrawals'])); ?></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Other Sections (Login Attempts, Accounts, Withdrawals, Deposits) -->
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="card-title">Login Attempts</h4>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">User ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">IP Address</th>
                  <th scope="col">Login Time</th>
                  <th scope="col">Attempt</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($data['login_attempts_table'])): ?>
                  <?php foreach ($data['login_attempts_table'] as $row): ?>
                    <tr>
                      <th scope="row"><?php echo htmlspecialchars($row->login_attempt_id); ?></th>
                      <td><?php echo htmlspecialchars($row->user_id); ?></td>
                      <td><?php echo htmlspecialchars($row->username); ?></td>
                      <td><?php echo htmlspecialchars($row->ip_address != '::1' ? $row->ip_address : '127.0.0.1'); ?></td>
                      <td><?php echo datePrettierWithTime(htmlspecialchars($row->timestamp)); ?></td>
                      <td><?php echo $row->success ? '<span class="badge text-bg-success">Success</span>' : '<span class="badge text-bg-danger">Failed</span>'; ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">No login attempts found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Accounts -->
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="card-title">Accounts</h4>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Account Number</th>
                  <th scope="col">Username</th>
                  <th scope="col">Balance</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($data['accounts_table'])): ?>
                  <?php foreach ($data['accounts_table'] as $row): ?>
                    <tr>
                      <th scope="row"><?php echo htmlspecialchars($row->account_id); ?></th>
                      <td><?php echo htmlspecialchars($row->account_number); ?></td>
                      <td><?php echo htmlspecialchars($row->username); ?></td>
                      <td><?php echo htmlspecialchars(formatBalance($row->balance)); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center">No accounts found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Withdrawals -->
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="card-title">Withdrawal Records</h4>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Account Number</th>
                  <th scope="col">Username</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($data['withdrawals_table'])): ?>
                  <?php foreach ($data['withdrawals_table'] as $row): ?>
                    <tr>
                      <th scope="row"><?php echo htmlspecialchars($row->withdrawal_id); ?></th>
                      <td><?php echo htmlspecialchars($row->account_number); ?></td>
                      <td><?php echo htmlspecialchars($row->username); ?></td>
                      <td><?php echo htmlspecialchars(formatBalance($row->amount)); ?></td>
                      <td><?php echo datePrettier(htmlspecialchars($row->date)); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">No withdrawals found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Deposits -->
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="card-title">Deposit Records</h4>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Account Number</th>
                  <th scope="col">Username</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($data['deposits_table'])): ?>
                  <?php foreach ($data['deposits_table'] as $row): ?>
                    <tr>
                      <th scope="row"><?php echo htmlspecialchars($row->deposit_id); ?></th>
                      <td><?php echo htmlspecialchars($row->account_number); ?></td>
                      <td><?php echo htmlspecialchars($row->username); ?></td>
                      <td><?php echo htmlspecialchars(formatBalance($row->amount)); ?></td>
                      <td><?php echo datePrettier(htmlspecialchars($row->date)); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">No deposits found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>
  </div>

  <?php $this->loadView("components/scripts"); ?>
</body>

</html>
