            <aside class="sidebar">
                <div class="scrollbar-inner">
                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            <img class="user__img" src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/8.jpg" alt="">
                            <div>
                                <div class="user__name">Harllei Mazetti</div>
                                <div class="user__email">harlleimazetti@gmail.com</div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="">View Profile</a>
                            <a class="dropdown-item" href="">Settings</a>
                            <a class="dropdown-item" href="">Logout</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li class="navigation__active"><a href="<?php echo base_url() ?>/admin/dashboard"><i class="zmdi zmdi-home"></i> Home</a></li>

                        <li class="navigation__sub">
                            <a href=""><i class="zmdi zmdi-view-list"></i> Tables</a>
                            <ul>
                              <?php
                                foreach ($menus['tablesConfigurable'] as $menu) {
                              ?>
                                <li><a href="<?php echo base_url() ?>/admin/table/<?php echo $menu->path ?>"><?php echo $menu->name ?></a></li>
                              <?php } ?>
                            </ul>
                        </li>

                        <li><a href="<?php echo base_url() ?>/admin/controllers"><i class="zmdi zmdi-code-setting"></i> Controllers</a></li>

                        <li><a href="<?php echo base_url() ?>/admin/routes"><i class="zmdi zmdi-compass"></i> Routes</a></li>

                        <li><a href="<?php echo base_url() ?>/admin/menus"><i class="zmdi zmdi-menu"></i> Menus</a></li>

                        <li><a href="<?php echo base_url() ?>/admin/users"><i class="zmdi zmdi-accounts"></i> Users</a></li>

                    </ul>
                </div>
            </aside>

            <aside class="chat">
                <div class="chat__header">
                    <h2 class="chat__title">Chat <small>Currently 20 contacts online</small></h2>

                    <div class="chat__search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                </div>

                <div class="scrollbar-inner">
                    <div class="listview listview--hover chat__buddies">
                        <a class="listview__item chat__available">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/7.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>hey, how are you doing.</p>
                            </div>
                        </a>

                        <a class="listview__item chat__available">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>hmm...</p>
                            </div>
                        </a>

                        <a class="listview__item chat__away">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>all good</p>
                            </div>
                        </a>

                        <a class="listview__item">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/8.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>morbi leo risus portaac consectetur vestibulum at eros.</p>
                            </div>
                        </a>

                        <a class="listview__item">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/6.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>fusce dapibus</p>
                            </div>
                        </a>

                        <a class="listview__item chat__busy">
                            <img src="<?php echo base_url() ?>/ci4toolsadmin/assets/demo/img/profile-pics/9.jpg" class="listview__img" alt="">

                            <div class="listview__content">
                                <div class="listview__heading">Jeannette Lawson</div>
                                <p>cras mattis consectetur purus sit amet fermentum.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="messages.html" class="btn btn--action btn-danger"><i class="zmdi zmdi-plus"></i></a>
            </aside>