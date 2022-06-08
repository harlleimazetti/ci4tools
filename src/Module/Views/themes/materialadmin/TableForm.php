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
                                <input type="hidden" id="table" name="[general][table]" value="<?php echo $tableConfig->general->table ?>">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">Label</label>
                                      <input type="text" id="tableLabel" name="[general][tableLabel]" value="<?php echo $tableConfig->general->tableLabel ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">Description</label>
                                      <input type="text" id="tableDescription" name="[general][tableDescription]" value="<?php echo $tableConfig->general->tableDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <h3 class="card-body__title font-weight-bold">List Settings</h3>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">List Title</label>
                                      <input type="text" id="tableListTitle" name="[general][tableListTitle]" value="<?php echo $tableConfig->general->tableListTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">List Subtitle</label>
                                      <input type="text" id="tableListSubtitle" name="[general][tableListSubtitle]" value="<?php echo $tableConfig->general->tableListSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>List Description</label>
                                      <input type="text" id="tableListDescription" name="[general][tableListDescription]" value="<?php echo $tableConfig->general->tableListDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <h3 class="card-body__title font-weight-bold">Form Settings</h3>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">Form Title</label>
                                      <input type="text" id="tableFormTitle" name="[general][tableFormTitle]" value="<?php echo $tableConfig->general->tableFormTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">Form Subtitle</label>
                                      <input type="text" id="tableFormSubtitle" name="[general][tableFormSubtitle]" value="<?php echo $tableConfig->general->tableFormSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">Form Description</label>
                                      <input type="text" id="tableFormDescription" name="[general][tableFormDescription]" value="<?php echo $tableConfig->general->tableFormDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">Edit Title</label>
                                      <input type="text" id="tableEditTitle" name="[general][tableEditTitle]" value="<?php echo $tableConfig->general->tableEditTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">Edit Subtitle</label>
                                      <input type="text" id="tableEditSubtitle" name="[general][tableEditSubtitle]" value="<?php echo $tableConfig->general->tableEditSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">Edit Description</label>
                                      <input type="text" id="tableEditDescription" name="[general][tableEditDescription]" value="<?php echo $tableConfig->general->tableEditDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">New Title</label>
                                      <input type="text" id="tableNewTitle" name="[general][tableNewTitle]" value="<?php echo $tableConfig->general->tableNewTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">New Subtitle</label>
                                      <input type="text" id="tableNewSubtitle" name="[general][tableNewSubtitle]" value="<?php echo $tableConfig->general->tableNewSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">New Description</label>
                                      <input type="text" id="tableNewDescription" name="[general][tableNewDescription]" value="<?php echo $tableConfig->general->tableNewDescription ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>

                                  <div class="col-md-12 mt-3">
                                    <h3 class="card-body__title font-weight-bold">View Settings</h3>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">View Title</label>
                                      <input type="text" id="tableViewTitle" name="[general][tableViewTitle]" value="<?php echo $tableConfig->general->tableViewTitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="mb-0">View Subtitle</label>
                                              <input type="text" id="tableViewSubtitle" name="[general][tableViewSubtitle]" value="<?php echo $tableConfig->general->tableViewSubtitle ?>" class="form-control" placeholder="Label">
                                      <i class="form-group__bar"></i>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="mb-0">View Description</label>
                                      <input type="text" id="tableViewDescription" name="[general][tableViewDescription]" value="<?php echo $tableConfig->general->tableViewDescription ?>" class="form-control" placeholder="Label">
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

                                  <input type="hidden" id="order[]" name="[fields][<?php echo $k ?>][order]" value="<?php echo $tableConfig->fields[$key]->order ?>">
                                  <input type="hidden" id="field_class[]" name="[fields][<?php echo $k ?>][field_class]" value="<?php echo $tableConfig->fields[$key]->field_class ?>">
                                  <input type="hidden" id="label_class[]" name="[fields][<?php echo $k ?>][label_class]" value="<?php echo $tableConfig->fields[$key]->label_class ?>">

                                  <div class="listview__item p-1">
                                    <div class="col-1 mr-2">
                                      <input type="text" id="name[]" name="[fields][<?php echo $k ?>][name]" class="form-control" value="<?php echo $tableField->name ?>" placeholder="<?php echo $tableField->name ?>" readonly>
                                      <i class="form-group__bar"></i>
                                    </div>

                                    <div class="col-3">
                                      <input type="text" id="label[]" name="[fields][<?php echo $k ?>][label]" class="form-control" value="<?php echo $tableConfig->fields[$key]->label ?>" placeholder="<?php echo $tableConfig->fields[$key]->label ?>">
                                      <i class="form-group__bar"></i>
                                    </div>

                                    <div class="col-3">
                                      <select class="select2 w-100" id="type[]" name="[fields][<?php echo $k ?>][type]">
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
                                        <input type="checkbox" id="allowed[<?php echo $k ?>]" name="[fields][<?php echo $k ?>][allowed]" value="Y" <?php if ($tableConfig->fields[$key]->allowed === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="allowed[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="multiple[<?php echo $k ?>]" name="[fields][<?php echo $k ?>][multiple]" value="Y" <?php if ($tableConfig->fields[$key]->multiple === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="multiple[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="show[<?php echo $k ?>]" name="[fields][<?php echo $k ?>][show]" value="Y" <?php if ($tableConfig->fields[$key]->show === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="show[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="show_on_form[<?php echo $k ?>]" name="[fields][<?php echo $k ?>][show_on_form]" value="Y" <?php if ($tableConfig->fields[$key]->show_on_form === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="show_on_form[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                    <div class="col-1 text-center">
                                      <div class="checkbox mt-2">
                                        <input type="checkbox" id="searchable[<?php echo $k ?>]" name="[fields][<?php echo $k ?>][searchable]" value="Y" <?php if ($tableConfig->fields[$key]->searchable === 'Y') { ?> checked <?php } ?>>
                                        <label class="checkbox__label" for="searchable[<?php echo $k ?>]"></label>
                                      </div>
                                    </div>

                                  </div>

                                  <?php } ?>

                                </div>
                              </div>

                              <div class="tab-pane fade show" id="table-relations" role="tabpanel">
                                <div class="listview" id="table-config">
                                  <div class="listview__item p-0 row">
                                    <div class="col-md-3">
                                      <div class="listview__heading">
                                        <div class="form-group">
                                          <label class="mb-0 font-weight-bold"><small>Name</small></label>
                                          <input type="text" id="tableRelationName" name="tableRelationName" value="" class="form-control" placeholder="Name">
                                          <i class="form-group__bar"></i>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="listview__heading">
                                        <div class="form-group">
                                          <label class="mb-0 font-weight-bold"><small>Type</small></label>
                                          <select class="select2 w-100" id="tableRelationType" name="tableRelationType">
                                            <option value="oneToMany">One to Many (1:N)</option>
                                            <option value="manyToOne">Many to One (N:1)</option>
                                            <option value="manyToMany">Many to Many (N:N)</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="listview__heading">
                                        <div class="form-group">
                                          <label class="mb-0 font-weight-bold"><small>Table</small></label>
                                          <select class="select2 w-100" id="tableRelationTable" name="tableRelationTable">
                                            <option value="Arquivo">Arquivo</option>
                                            <option value="Imagem">Imagem</option>
                                            <option value="Pda">Pda</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="listview__heading">
                                        <div class="form-group">
                                          <label class="mb-0 font-weight-bold"><small>Loading way</small></label>
                                          <select class="select2 w-100" id="tableRelationLoading" name="tableRelationLoading">
                                            <option value="model">Model</option>
                                            <option value="ajax">Ajax</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-1">
                                      <div class="listview__heading">
                                        <div class="form-group">
                                          <label class="mb-0 font-weight-bold"><small>Action</small></label><br />
                                          <button type="button" class="btn btn-sm btn-secondary"><i class="zmdi zmdi-check"></i></button>
                                          <button type="button" class="btn btn-sm btn-danger"><i class="zmdi zmdi-close"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
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