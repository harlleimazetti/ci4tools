<?php
	${{table}} = reset(${{table}});

  include('content_header.php');

  ${{class_name}}FormCustom = __DIR__.DIRECTORY_SEPARATOR.'{{class_name}}FormCustom.php';

  if (file_exists(${{class_name}}FormCustom)) {
    include({{class_name}}FormCustom);
  } else {
?>

  <div class="row">
    <div class="col-xl-12">
      <div id="panel-1" class="panel">
        <?php if (false) { ?>
        <div class="panel-hdr">
          <h2>
            Example <span class="fw-300"><i>Table</i></span>
          </h2>
        </div>
        <?php } ?>
        <div class="panel-container show mt-2">
          <div class="panel-content">
            <!--
            <div class="panel-tag">
              This example shows DataTables and the Responsive extension being used with the Bootstrap framework providing the styling. The DataTables / Bootstrap integration provides seamless integration for DataTables to be used in a Bootstrap page. <strong>Note</strong> that the <code>.dt-responsive</code> class is used to indicate to the extension that it should be enabled on this page, as responsive has special meaning in Bootstrap. The responsive option could also be used if required
            </div>
            -->
            <!-- Record form start -->
            <form method="post" action="<?php echo base_url(); ?>/sistema/{{table}}/store" class="form-record" enctype="multipart/form-data">
              
              {{{record_form_fields}}}

            </form>
            <!-- Record form end -->
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } include('content_footer.php'); ?>

<?php
/* End of File {{view_name}}Form.php */
?>