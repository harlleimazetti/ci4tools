<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element">
            <!--<img alt="image" width="48" class="img-circle" src="<?php //echo base_url().'assets/upload/'.$this->usuariologado->get_dados()->imagem->nome_hash ?>" />-->
            <img alt="image" width="48" class="img-circle" src="<?php echo base_url().'/assets/img/hccm.jpg' ?>" />
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="block m-t-xs font-bold">Harllei Mazetti</span>
              <span class="text-muted text-xs block">Administrador Master <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
              <li><a href="<?php //echo base_url() ?>usuario/editar/<?php //echo $this->session->userdata('usuario_id') ?>">Perfil</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo base_url() ?>/logout">Sair</a></li>
            </ul>
          </div>
          <div class="logo-element">
            <div style="width: 35px !important; height: 35px !important; overflow: hidden !important; margin: 5px 15px !important;">
            <img src="<?php echo base_url() ?>/assets/img/logo.png" width="35" height="35" style="margin-right: auto; margin-left:auto;">
            </div>
          </div>
        </li>
        <li> <a href="<?php echo base_url(); ?>/inicio"><i class="fa fa-home"></i> <span class="nav-label">Início</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/programa/lista"><i class="fa fa-archive"></i> <span class="nav-label">Programas</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/municipio/lista"><i class="fa fa-building"></i> <span class="nav-label">Municípios</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/proponente/lista"><i class="fa fa-institution"></i> <span class="nav-label">Proponentes</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/proposta/lista"><i class="fa fa-file-text"></i> <span class="nav-label">Propostas</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/contato/lista"><i class="fa fa-comments"></i> <span class="nav-label">Contatos</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/usuario/lista"><i class="fa fa-user"></i> <span class="nav-label">Usuários</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/notificacao"><i class="fa fa-bell"></i> <span class="nav-label">Notificações</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>/logout"><i class="fa fa-close"></i> <span class="nav-label">Sair</span></a> </li>
      </ul>
    </div>
  </nav>
