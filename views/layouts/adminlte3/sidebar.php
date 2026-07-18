<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
        <img src="<?= Yii::getAlias('@web/images/loge.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">One Movement Inc.</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
                <?php else: ?>
                    <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>" class="d-block"> <i class="fas fa-sign-in-alt"></i> Login</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent',
                    'data-widget' => 'treeview',
                    'role' => 'menu',
                    'data-accordion' => 'false'
                ],


                'items' => [
                    ['label' => 'DASHBOARD', 'url' => ['/admin/dashboard/v1'], 'icon' => 'tachometer-alt', 'visible' => Yii::$app->user->can('access admin module')],


                    ['label' => '', 'header' => true],
                    ['label' => 'MODULES', 'header' => true, 'visible' => !Yii::$app->user->isGuest],
                    [
                        'label' => 'Admin',
                        'items' => [
                            ['label' => 'User Management', 'url' => ['/admin/user/index'], 'iconStyle' => 'far'],
                            [
                                'label' => 'RBAC',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Users', 'url' => ['/rbac/user/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Assignments', 'url' => ['/rbac/assignment/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Roles', 'url' => ['/rbac/role/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Permissions', 'url' => ['/rbac/permission/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Routes', 'url' => ['/rbac/route/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Rules', 'url' => ['/rbac/rule/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    // ['label' => 'Menus', 'url' => ['/rbac/menu/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                ],
                            ],
                        ],
                        'visible' => Yii::$app->user->can('access rbac module'),
                    ],
                    ['label' => 'Applicants', 'url' => ['/applicant/index'], 'visible' => Yii::$app->user->can('access applicants')],
                    [
                        'label' => 'OMI Groups',
                        'items' => [
                            ['label' => 'Alliance', 'url' => ['/alliance/index'], 'visible' => Yii::$app->user->can('access alliance group'), 'iconStyle' => 'far'],
                            ['label' => 'OMI Organic', 'url' => ['/group-organic/index'], 'iconStyle' => 'far'],
                            ['label' => 'Sectorial', 'url' => ['/group-sectorial/index'], 'iconStyle' => 'far'],
                        ],
                        'visible' => Yii::$app->user->can('access alliance group'),
                    ],
                    ['label' => 'OMI Members', 'url' => ['/member/index'], 'visible' => Yii::$app->user->can('access omi members')],
                    ['label' => 'OMI Activities', 'url' => ['/activity/index'], 'visible' => Yii::$app->user->can('access omi activities')],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>