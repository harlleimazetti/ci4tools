<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-sm-8">
    <h2><?php echo $system_area_title ?></h2>
    <ol class="breadcrumb">
      <li> <a href="<?php echo base_url() ?>home">Início</a> </li>
      <li class="active"> <strong><?php echo $system_area_title ?></strong> </li>
    </ol>
  </div>
  <div class="col-sm-4">

  </div>
</div>
<div class="wrapper wrapper-content">

  <div class="row">

				<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                    	<h5>Lista</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content" id="record-table-container">

						<table class="table table-striped table-hover dataTables-example record-table" data-url="<?php echo base_url(); ?>{table}" data-tablename="{table}">
								{table_header}
							<tbody>

							</tbody>
						</table>

                    </div>
                </div>
  </div>

<?php
/* End of File {view_name}_list.php */
/* Local: ./application/views/{view_name}_list.php */
?>
