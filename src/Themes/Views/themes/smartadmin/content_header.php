                    <!-- BEGIN Page Content -->
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <main id="js-page-content" role="main" class="page-content">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>/dashboard">Início</a></li>
                            <li class="breadcrumb-item active"><?php echo $page_title ?></li>
                            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class=""><?php echo utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))) ?></span></li>
                        </ol>
                        <div class="subheader">
                            <h1 class="subheader-title">
                                <i class='subheader-icon <?php echo $page_icon ?>'></i>
                                <?php echo $page_title ?> <span class='fw-300'><?php echo $page_subtitle ?></span>
                                <!--<sup class='badge badge-primary fw-500'>STICKER</sup>-->
                                <small>
                                  <?php echo $page_description ?>
                                </small>
                            </h1>
                            <!-- 
		Right content on content header
		A nice area to add graphs or buttons -->
                            <div class="subheader-block">
                                <!--Right Subheader Block-->
                            </div>
                        </div>
                        <!--
                        <div class="alert alert-primary">
                            <div class="d-flex flex-start w-100">
                                <div class="mr-2 hidden-md-down">
                                    <span class="icon-stack icon-stack-lg">
                                        <i class="base base-6 icon-stack-3x opacity-100 color-primary-500"></i>
                                        <i class="base base-10 icon-stack-2x opacity-100 color-primary-300 fa-flip-vertical"></i>
                                        <i class="ni ni-blog-read icon-stack-1x opacity-100 color-white"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-fill">
                                    <div class="flex-fill">
                                        <span class="h5">Pro Tip!</span>
                                        <p>
                                            If you don't know where to start, this is a good page to start your application. It comes with the basics to get you started. Contains a good inline documentation and waypoints to guide you with your project. Use this area of the page as an attention grabber. Users are likely to respond or pay attention when you involve a color icon along with your information (as displayed here on the left).
                                        </p>
                                        <p class="m-0">
                                            Follow a slogal with a useful link or call to action <a href="#" target="_blank">Call to action >></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->