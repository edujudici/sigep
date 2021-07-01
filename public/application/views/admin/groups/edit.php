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
                                    <h3 class="box-title"><?php echo lang('groups_edit_group'); ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $message;?>

                                    <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-edit_group')); ?>
                                        <div class="form-group">
                                            <?php echo lang('groups_name', 'group_name', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($group_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('groups_description', 'description', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($group_description); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('groups_color', 'bgcolor', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-3">
                                                <?php echo form_input($group_bgcolor); ?>
                                            </div>
                                        </div>
  

                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_user_panel'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="user_panel" id="user_panel1" value="1" <?= set_value('user_panel', $group->user_panel) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="user_panel" id="user_panel0" value="0" <?php echo set_value('user_panel', $group->user_panel) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_sidebar_form'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="sidebar_form" id="sidebar_form1" value="1" <?php echo set_value('sidebar_form', $group->sidebar_form) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sidebar_form" id="sidebar_form0" value="0" <?php echo set_value('sidebar_form', $group->sidebar_form) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_messages_menu'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="messages_menu" id="messages_menu1" value="1" <?php echo set_value('messages_menu', $group->messages_menu) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="messages_menu" id="messages_menu0" value="0" <?php echo set_value('messages_menu', $group->messages_menu) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_notifications_menu'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="notifications_menu" id="notifications_menu1" value="1" <?php echo set_value('notifications_menu', $group->notifications_menu) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="notifications_menu" id="notifications_menu0" value="0" <?php echo set_value('notifications_menu', $group->notifications_menu) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_tasks_menu'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tasks_menu" id="tasks_menu1" value="1" <?php echo set_value('tasks_menu', $group->tasks_menu) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="tasks_menu" id="tasks_menu0" value="0" <?php echo set_value('tasks_menu', $group->tasks_menu) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_user_menu'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="user_menu" id="user_menu1" value="1" <?php echo set_value('user_menu', $group->user_menu) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="user_menu" id="user_menu0" value="0" <?php echo set_value('user_menu', $group->user_menu) == 0 ? 'checked' : NULL; ?> disabled> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group hidden <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"> <?php echo lang('prefs_ctrl_sidebar'); ?> </label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="ctrl_sidebar" id="ctrl_sidebar1" value="1" <?php echo set_value('ctrl_sidebar', $group->ctrl_sidebar) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="ctrl_sidebar" id="ctrl_sidebar0" value="0" <?php echo set_value('ctrl_sidebar', $group->ctrl_sidebar) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label"><?php echo lang('prefs_transition_page'); ?></label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="transition_page" id="transition_page1" value="1" <?php echo set_value('transition_page', $group->transition_page) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="transition_page" id="transition_page0" value="0" <?php echo set_value('transition_page', $group->transition_page) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label">Gerar Etiquetas</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tags" id="transition_page1" value="1" <?php echo set_value('tags', $group->tags) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="tags" id="tags" value="0" <?php echo set_value('tags', $group->tags) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label">Lista de Postagem</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="plp" id="plp" value="1" <?php echo set_value('plp', $group->plp) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="plp" id="transition_page0" value="0" <?php echo set_value('plp', $group->plp) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>">
                                            <label class="col-sm-2 control-label">Relatorios</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="reports" id="reports" value="1" <?php echo set_value('reports', $group->reports) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="reports" id="transition_page0" value="0" <?php echo set_value('reports', $group->reports) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                            </div>
                                        </div>  
                                        <div class="form-group <?= ($group->id == 1) ? 'hidden' : '' ?>" style="background: #a70707b3; padding: 10px ; color: white; ">
                                            <label class="col-sm-2 control-label ">BLOQUEADO</label>
                                            <div class="col-sm-10">
                                                <label class="radio-inline">
                                                    <input type="radio" name="ban" id="ban" value="0" <?php echo set_value('ban', $group->ban) == 0 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_no')); ?>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="ban" id="ban" value="1" <?php echo set_value('ban', $group->ban) == 1 ? 'checked' : NULL; ?>> <?php echo strtoupper(lang('actions_yes')); ?>
                                                </label>                                                
                                            </div>
                                        </div>  

   
                                      <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/groups', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                    
                                                </div>
                                                <div class="pull-right <?= ($group->id == 1) ? 'hidden' : '' ?>"><?php echo anchor('admin/groups/delete/'. $group->id.'/', 'Excluir', array('class' => ' btn btn-danger btn-flat')); ?></div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>

