<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view("admin/_partials/head.php") ?>

</head>

<body id="page-top">
  <?php $this->load->view("admin/_partials/navbar.php") ?>
  <div id="wrapper">
    <!-- Sidebar -->
    <?php $this->load->view("admin/_partials/sidebar.php") ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <?php $this->load->view("admin/_partials/breadcrumb.php") ?>
        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Riwayat Percakapan

                </div>
                <?php
                $q_count1 = $this->db->query("SELECT COUNT(*)AS count FROM conversation_log")->row(); ?>
                <?php echo $q_count1->count; ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('convLog') ?>">
                <span class="float-left">Lihat</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-comment-slash "></i>
                </div>
                <div class="mr-5">Percakapan tidak terjawab
                </div>
                <?php
                $q_count1 = $this->db->query("SELECT COUNT(*)AS count FROM unknown_inputs")->row(); ?>
                <?php echo $q_count1->count; ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('unknownInput') ?>">
                <span class="float-left">Lihat</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="far fa-user"></i>
                </div>
                <div class="mr-5">Pengguna</div>
                <?php
                $q_count1 = $this->db->query("SELECT COUNT(*)AS count FROM users")->row(); ?>
                <?php echo $q_count1->count; ?>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('') ?>">
                <span class="float-left">Lihat</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-atom"></i>
                </div>
                <div class="mr-5">AIML</div>
                <?php
                $q_count1 = $this->db->query("SELECT COUNT(*)AS count FROM aiml")->row(); ?>
                <?php echo $q_count1->count; ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('aiml') ?>">
                <span class="float-left">Lihat</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <?php $this->load->view("admin/_partials/footer.php") ?>
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Scroll to Top Button-->
    <?php $this->load->view("admin/_partials/scrolltop.php") ?>
    <!-- Logout Modal-->
    <?php $this->load->view("admin/_partials/modal.php") ?>
    <!-- Javascript -->
    <?php $this->load->view("admin/_partials/js.php") ?>
</body>

</html>