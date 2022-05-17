<?php include('content_header.php'); ?>
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
                        <!-- datatable start -->
                        <table id="table-list-{{table}}" data-url="<?php echo base_url() ?>/sistema/{{table}}" data-tablename="{{table}}" class="table table-bordered table-hover table-striped table-sm w-100 table-records">
                          <thead>
                            <tr>
                              {{# list_header}}
                                <th width="">{{.}}</th>
                              {{/ list_header}}
                                <th width="30">Ações</th>
                            </tr>
                          </thead>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('content_footer.php'); ?>

<?php
/* End of File {view_name}_list.php */
?>
