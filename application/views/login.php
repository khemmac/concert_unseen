<style type="text/css">

  .form-login {
  	position:absolute; top:200px; left:200px;
    width: 555px;
    padding: 19px 29px 19px;
    background-color: #f5f5f5;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

	ul#sub-menu { margin:0px; padding:0px; list-style:none; }
	ul#sub-menu li { float:left; margin-right:10px; }

</style>

<div id="content-body" class="page-login">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

		<?= form_open('', array('class'=>'form-login form-horizontal')); ?>
		<?= form_hidden('rurl', $this->input->get('rurl')) ?>

		<?php
			$forms = array(
				array(
					'name'			=> 'username',
					'maxlength'		=> '20',
					//'placeholder'	=> 'Username',
					'value'			=> '',
					'label'	=>	'Username'
				),
				array(
					'name'			=> 'password',
					'type'			=> 'password',
					'maxlength'		=> '100',
					//'placeholder'	=> 'Password',
					'value'			=> '',
					'label'	=>	'Password'
				)
			);
			form_helper_generate_bootstrap($forms, null);
		?>

		<div class="control-group">
			<div class="controls">
				<ul id="sub-menu">
					<li><a href="<?= site_url('member/register') ?>" class="sub-menu-1">Register</a></li>
					<li>|</li>
					<li><a href="<?= site_url('forgot') ?>" class="sub-menu-2">Forgot password</a></li>
				</ul>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<?= form_submit(array(
						'id'		=> 'submit',
						'value'		=> 'Submit',
						'class'		=> 'submit btn btn-primary'
					));
				?>
			</div>
		</div>
		<?= form_close() ?>

</div>
<script type="text/javascript">
	$(function(){
		$('.page-login #submit').click(function(){
			setTimeout(function(){
				$(this).attr('disabled', 'disabled');
			}, 1);
		});

		setTimeout(function(){
			$('.page-login #username').focus();
		}, 100);
	});
</script>
