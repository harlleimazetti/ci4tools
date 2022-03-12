<?php include('content_header.php'); ?>
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">
                  <div class="ibox-title">
                    <h5>Basic Data Tables example with responsive plugin</h5>
                    <div class="ibox-tools">
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                      </ul>
                      <a class="close-link">
                        <i class="fa fa-times"></i>
                      </a>
                    </div>
                  </div>

                  <div class="ibox-content">
                    <!-- datatable start -->
                    <div class="table-responsive">
                      <table id="table-list-{{table}}" data-url="<?php echo base_url() ?>/{{table}}" data-tablename="{{table}}" class="table table-bordered table-hover table-striped table-sm w-100 table-records">
                        <thead>
                          <tr>
                            <th class="text-center" width="30">ID</th>
                            {{# list_header}}
                              <th width="">{{.}}</th>
                            {{/ list_header}}
                              <th width="30">Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach(${{table}}s as ${{table}}) { ?>
                          <tr>
                            <td class="text-center">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="id[]" id="id[<?php echo ${{table}}->id ?>]" value="<?php echo ${{table}}->id ?>">
                                <label class="custom-control-label" for="id[<?php echo ${{table}}->id ?>]"></label>
                              </div>
                            </td>
                            <?php foreach($listVisibleFields as $field) { ?>
                              <td><?php echo ${{table}}->{$field} ?></td>
                            <?php } ?>
                            <td class="text-center">
                              <div class="btn-group dropleft">
                                <button type="button" class="btn btn-outline btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fal fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="<?php echo base_url() ?>/{{table}}/edit/<?php echo ${{table}}->id ?>"><i class="fal fa-edit mr-2"></i> Editar</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="javascript:void(0)"><i class="fal fa-times-circle mr-2"></i> Excluir</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      <!-- datatables end -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

<?php include('content_footer.php'); ?>

<?php
/* End of File {view_name}_list.php */
?>
