<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <aside class="main-sidebar">
                <section class="sidebar">
<?php if ($admin_prefs['user_panel'] == TRUE): ?>
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $user_login['firstname'].$user_login['lastname']; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('menu_online'); ?></a>
                        </div>
                    </div>

<?php endif; ?>
<?php if ($admin_prefs['sidebar_form'] == TRUE): ?>
                    <!-- Search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="<?php echo lang('menu_search'); ?>...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>

<?php endif; ?>
                    <!-- Sidebar menu -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="<?php echo site_url('/'); ?>">
                                <i class="fa fa-home text-primary"></i> <span><?php echo lang('menu_access_website'); ?></span>
                            </a>
                        </li>

                        <li class="header text-uppercase"><?php echo lang('menu_main_navigation'); ?></li>
                        <li class="<?=active_link_controller('dashboard')?>">
                            <a href="<?php echo site_url('admin/dashboard'); ?>">
                                <i class="fa fa-dashboard"></i> <span><?php echo lang('menu_dashboard'); ?></span>
                            </a>
                        </li>

                        <?php if ($this->ion_auth->is_admin()): ?>
                        <li class="header text-uppercase"><?php echo lang('menu_administration'); ?></li>
                        <li class="<?=active_link_controller('users')?>">
                            <a href="<?php echo site_url('admin/users'); ?>">
                                <i class="fa fa-user"></i> <span><?php echo lang('menu_users'); ?></span>
                            </a>
                        </li>
                        <li class="<?=active_link_controller('groups')?>">
                            <a href="<?php echo site_url('admin/groups'); ?>">
                                <i class="fa fa-shield"></i> <span><?php echo lang('menu_security_groups'); ?></span>
                            </a>
                        </li>
                        <li class="<?=active_link_controller('contrato')?>">
                            <a href="<?php echo site_url('admin/contrato'); ?>">
                                <i class="fa fa-handshake-o"></i> <span>CONTRATO</span>
                            </a>
                        </li>
                        <?php endif ?>

                        <?php if ($this->ion_auth->is_acesso('tags')): ?>
                        <li class="header text-uppercase"><?php echo $title; ?></li>
                        <li class="<?=active_link_controller('etiqueta')?>">
                            <a href="<?php echo site_url('admin/etiqueta'); ?>">
                                <i class="fa fa-print"></i> <span>Etiqueta</span>
                            </a>
                        </li>                            
                        <?php endif ?>
                        <?php if ($this->ion_auth->is_acesso('reports')): ?>
                        <li class="<?=active_link_controller('relatorio')?>">
                            <a href="<?php echo site_url('admin/relatorio'); ?>">
                                <i class="fa fa-list"></i> <span>RELATORIO</span>
                            </a>
                        </li>  
                        <?php endif ?>

                    </ul>
                </section>
            </aside>
