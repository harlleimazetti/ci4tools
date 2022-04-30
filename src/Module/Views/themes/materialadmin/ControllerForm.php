            <section class="content">
              <div class="content__inner">
                
                <?php require_once('content_header.php') ?>
                
                <div class="card">

                  <form method="post" action="<?php echo base_url() ?>/admin/controllers/saveconfig" class="form-record">

                    <input type="hidden" id="controller" name="controller" value="<?php //echo $table ?>">

                    <div class="card-body">
                      <h4 class="card-title"><?php echo isset($controllerConfig->controllerLabel) ? $controllerConfig->controllerLabel : $controller ?></h4>
                      <!--<h6 class="card-subtitle"><?php //echo isset($tableConfig->tableDescription) ? $tableConfig->tableDescription : $table ?></h6>-->

                      <div class="tab-container">
                        <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#controller-basic-info" role="tab">Informações</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#controller-fields" role="tab">Campos</a>
                          </li>
                        </ul>

                        <div class="tab-content">
                          <div class="tab-pane active fade show" id="controller-basic-info" role="tabpanel">
                            <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                            <p>In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuada pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse platea dictumst.</p>
                          </div>
                          <div class="tab-pane fade" id="controller-fields" role="tabpanel">
                            <div class="listview listview--hover" id="controller-config">
                              <div class="listview__item p-2">
                                <div class="col-1">
                                  <div class="listview__heading">Name</div>
                                </div>
                                <div class="col-3 listview__content">
                                  <div class="listview__heading">Label</div>
                                </div>
                                <div class="col-3 listview__content">
                                  <div class="listview__heading">Type</div>
                                </div>
                                <div class="col-1 text-center">
                                  <div class="listview__heading">Allowed</div>
                                </div>
                                <div class="col-1 text-center">
                                  <div class="listview__heading">Multiple</div>
                                </div>
                                <div class="col-1 text-center">
                                  <div class="listview__heading">Show</div>
                                </div>
                              </div>

                              <?php
                                foreach($controllerMethods as $k => $controllerMethod) {
                                  //$key = array_search($tableField->name, array_column($tableConfig->fields, 'name'));
                              ?>

                              <input type="hidden" id="order[]" name="order[]" value="<?php //echo $tableConfig->fields[$key]->order ?>">
                              <input type="hidden" id="field_class[]" name="field_class[]" value="<?php //echo $tableConfig->fields[$key]->field_class ?>">
                              <input type="hidden" id="label_class[]" name="label_class[]" value="<?php //echo $tableConfig->fields[$key]->label_class ?>">

                              <div class="listview__item p-2">
                                <div class="col-1 mr-2">
                                  <input type="text" id="name[]" name="name[]" class="form-control" value="<?php //echo $tableField->name ?>" placeholder="<?php //echo $tableField->name ?>" readonly>
                                  <i class="form-group__bar"></i>
                                </div>

                                <div class="col-11">
                                  <div class="listview__heading"><?php echo $controllerMethod ?></div>
                                  <input type="text" id="label[]" name="label[]" class="form-control" value="<?php //echo $tableConfig->fields[$key]->label ?>" placeholder="<?php //echo $tableConfig->fields[$key]->label ?>">
                                  <i class="form-group__bar"></i>
                                </div>
                              </div>

                              <?php } ?>

                            </div>
                          </div>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>

                  </form>

                </div>


              </div>

              <?php require_once('content_footer.php') ?>

            </section>