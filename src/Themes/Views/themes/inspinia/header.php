<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?></title>

  <link href="https://fonts.googleapis.com/css?family=Audiowide|Gugi" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/animate.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/estilo.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
	<!--<link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">-->
	<link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/select2/select2.min.css" rel="stylesheet">

  <!-- Morris -->
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

  <!-- Slick -->
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/slick/slick.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/slick/slick-theme.css" rel="stylesheet">

  <!-- Data Tables -->
  <link href="<?php echo base_url(); ?>/themes/inspinia/assets/css/plugins/dataTables/dataTables.min.css" rel="stylesheet">
  <!--
  <link href="<?php //echo base_url(); ?>/themes/inspinia/assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
  <link href="<?php //echo base_url(); ?>/themes/inspinia/assets/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
  <link href="<?php //echo base_url(); ?>/themes/inspinia/assets/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
	<link href="<?php //echo base_url(); ?>/themes/inspinia/assets/css/plugins/dataTables/dataTables.buttons.min.css" rel="stylesheet">
  -->
</head>
<body id="<?php if (isset($body_id)) { echo $body_id; } ?>" class="<?php if (isset($body_class)) { echo $body_class; } ?> <?php if (false) { ?>mini-navbar<?php } ?>">
<div id="wrapper">
