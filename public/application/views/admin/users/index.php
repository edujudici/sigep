<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('admin/users/create', '<i class="fa fa-plus"></i> '. lang('users_create_user'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('users_firstname');?></th>
                                                <th><?php echo lang('users_lastname');?></th>
                                                <th><?php echo lang('users_email');?></th>
                                                <th>Grupo</th>
                                                <th>Status</th>
                                                <th>Etiquetas Emitidas</th>
                                                <th><?php echo lang('users_action');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user):?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td>
                                                <?php
                                                foreach ($user->groups as $group)
                                                {
                                                    echo anchor('admin/groups/edit/'.$group->id, '<span class="label label-default">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
                                                }
                                                ?>
                                                </td>

                                                <td><?php echo ($user->active) ? anchor('admin/users/deactivate/'.$user->id, '<span class="label label-success">'.lang('users_active').'</span>') : anchor('admin/users/activate/'. $user->id, '<span class="label label-default">'.lang('users_inactive').'</span>'); ?></td>
                                                <td><?= $this->db->like("dt_emissao", date('m-Y'))->where('user_id', $user->id)->get('etiquetas')->num_rows(); ?> <?=  'de <b>'.$user->limit_tags.'</b> p/ mês'; ?></td>
                                                <td>
                                                    <a href="<?php echo site_url('admin/users/edit/'.$user->id); ?>" class="btn btn-primary" style="color: white;"> <i class="fa fa-edit"></i> </a>
                                                    <a href="<?php echo site_url('admin/users/profile/'.$user->id); ?>" class="btn btn-default" style="margin-left: 15px;"> <i class="fa fa-eye"></i> </a>
                                                    
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
