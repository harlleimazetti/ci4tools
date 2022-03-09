  <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header"> <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          <form role="search" class="navbar-form-custom" action="">
            <div class="form-group">
              <input type="text" placeholder="Busca" class="form-control" name="top-search" id="top-search">
            </div>
          </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
          <li>
            <span class="m-r-sm text-muted welcome-message">
              <div class="btn-group">
                <select id="proponente_id_selecionado" name="proponente_id_selecionado" class="select2 proponente_id_selecionado">
                  <?php
                  //foreach(json_decode($this->session->userdata('usuario_proponente')) as $usuario_proponente) { ?>
                  <option value="<?php //echo $usuario_proponente->id ?>" <?php //if ($usuario_proponente->id == $this->session->userdata('usuario_proponente_selecionado')) { ?>selected <?php // } ?>><?php //echo $usuario_proponente->nome ?>	- <?php //echo $usuario_proponente->cnpj ?></option>
                  <?php // } ?>
                </select>
              </div>
            </span>
          </li>
          <li class="dropdown"> <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#"> <i class="fa fa-bell"></i> <span id="label-notificacoes" class="label label-dmd" style="display:none;"></span> </a>
            <ul class="dropdown-menu dropdown-alerts" id="dropdown-notificacoes">
              <li>
                <div class="text-center link-block"> <a href="<?php echo base_url() ?>/notificacao"> <strong>Ver todos os alertas</strong> <i class="fa fa-angle-right"></i> </a> </div>
              </li>
            </ul>
          </li>
          <li> <a href="<?php echo base_url() ?>logout"> <i class="fa fa-sign-out"></i> Sair </a> </li>
        </ul>
      </nav>
    </div>
