<?php 
$data['current_page'] = 'Invalid page';
include 'components/head.php'?>
<body>
  <div class="container-fluid" style="height:100vh; overflow:auto;">
    <div style="height:60px;"></div>
    <div class="d-flex justify-content-center mb-3">
      <div class="rounded-circle d-flex justify-content-center align-items-center bg-primary-subtle" style="height:70px; width:70px;">
        <i class="bi bi-file-earmark-x  fs-1 text-primary"></i>
      </div>
    </div>
    <div class="d-flex justify-content-center text-center mb-3">
      <span class="fs-1 text-primary fw-bold">
        Error 404 Page not found
      </span>
    </div>
    <div class="d-flex justify-content-center text-center">
      <span class="text-primary">
        The Page you are looking for doesn't exist
      </span>
    </div>
  </div>
  <?php include 'components/scripts.php'?>
</body>

</html>