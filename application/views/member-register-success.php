<style type="text/css">

  #dialog {
  	position:absolute; top:200px; left:277px;
    width: 400px;
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

	h3 { font-family:'thaisans_neue_blackregular'; }

</style>

<div id="content-body" class="page-register-success">
	<?=$this->load->view('includes/inc-main-menu','', TRUE)?>

	<div id="dialog">
		<h3 class="text-center">ลงทะเบียนเรียบร้อยแล้ว</h3>
		<p class="text-center"><a href="<?= site_url('index') ?>" class="btn btn-success">ตกลง</a></p>

	</div>
</div>
