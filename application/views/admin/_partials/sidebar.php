<ul class="sidebar navbar-nav fontcustom">
    <li class="nav-item <?php echo $this->uri->segment(2) == '' ? 'active' : '' ?>">
        <a class="nav-link " href="<?php echo site_url('') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            Overview
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('upload') ?>">
            <i class="fas fa-fw fa-upload"></i>
            Upload Knowledge Base</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('aiml') ?>">
            <i class="fas fa-fw fa-cog"></i>
            Kelola Knowledge Base</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('admins') ?>">
            <i class="fas fa-fw fa-user"></i>
            Kelola Admin</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('SpellCheck') ?>">
            <i class="fas fa-fw fa-cog"></i>
            Kelola Spell Check</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('UnknownInput') ?>">
            <i class="fas fa-fw fas fa-comment-slash"></i>Percakapan Tidak Terjawab</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('ConvLog') ?>">
            <i class="fas fa-fw far fa-clock"></i>
            Riwayat Percakapan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('infobot') ?>">
            <i class="fas fa-fw fa-cog"></i>
            Ubah Info Bot</a>
    </li>

</ul>