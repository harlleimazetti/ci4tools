            <section class="content">
              <div class="content__inner">
                
                <?php require_once('content_header.php') ?>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Basic example</h4>
                          <h6 class="card-subtitle">Load a simple json data in javascript tree</h6>
                          <div class="treeview"></div>
                        </div>
                      </div>

                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Drag and drop</h4>
                              <h6 class="card-subtitle">Add drag-and-drop support by setting the option <code>dragAndDrop</code> to <code>true</code>. You can now drag tree nodes to another position.</h6>

                              <div class="treeview-drag"></div>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Expanded</h4>
                          <h6 class="card-subtitle">Expand all hidden branches using <code>autoOpen</code></h6>
                          <div class="treeview-expanded"></div>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">autoEscape</h4>
                          <h6 class="card-subtitle">You can put html in the node titles setting the <code>autoEscape</code> option to <code>false</code></h6>
                          <div class="treeview-escape"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              <?php require_once('content_footer.php') ?>

            </section>