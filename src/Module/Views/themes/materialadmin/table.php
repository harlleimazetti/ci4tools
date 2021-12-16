<section class="content">
                <div class="content__inner">
                    <?php require_once('content_header.php') ?>

                    <div class="card">

                      <form method="post" action="<?php echo base_url() ?>/admin/table/saveconfig" class="form-record">

                        <input type="hidden" id="table" name="table" value="<?php echo $table ?>">

                        <div class="card-body">
                          <h4 class="card-title"><?php echo $page_title ?></h4>
                          <h6 class="card-subtitle"><?php echo $page_description ?></h6>
                        </div>

                        <div class="listview listview--hover" id="table-config">

                          <div class="listview__item p-2">
                            <div class="col-1">
                              <div class="listview__heading">Name</div>
                            </div>
                            <div class="col-4 listview__content">
                              <div class="listview__heading">Label</div>
                            </div>
                            <div class="col-4 listview__content">
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
                            foreach($tableFields as $k => $tableField) {
                              $key = array_search($tableField->name, array_column($tableConfig, 'name'));
                          ?>

                          <input type="hidden" id="order[]" name="order[]" value="<?php echo $tableConfig[$key]->order ?>">
                          <input type="hidden" id="field_class[]" name="field_class[]" value="<?php echo $tableConfig[$key]->field_class ?>">
                          <input type="hidden" id="label_class[]" name="label_class[]" value="<?php echo $tableConfig[$key]->label_class ?>">

                          <div class="listview__item p-2">
                            <div class="col-1 mr-2">
                              <input type="text" id="name[]" name="name[]" class="form-control" value="<?php echo $tableConfig[$key]->name ?>" placeholder="<?php echo $tableField->name ?>" readonly>
                              <i class="form-group__bar"></i>
                            </div>

                            <div class="col-4">
                              <input type="text" id="label[]" name="label[]" class="form-control" value="<?php echo $tableConfig[$key]->label ?>" placeholder="<?php echo $tableConfig[$key]->label ?>">
                              <i class="form-group__bar"></i>
                            </div>

                            <div class="col-4">
                              <select class="select2" id="type[]" name="type[]">
                                <option value="text" <?php if ($tableConfig[$key]->type == 'text') { ?> selected <?php } ?> >Text</option>
                                <option value="password" <?php if ($tableConfig[$key]->type == 'password') { ?> selected <?php } ?> >Password</option>
                                <option value="textarea" <?php if ($tableConfig[$key]->type == 'textarea') { ?> selected <?php } ?>>Textarea</option>
                                <option value="select" <?php if ($tableConfig[$key]->type == 'select') { ?> selected <?php } ?>>Select</option>
                                <option value="checkbox" <?php if ($tableConfig[$key]->type == 'checkbox') { ?> selected <?php } ?>>Checkbox</option>
                                <option value="radio" <?php if ($tableConfig[$key]->type == 'radio') { ?> selected <?php } ?>>Radio</option>
                                <option value="file" <?php if ($tableConfig[$key]->type == 'file') { ?> selected <?php } ?>>File</option>
                                <option value="hidden" <?php if ($tableConfig[$key]->type == 'hidden') { ?> selected <?php } ?>>Hidden</option>
                              </select>
                            </div>

                            <div class="col-1 text-center">
                              <div class="checkbox mt-2">
                                <input type="checkbox" id="allowed[<?php echo $k ?>]" name="allowed[]" value="Y" <?php if ($tableConfig[$key]->allowed === 'Y') { ?> checked <?php } ?>>
                                <label class="checkbox__label" for="allowed[<?php echo $k ?>]"></label>
                              </div>
                            </div>

                            <div class="col-1 text-center">
                              <div class="checkbox mt-2">
                                <input type="checkbox" id="multiple[<?php echo $k ?>]" name="multiple[]" value="Y" <?php if ($tableConfig[$key]->multiple === 'Y') { ?> checked <?php } ?>>
                                <label class="checkbox__label" for="multiple[<?php echo $k ?>]"></label>
                              </div>
                            </div>

                            <div class="col-1 text-center">
                              <div class="checkbox mt-2">
                                <input type="checkbox" id="show[<?php echo $k ?>]" name="show[]" value="Y" <?php if ($tableConfig[$key]->show === 'Y') { ?> checked <?php } ?>>
                                <label class="checkbox__label" for="show[<?php echo $k ?>]"></label>
                              </div>
                            </div>

                          </div>

                          <?php } ?>

                        </div>

                        <div class="card-body">
                          <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                      </form>

                    </div>

                </div>

                <?php require_once('content_footer.php') ?>

            </section>