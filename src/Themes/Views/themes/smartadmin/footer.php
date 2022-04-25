
                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                    <!-- BEGIN Page Footer -->
                    <footer class="page-footer" role="contentinfo">
                        <div class="d-flex align-items-center flex-1 text-muted">
                            <span class="hidden-md-down fw-700">2020 © SmartAdmin by&nbsp;<a href='https://www.gotbootstrap.com' class='text-primary fw-500' title='gotbootstrap.com' target='_blank'>gotbootstrap.com</a></span>
                        </div>
                        <div>
                            <ul class="list-table m-0">
                                <li><a href="intel_introduction.html" class="text-secondary fw-700">About</a></li>
                                <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">License</a></li>
                                <li class="pl-3"><a href="info_app_docs.html" class="text-secondary fw-700">Documentation</a></li>
                                <li class="pl-3 fs-xl"><a href="https://wrapbootstrap.com/user/MyOrange" class="text-secondary" target="_blank"><i class="fal fa-question-circle" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </footer>
                    <!-- END Page Footer -->
                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->

        <!-- base vendor bundle: 
			 DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations 
						+ pace.js (recommended)
						+ jquery.js (core)
						+ jquery-ui-cust.js (core)
						+ popper.js (core)
						+ bootstrap.js (core)
						+ slimscroll.js (extension)
						+ app.navigation.js (core)
						+ ba-throttle-debounce.js (core)
						+ waves.js (extension)
						+ smartpanels.js (extension)
						+ src/../jquery-snippets.js (core) -->
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/vendors.bundle.js"></script>
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/datagrid/datatables/datatables.bundle.js"></script>
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/app.bundle.js"></script>
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/formplugins/select2/select2.bundle.js"></script>
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/fileupload/jquery.fileupload.js"></script>
        <script src="<?php echo base_url(); ?>/public/themes/smartadmin/assets/js/notifications/toastr/toastr.js"></script>
        <script src="<?php echo base_url(); ?>/public/assets/js/libraries/axios/axios.min.js"></script>
        <script src="<?php echo base_url(); ?>/public/assets/js/libraries/js.cookie/js.cookie.min.js"></script>
        <script src="<?php echo base_url(); ?>/public/assets/js/javascripts.js" type="module"></script>
    </body>
    <!-- END Body -->
</html>
