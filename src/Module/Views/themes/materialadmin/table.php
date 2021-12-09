<section class="content">
                <div class="content__inner">
                    <?php require_once('content_header.php') ?>

                    <div class="card">

                      <div class="card-body">
                        <h4 class="card-title">Form controls</h4>
                        <h6 class="card-subtitle">Textual form controls like <code>&lt;input&gt;</code>s, <code class="highlighter-rouge">&lt;select&gt;</code>s, and <code>&lt;textarea&gt;</code>s are styled with the <code>.form-control</code> class. Included are styles for general appearance, focus state, sizing, and more.</h6>
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

                        <div class="listview__item p-2">
                          <div class="col-1 mr-2">
                            <input type="email" class="form-control" placeholder="id" readonly>
                            <i class="form-group__bar"></i>
                          </div>

                          <div class="col-4">
                            <input type="text" class="form-control" placeholder="ID">
                            <i class="form-group__bar"></i>
                          </div>

                          <div class="col-4">
                            <div class="select">
                              <select class="form-control">
                                <option>Text</option>
                                <option>Text Area</option>
                                <option>Hidden</option>
                                <option>Select</option>
                                <option>Checkbox</option>
                                <option>Radio</option>
                              </select>
                              <i class="form-group__bar"></i>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                        </div>

                        <div class="listview__item p-2">
                          <div class="col-1 mr-2">
                            <input type="email" class="form-control" placeholder="name" readonly>
                            <i class="form-group__bar"></i>
                          </div>

                          <div class="col-4">
                            <input type="text" class="form-control" placeholder="ID">
                            <i class="form-group__bar"></i>
                          </div>

                          <div class="col-4">
                            <div class="select">
                              <select class="form-control">
                                <option>Text</option>
                                <option>Text Area</option>
                                <option>Hidden</option>
                                <option>Select</option>
                                <option>Checkbox</option>
                                <option>Radio</option>
                              </select>
                              <i class="form-group__bar"></i>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                          <div class="col-1 text-center">
                            <div class="checkbox mt-2">
                              <input type="checkbox" id="customCheck1">
                              <label class="checkbox__label" for="customCheck1"></label>
                            </div>
                          </div>

                        </div>

                      </div>

                        <div class="card-body">
                            <h4 class="card-title">Form controls</h4>
                            <h6 class="card-subtitle">Textual form controls like <code>&lt;input&gt;</code>s, <code class="highlighter-rouge">&lt;select&gt;</code>s, and <code>&lt;textarea&gt;</code>s are styled with the <code>.form-control</code> class. Included are styles for general appearance, focus state, sizing, and more.</h6>

                            <form class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="email" class="form-control" placeholder="David Smith">
                                        <i class="form-group__bar"></i>
                                    </div>

                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" placeholder="name@example.com">
                                        <i class="form-group__bar"></i>
                                    </div>

                                    <div class="form-group">
                                        <label>Example select</label>
                                        <div class="select">
                                            <select class="form-control">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Example textarea</label>
                                        <textarea class="form-control"></textarea>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                            </form>

                            <br>
                            <br>

                            <h3 class="card-body__title">Sizing</h3>
                            <p>Set heights using classes like <code>.form-control-lg</code> and <code>.form-control-sm</code>.</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" placeholder="Large">
                                        <i class="form-group__bar"></i>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Default">
                                        <i class="form-group__bar"></i>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-sm" placeholder="Small">
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="select">
                                            <select class="form-control form-control-lg">
                                                <option>Large</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="select">
                                            <select class="form-control">
                                                <option>Default</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="select">
                                            <select class="form-control form-control-sm">
                                                <option>Small</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>

                            <h3 class="card-body__title">Readonly</h3>
                            <p>Add the <code>readonly</code> boolean attribute on an input to prevent modification of the input’s value. Read-only inputs appear lighter (just like disabled inputs), but retain the standard cursor.</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Readonly Textual Input" readonly>
                                        <i class="form-group__bar"></i>
                                    </div>

                                    <div class="form-group mb-0">
                                        <textarea class="form-control" readonly placeholder="Readonly Textarea"></textarea>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Custom styled checkboxes and radios</h4>
                            <h6 class="card-subtitle">Each checkbox and radio is wrapped in a <code>&lt;div&gt;</code> to create our custom control and a <code>&lt;label&gt;</code> for the accompanying text.</h6>

                            <h3 class="card-body__title">Default</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <input type="checkbox" id="customCheck1">
                                        <label class="checkbox__label" for="customCheck1">Check this custom checkbox</label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" id="customCheck2">
                                        <label class="checkbox__label" for="customCheck2">This is another custom styled checkbox</label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" id="customCheck3">
                                        <label class="checkbox__label" for="customCheck3">Another one with same styling</label>
                                    </div>

                                    <br>

                                    <div class="radio">
                                        <input type="radio" name="customRadio" id="customRadio1">
                                        <label class="radio__label" for="customRadio1">Check this custom radio</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="customRadio" id="customRadio2">
                                        <label class="radio__label" for="customRadio2">This is another custom styled radio</label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="customRadio" id="customRadio3">
                                        <label class="radio__label" for="customRadio3">Another radio with same styling</label>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>

                            <h3 class="card-body__title">Inline</h3>
                            <p>Add class <code>.checkbox--inline</code> or <code>.radio--inline</code> to make the inputs inline</p>

                            <div class="checkbox checkbox--inline">
                                <input type="checkbox" id="customCheck4">
                                <label class="checkbox__label" for="customCheck4">Toggle this one</label>
                            </div>
                            <div class="checkbox checkbox--inline">
                                <input type="checkbox" id="customCheck5">
                                <label class="checkbox__label" for="customCheck5">Or toggle this one</label>
                            </div>

                            <br>

                            <div class="radio radio--inline">
                                <input type="radio" name="customRadio" id="customRadio4">
                                <label class="radio__label" for="customRadio4">Toggle this one</label>
                            </div>
                            <div class="radio radio--inline">
                                <input type="radio" name="customRadio" id="customRadio5">
                                <label class="radio__label" for="customRadio5">Or toggle this one</label>
                            </div>

                            <br>
                            <br>
                            <br>

                            <h3 class="card-body__title">Disabled</h3>
                            <p>Add attribute <code>diasbled</code> on the input elements where you need to make them disabled</p>

                            <div class="checkbox">
                                <input type="checkbox" id="customCheck6" disabled>
                                <label class="checkbox__label" for="customCheck6">This is a disabled checkbox</label>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" id="customCheck7" disabled>
                                <label class="checkbox__label" for="customCheck7">This is another disabled checkbox</label>
                            </div>

                            <br>

                            <div class="radio">
                                <input type="radio" name="customRadio" id="customRadio6" disabled>
                                <label class="radio__label" for="customRadio6">Toggle this one</label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="customRadio" id="customRadio7" disabled>
                                <label class="radio__label" for="customRadio7">Or toggle this one</label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require_once('content_footer.php') ?>

            </section>