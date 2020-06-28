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
                        <a href="<?php echo site_url('Aiml/add') ?>"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Pattern</th>
                                        <th>Thatpattern</th>
                                        <th>Template</th>
                                        <th>Topic</th>
                                        <th>Filename</th>
                                        <th>Admin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($aiml as $data_aiml) : ?>
                                        <tr>
                                            <td width="50">
                                                <?php echo $data_aiml->id ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->pattern ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->thatpattern ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->template ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->topic ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->filename ?>
                                            </td>
                                            <td>
                                                <?php echo $data_aiml->nama ?>
                                            </td>
                                            <td width="250">
                                                <a href="<?php echo site_url('aiml/edit/' . $data_aiml->id) ?>" class="btn btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                                                <a onclick="deleteConfirm('<?php echo site_url('aiml/delete/' . $data_aiml->id) ?>')" href="#!" class="btn btn-sm text-danger"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
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