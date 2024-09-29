<aside class="border-end" style="width: 333px; height:100vh;">

  <ul class="nav d-flex flex-column border-bottom">
    <li class="nav-item" style="height:60px;">
      <a class="nav-link d-flex align-items-center h-100">
        <img src="logo.png" alt="Logo" width="30" height="30" class="ms-2 me-3">
        <span>PNB Admin Panel</span>
      </a>
    </li>
  </ul>

  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-secondary active" href="#"><i class="bi bi-speedometer2 m-3 fs-5"></i>Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-secondary" href=""><i class="bi bi-person-circle m-3 fs-5"></i><?= $_SESSION['full_name'] ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="logout"><i class="bi bi-box-arrow-left m-3 fs-5"></i>Logout</a>
    </li>
  </ul>
</aside>