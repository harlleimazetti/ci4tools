<?php
	${{tabela}} = reset(${{tabela}});
?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-8">
		<h2><?php echo $area_sistema_titulo ?></h2>
		<ol class="breadcrumb">
			<li> <a href="<?php echo base_url() ?>inicio">Início</a> </li>
			<li class="active"> <strong><?php echo $area_sistema_titulo ?></strong> </li>
		</ol>
	</div>
	<div class="col-sm-4">

	</div>
</div>

<div class="row">

	<div class="wrapper wrapper-content animated fadeInUp">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $area_sistema_titulo ?> <small><?php echo $area_sistema_descricao ?></small></h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<form method="post" action="<?php echo base_url(); ?>{{tabela}}/salvar" class="form-horizontal formulario-registro">
						<input type="hidden" id="operacao_bd" name="operacao_bd" value="<?php echo $operacao_bd ?>">
						<input type="hidden" id="id" name="id" value="<?php echo ${{tabela}}->id ?>">
						
						{{campos_form}}

					</form>
				</div> <!-- ibox-content -->
			</div> <!-- ibox-float-e-margins -->
		</div> <!-- col-lg-12 -->
	</div> <!-- wrapper-content -->

</div>
<br /><br/>