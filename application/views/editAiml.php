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
                        <a href="<?php echo site_url('aiml') ?>"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="card-body">

                        <form action="<?php base_url('aiml/add') ?>" method="post" enctype="multipart/form-data">
                            <input type="text" hidden name="id" value="<?php echo $product->id ?>" readonly />
                            <div class="form-group">
                                <label for="name">Pattern*</label>
                                <textarea class="form-control <?php echo form_error('pattern') ? 'is-invalid' : '' ?>" name="pattern"><?php echo $product->pattern ?></textarea>
                                <div class=" invalid-feedback">
                                    <?php echo form_error('pattern') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">That Pattern</label>
                                <textarea class="form-control <?php echo form_error('thatpattern') ? 'is-invalid' : '' ?>" name="thatpattern"><?php echo $product->pattern ?></textarea>
                                <div class=" invalid-feedback">
                                    <?php echo form_error('thatpattern') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Template*</label>
                                <textarea rows="4" cols="50" class="form-control <?php echo form_error('template') ? 'is-invalid' : '' ?>" name="template"><?php echo $product->template ?></textarea>
                                <div class=" invalid-feedback">
                                    <?php echo form_error('template') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Topic</label>
                                <input class="form-control <?php echo form_error('topic') ? 'is-invalid' : '' ?>" type="text" name="topic" value="<?php echo $product->topic ?>" />
                                <div class=" invalid-feedback">
                                    <?php echo form_error('topic') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">File name</label>
                                <input class="form-control <?php echo form_error('filename') ? 'is-invalid' : '' ?>" type="text" name="filename" value="<?php echo $product->filename ?>" />
                                <div class=" invalid-feedback">
                                    <?php echo form_error('filename') ?>
                                </div>
                            </div>
                            <input class="btn btn-success" type="submit" name="btn" value="Save" />
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