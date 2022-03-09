<?php
	${{table}} = reset(${{table}});
?>
<?php include('content_header.php'); ?>
  <div class="row">
    <div class="col-xl-12">
      <div id="panel-1" class="panel">
        <div class="panel-hdr">
          <h2>
            Example <span class="fw-300"><i>Table</i></span>
          </h2>
        </div>
        <div class="panel-container show">
          <div class="panel-content">
            <!--
            <div class="panel-tag">
              This example shows DataTables and the Responsive extension being used with the Bootstrap framework providing the styling. The DataTables / Bootstrap integration provides seamless integration for DataTables to be used in a Bootstrap page. <strong>Note</strong> that the <code>.dt-responsive</code> class is used to indicate to the extension that it should be enabled on this page, as responsive has special meaning in Bootstrap. The responsive option could also be used if required
            </div>
            -->
            <!-- Record form start -->
            <form method="post" action="<?php echo base_url(); ?>/{{table}}/store" class="form-record" enctype="multipart/form-data">
              
              {{{record_form_fields}}}

            </form>
            <!-- Record form end -->
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include('content_footer.php'); ?>

<?php
/* End of File {{view_name}}Form.php */
?>