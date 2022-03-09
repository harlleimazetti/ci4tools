  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav" id="side-menu">
        <li class="nav-header">
          <div class="dropdown profile-element">
            <span>
              <img alt="image" width="48" class="img-circle" src="<?php //echo base_url().'assets/upload/'.$this->usuariologado->get_dados()->imagem->nome_hash ?>" />
            </span>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear">
                <span class="block m-t-xs">
                  <strong class="font-bold"><?php //echo $this->session->userdata('usuario_nome') ?></strong>
                  <b class="caret"></b>
                </span>
                <span class="text-muted text-xs block">

                </span>
              </span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
              <li><a href="<?php //echo base_url() ?>usuario/editar/<?php //echo $this->session->userdata('usuario_id') ?>">Perfil</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo base_url() ?>logout">Sair</a></li>
            </ul>
          </div>
          <div class="logo-element"> <img src="<?php echo base_url() ?>assets/img/logo.png" class="img-responsive" width="40" height="40" style="margin-right: auto; margin-left:auto;"> </div>
        </li>
        <li> <a href="<?php echo base_url(); ?>inicio"><i class="fa fa-home"></i> <span class="nav-label">Início</span></a> </li>
        <?php //if ($this->session->userdata('usuario_nivel') == 1) { ?>
        <li> <a href="<?php echo base_url(); ?>programa/lista"><i class="fa fa-archive"></i> <span class="nav-label">Programas</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>municipio/lista"><i class="fa fa-building"></i> <span class="nav-label">Municípios</span></a> </li>
        <?php //} ?>
        <li> <a href="<?php echo base_url(); ?>proponente/lista"><i class="fa fa-institution"></i> <span class="nav-label">Proponentes</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>proposta/lista"><i class="fa fa-file-text"></i> <span class="nav-label">Propostas</span></a> </li>
        <li> <a href="<?php echo base_url(); ?>contato/lista"><i class="fa fa-comments"></i> <span class="nav-label">Contatos</span></a> </li>
        <?php //if ($this->session->userdata('usuario_nivel') == 1) { ?>
        <li> <a href="<?php echo base_url(); ?>usuario/lista"><i class="fa fa-user"></i> <span class="nav-label">Usuários</span></a> </li>
        <?php //} ?>
        <li> <a href="<?php echo base_url(); ?>notificacao"><i class="fa fa-bell"></i> <span class="nav-label">Notificações</span></a> </li>
        <?php if (FALSE) { ?>
        <li> <a href=""><i class="fa fa-th-list"></i> <span class="nav-label">Cadastro</span> <span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li ><a href="<?php echo base_url() ?>programa/lista">Programas</a></li>
      			<li ><a href="<?php echo base_url() ?>municipio/lista">Municípios</a></li>
      			<li ><a href="<?php echo base_url() ?>proponente/lista">Proponentes</a></li>
      			<li ><a href="<?php echo base_url() ?>proposta/lista">Propostas</a></li>
            <li ><a class="permissao" href="<?php echo base_url() ?>contato/lista">Contatos</a></li>
            <li ><a class="permissao" href="<?php echo base_url() ?>usuario/lista">Usuários</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if (FALSE) { ?>
        <li> <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">Siconv</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
          	<?php
				        //$menu = $this->menu->lista();
				        //foreach ($menu as $menu_item)
				        //    {
			       ?>
            <li><a href="<?php //echo base_url(); ?>api/lista/<?php //echo $menu_item->tabela ?>"><?php echo $menu_item->menu ?></a></li>
            <?php } ?>
          </ul>
        </li>
		    <?php //} ?>
        <?php if (FALSE) { ?>
        <li> <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Relatórios</span><span class="fa arrow"></span></a>
          <ul class="nav nav-second-level">
            <li><a href="">Convênios celebrados</a></li>
            <li><a href="">Lista de oportunidades</a></li>
            <li><a href="">Instrumentos</a></li>
            <li><a href="">Análise sintética</a></li>
            <li><a href="">Propostas em andamento</a></li>
          </ul>
        </li>
        <?php } ?>
        <li> <a href="<?php echo base_url(); ?>logout"><i class="fa fa-close"></i> <span class="nav-label">Sair</span></a> </li>
      </ul>
    </div>
  </nav>
