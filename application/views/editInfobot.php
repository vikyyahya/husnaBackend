<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">
    <?php $this->load->view("admin/_partials/navbar.php") ?>
    <div id="wrapper">

        <?php $this->load->view("admin/_partials/sidebar.php") ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <?php $this->load->view("admin/_partials/breadcrumb.php") ?>

                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <div class="card mb-3">
                    <div class="card-header">
                        <a href="<?php echo site_url('infobot') ?>"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">

                        <form action="<?php base_url('infobot/edit') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input class="form-control <?php echo form_error('kelas') ? 'is-invalid' : '' ?>" type="hidden" name="bot_id" value="<?php echo $product->bot_id ?>" readonly />
                                <div class="invalid-feedback">
                                    <?php echo form_error('id') ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Bot Name*</label>
                                <input class="form-control <?php echo form_error('user_name') ? 'is-invalid' : '' ?>" type="text" name="bot_name" value="<?php echo $product->bot_name ?>" />
                                <div class="invalid-feedback">
                                    <?php echo form_error('name') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Error Response*</label>
                                <input class="form-control <?php echo form_error('password') ? 'is-invalid' : '' ?>" type="text" name="" value="<?php echo $product->error_response ?>" />
                                <div class="invalid-feedback">
                                    <?php echo form_error('price') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama*</label>
                                <input class="form-control <?php echo form_error('nama') ? 'is-invalid' : '' ?>" type="text" name="nama" min="1" value="<?php echo $product->nama ?>" placeholder="Nama" />
                                <div class="invalid-feedback">
                                    <?php echo form_error('price') ?>
                                </div>
                            </div>


                            <input class="btn btn-success" type="submit" name="btn" value="Simpan" />
                        </form>

                    </div>

                    <div class="card-footer small text-muted">
                        * required fields
                    </div>


                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                <?php $this->load->view("admin/_partials/footer.php") ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->


        <?php $this->load->view("admin/_partials/scrolltop.php") ?>
        <?php $this->load->view("admin/_partials/modal.php") ?>
        <?php $this->load->view("admin/_partials/js.php") ?>

</body>

</html>