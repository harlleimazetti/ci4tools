<?php //print_r($tableConfig); exit; ?>
            <section class="content">
                <div class="content__inner">
                    
                  <?php require_once('content_header.php') ?>

                    <div class="card">

                      <form method="post" action="<?php echo base_url() ?>/admin/table/saveconfig" class="form-record">

                        <input type="hidden" id="table" name="table" value="<?php echo $table ?>">

                        <div class="card-body">
                          <h4 class="card-title"><?php echo isset($tableConfig->tableLabel) ? $tableConfig->tableLabel : $table ?> (Table)</h4>
                          <!--<h6 class="card-subtitle"><?php //echo isset($tableConfig->tableDescription) ? $tableConfig->tableDescription : $table ?></h6>-->

                          <div class="tab-container">
                            <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#table-basic-info" role="tab">General</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#table-fields" role="tab">Fields</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#table-relations" role="tab">Relations</a>
                              </li>
                            </ul>

                            <div class="tab-content">
                              <div class="tab-pane active fade show" id="table-basic-info" role="tabpanel">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Label</label>
                                      <input type="text" id="tableLabel" name="tableLabel" value="<?php echo $tableConfig->tableLabel ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Description</label>
                                      <input type="text" id="tableDescription" name="tableDescription" value="<?php echo $tableConfig->tableDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <h3 class="card-body__title">List configuration</h3>

                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>List Title</label>
                                      <input type="text" id="tableListTitle" name="tableListTitle" value="<?php echo $tableConfig->tableListTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>List Subtitle</label>
                                      <input type="text" id="tableListSubtitle" name="tableListSubtitle" value="<?php echo $tableConfig->tableListSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>List Description</label>
                                      <input type="text" id="tableListDescription" name="tableListDescription" value="<?php echo $tableConfig->tableListDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <h3 class="card-body__title">Form configuration</h3>

                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Form Title</label>
                                      <input type="text" id="tableFormTitle" name="tableFormTitle" value="<?php echo $tableConfig->tableFormTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Form Subtitle</label>
                                      <input type="text" id="tableFormSubtitle" name="tableFormSubtitle" value="<?php echo $tableConfig->tableFormSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Form Description</label>
                                      <input type="text" id="tableFormDescription" name="tableFormDescription" value="<?php echo $tableConfig->tableFormDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Edit Title</label>
                                      <input type="text" id="tableEditTitle" name="tableEditTitle" value="<?php echo $tableConfig->tableEditTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Edit Subtitle</label>
                                      <input type="text" id="tableEditSubtitle" name="tableEditSubtitle" value="<?php echo $tableConfig->tableEditSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Edit Description</label>
                                      <input type="text" id="tableEditDescription" name="tableEditDescription" value="<?php echo $tableConfig->tableEditDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>New Title</label>
                                      <input type="text" id="tableNewTitle" name="tableNewTitle" value="<?php echo $tableConfig->tableNewTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>New Subtitle</label>
                                      <input type="text" id="tableNewSubtitle" name="tableNewSubtitle" value="<?php echo $tableConfig->tableNewSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>New Description</label>
                                      <input type="text" id="tableNewDescription" name="tableNewDescription" value="<?php echo $tableConfig->tableNewDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <h3 class="card-body__title">View configuration</h3>

                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>View Title</label>
                                      <input type="text" id="tableViewTitle" name="tableViewTitle" value="<?php echo $tableConfig->tableViewTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>View Subtitle</label>
                                      <input type="text" id="tableViewSubtitle" name="tableViewSubtitle" value="<?php echo $tableConfig->tableViewSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>View Description</label>
                                      <input type="text" id="tableViewDescription" name="tableViewDescription" value="<?php echo $tableConfig->tableViewDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                </div>
                              </div>

                              <div class="tab-pane fade" id="table-fields" role="tabpanel">
                                <div class="listview listview--hover" id="table-config">
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
                                      <div class="listview__heading">Show on List</div>
                                    </div>
                                    <div class="col-1 text-center">
                                      <div class="listview__heading">Show on Form</div>
                                    </div>
                                    <div class="col-1 text-center">
                                      <div class="listview__heading">Searchable</div>
                                    </div>
                                  </div>

                                  <?php
                                    foreach($tableFields as $k => $tableField) {
                                      $key = array_search($tableField->name, array_column($tableConfig->fields, 'name'));
                                  ?>

                                  <input type="hidden" id="order[]" name="order[]" value="<?php echo $tableConfig->fields[$key]->order ?>">
                                  <input type="hidden" id="field_class[]" name="field_class[]" value="<?php echo $tableConfig->fields[$key]->field_class ?>">
                                  <input type="hidden" id="label_class[]" name="label_class[]" value="<?php echo $tableConfig->fields[$key]->label_class ?>">

                                  <div class="listview__item p-1">
                                    <div class="col-1 mr-2">
                                      <input type="text" id="name[]" name="name[]" class="form-control" value="<?php echo $tableField->name ?>" placeholder="<?php echo $tableField->name ?>" readonly>
                                      <i class="form-group__bar"></i>
                                    </div>

                                    <div class="col-3">
                                      <input type="text" id="label[]" name="label[]" class="form-control" value="<?php echo $tableConfig->fields[$key]->label ?>" placeholder="<?php echo $tableConfig->fields[$key]->label ?>">
                                      <i class="form-group__bar"></i>
                                    </div>

                                    <div class="col-3">
                                      <select class="select2 w-100" id="type[]" name="type[]">
                                        <option value="text"     <?php if ($tableConfig->fields[$key]->type == 'text') { ?>     selected <?php } ?>>Text</option>
                                        <option value="password" <?php if ($tableConfig->fields[$key]->type == 'password') { ?> selected <?php } ?>>Password</option>
                                        <option value="textarea" <?php if ($tableConfig->fields[$key]->type == 'textarea') { ?> selected <?php } ?>>Textarea</option>
                                        <option value="select"   <?php if ($tableConfig->fields[$key]->type == 'select') { ?>   selected <?php } ?>>Select</option>
                                        <option value="checkbox" <?php if ($tableConfig->fields[$key]->type == 'checkbox') { ?> selected <?php } ?>>Checkbox</option>
                                        <option value="radio"    <?php if ($tableConfig->fields[$key]->type == 'radio') { ?>    selected <?php } ?>>Radio</option>
                                        <option value="file"     <?php if ($tableConfig->fields[$key]->type == 'file') { ?>     selected <?php } ?>>File</option>
                                        <option value="hidden"   <?php if ($tableConfig->fields[$key]->type == 'hidden') { ?>   selected <?php } ?>>Hidden</option>
                                      </select>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="allowed[<?php echo $k ?>]" name="allowed[]" value="Y" <?php if ($tableConfig->fields[$key]->allowed === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="allowed[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="multiple[<?php echo $k ?>]" name="multiple[]" value="Y" <?php if ($tableConfig->fields[$key]->multiple === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="multiple[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="show[<?php echo $k ?>]" name="show[]" value="Y" <?php if ($tableConfig->fields[$key]->show === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="show[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="show_on_form[<?php echo $k ?>]" name="show_on_form[]" value="Y" <?php if ($tableConfig->fields[$key]->show_on_form === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="show_on_form[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="searchable[<?php echo $k ?>]" name="searchable[]" value="Y" <?php if ($tableConfig->fields[$key]->searchable === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="searchable[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                  </div>

                                  <?php } ?>

                                </div>
                              </div>

                              <div class="tab-pane fade show" id="table-relations" role="tabpanel">
                                <p>Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nulla sit amet est. Praesent ac massa at ligula laoreet iaculis. Vivamus aliquet elit ac nisl. Nulla porta dolor. Cras dapibus. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                                <p>In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam eget dui. In ac felis quis tortor malesuada pretium. Phasellus consectetuer vestibulum elit. Duis lobortis massa imperdiet quam. Pellentesque commodo eros a enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus a est. Pellentesque commodo eros a enim. Cras ultricies mi eu turpis hendrerit fringilla. Donec mollis hendrerit risus. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Praesent egestas neque eu enim. In hac habitasse platea dictumst.</p>
                              </div>
                            </div>
                          </div>

                          <button type="submit" class="btn btn-primary">Save configuration</button>
                        </div>

                      </form>

                    </div>

                </div>

                <?php require_once('content_footer.php') ?>

            </section>