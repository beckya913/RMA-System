<!DOCTYPE html>
<html>
<head>
	<title>RMA申請系統:::登入</title>
	<!-- install UIKit powered by Yootheme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <!-- Finish installation -->
</head>
<body>
    <body class="uk-height-1-1">
        <?php include("header_home.php"); //表頭 ?>
        <div class="uk-vertical-align uk-text-center uk-height-1-1" id="login">
            <div class="uk-vertical-align-middle" style="width: 250px;">
                <?php
        $attributes = array('class' => 'uk-panel uk-panel-box uk-form', 'id' => 'form_login');
        echo form_open('authorize/checklogin', $attributes);  ?>
                    <div class="uk-form-row">
                        <?php $data = array('name'=> 'username','placeholder'=> '帳號','type'=> 'text','class'=> 'uk-width-1-1 uk-form-large'); 
                        echo form_input($data); ?>
                    </div>
                    <div class="uk-form-row">
                        <?php $data = array('name'=> 'password','placeholder'=> '密碼','type'=> 'password','class'=> 'uk-width-1-1 uk-form-large'); 
                        echo form_input($data); ?>
                    </div>
                    <div class="uk-form-row">
                        <?php $data = array('type'=> 'submit','class'=> 'uk-width-1-1 uk-button uk-button-primary uk-button-large','value'=> '登入'); 
                        echo form_input($data); ?>
                    </div> 
                <?php echo form_close(); ?>

            </div>
        </div>
</body>
</html>