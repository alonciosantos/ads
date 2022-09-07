<div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
    <div class="sidebar">
        <!-- User Widget -->
        <div class="widget user-dashboard-profile">
            <!-- User Image -->
            
            <!-- User Name -->
            <h5 class="text-center"><?php echo auth()->user()->name ?? auth()->user()->username ;?></h5>
            <p><?php echo lang('App.sidebar.dashboard.user_since'); ?> <?php echo auth()->user()->created_at->humanize() ;?></p>
            <a href="<?php echo route_to('profile'); ?>" class="btn btn-main-sm"><?php echo lang('App.sidebar.dashboard.edit_profile');?></a>
        </div>
        <!-- Dashboard Links -->
        <div class="widget user-dashboard-menu">
            <ul>
            
                <li class="<?php echo url_is("{$locale}/dashboard/")?'active':'';?>"><a class="btn-gn" href="<?php echo route_to('dashboard') ?>"><i class="fa fa-home"></i> <?php echo lang('App.sidebar.dashboard.dashboard');?></a></li>
                <li class="<?php echo url_is("{$locale}/dashboard/my-plan")?'active':'';?>"><a class="btn-gn" href="<?php echo route_to('my.plan') ?>"><i class="fa fa-bookmark-o"></i> <?php echo lang('App.sidebar.dashboard.my_plan');?></a></li>
                <li class="<?php echo url_is("{$locale}/dashboard/adverts/my")?'active':'';?>"><a class="btn-gn" href="<?php echo route_to('my.adverts') ?>"><i class="fa fa-user"></i> <?php echo lang('App.sidebar.dashboard.my_adverts');?></a></li>
                <li class="<?php echo url_is("{$locale}/dashboard/adverts/my-archived")?'active':'';?>"><a class="btn-gn" href="<?php echo route_to('my.archived.adverts') ?>"><i class="fa fa-file-archive-o"></i><?php echo lang('App.sidebar.dashboard.archived_my_adverts');?><span>12</span></a></li>
                <li <?php echo url_is("{$locale}/dashboard/adverts/my-pending-adverts")?'active':'';?>><a class="btn-gn" class="btn-gn" href="<?php echo route_to('my.pending.adverts') ?>"><i class="fa fa-bolt"></i> <?php echo lang('App.sidebar.dashboard.pending');?><span>23</span></a></li>
                <li><?php echo form_open('logout'); ?>
                
                <?php echo csrf_field(); ?>
                  
                    <button type="submit" class="btn btn-gn  btn-default bg-white p-0 py-2 pl-2 text-dark"><i class="fa fa-cog"></i> <?php echo lang('App.btn_logout'); ?></button>

                    <?php echo form_close(); ?></li>
                <li class="<?php echo url_is("{$locale}/dashboard/confirm-deletion-account")?'active ':'';?>">
                <a class="btn-bg " href="<?php echo route_to("confirm.deletion.account");?>"><i class="fa fa-power-off text-danger"></i><?php echo lang('App.sidebar.dashboard.delete_account');?></a></li>
            </ul>
        </div>
    </div>
</div>