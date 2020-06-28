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

                <!-- DataTables -->
                <div class="card mb-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>input</th>
                                        <th>user_id</th>
                                        <th>timestamp</th>
                                        <!-- <th>Action</th> -->

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($ui as $data_sp) : ?>
                                        <tr>
                                            <td width="50">
                                                <?php echo $data_sp->id ?>
                                            </td>
                                            <td>
                                                <?php echo $data_sp->input ?>
                                            </td>
                                            <td>
                                                <?php echo $data_sp->user_id ?>
                                            </td>
                                            <td>
                                                <?php echo $data_sp->timestamp ?>
                                            </td>
                                            <!-- <td width="250">

                                                <a href="<?php echo site_url('SpellCheck/edit/' . $data_sp->id) ?>" class="btn btn-small"><i class="fas fa-edit"></i> Ubah</a>
                                                <a onclick="deleteConfirm('<?php echo site_url('SpellCheck/delete/' . $data_sp->id) ?>')" href="#!" class="btn btn-small text-danger"><i class="fas fa-trash"></i> Hapus</a>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">

                        </div>
                    </div>
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