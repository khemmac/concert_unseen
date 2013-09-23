function Forgot(cfg){
	var _this=this;
	if(cfg){
		for(var k in cfg){
			_this.cfg[k] = cfg[k];
		}
	}

	this.__initEl();
	this.__initEvent();

	return this;
};

Forgot.prototype = {
	cfg: {
	},
	el: {
		bSubmit:null,
		bNext:null,
		stepMask:null,
		inputUsername:null,
		tipUsername:null,
		inputQuestion:null,
		inputAnswer:null,
		tipAnswer:null,
		inputPassword:null
	},
	__state: 1,
	__initEl: function(){
		this.el.bSubmit = $('#submit');
		this.el.bNext = $('.b-next');
		this.el.stepMask = $('#step-mask');
		this.el.inputUsername = $('input[name=username]');
		this.el.tipUsername = $('#qtip-0');
		this.el.inputQuestion = $('input[name=question]');
		this.el.inputAnswer = $('input[name=answer]');
		this.el.tipAnswer = $('#qtip-1');
		this.el.inputPassword = $('input[name=password]');
	},
	__showLoader: function(){
		this.el.bNext.hide();
	},
	__hideLoader: function(){
		this.el.bNext.show();
	},
	validateUsername: function(){
		var usr = this.el.inputUsername.val();
		if($.trim(usr)==''){
			this.el.tipUsername.find('.qtip-content').text('กรุณาป้อน "Username"');
			this.el.tipUsername.fadeIn('fast');
			return false;
		}
		return usr;
	},
	validateAnswer: function(){
		var ans = this.el.inputAnswer.val();
		if(ans==''){
			this.el.tipAnswer.find('.qtip-content').text('กรุณาป้อน "คำตอบ"');
			this.el.tipAnswer.fadeIn('fast');
			return false;
		}
		return ans;
	},
	__doState1: function(cb){
		var _this=this;

		this.__showLoader();

		var usr = this.validateUsername();
		if(!usr) return false;

		// post ajax
		$.ajax({
			type: 'POST',
			data: {
				username: usr
			},
			url: __site_url+'forgot/load_question',
			dataType: 'json',
			success: function(result){
				if(result && result.success){
					_this.el.inputUsername.attr('readonly', 'readonly').attr('disabled', 'disabled');
					_this.el.inputQuestion.val(result.data.question);

					_this.el.stepMask.animate({ height:'33px' }, '300');
					_this.el.bNext.animate({ top:'140px' }, '300');

					_this.__state = 2;
				}else{
					if(result.error_code==1){
						_this.el.tipUsername.find('.qtip-content').text('กรุณาป้อน "Username"');
						_this.el.tipUsername.fadeIn('fast');
					}else if(result.error_code==2){
						_this.el.tipUsername.find('.qtip-content').text('ไม่พบ Username "'+usr+'"');
						_this.el.tipUsername.fadeIn('fast');
					}
				}
				_this.__hideLoader();
			},
			error: function(){
				alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
				_this.__hideLoader();
			}
		});
	},
	__doState2: function(cb){
		var _this=this;

		this.__showLoader();

		var usr = this.validateUsername();
		if(!usr) return false;
		var ans = this.validateAnswer();
		if(!ans) return false;

		// post ajax answer
		$.ajax({
			type: 'POST',
			data: {
				username: usr,
				answer: ans
			},
			url: __site_url+'forgot/check_answer',
			dataType: 'json',
			success: function(result){
				if(result && result.success){
					_this.el.inputPassword.val(result.data.password_new);

					_this.el.stepMask.fadeOut();
					_this.el.bNext.fadeOut();

					_this.el.bSubmit.fadeIn();

					_this.__state = 2;
				}else{
					if(result.error_code==1){
						_this.el.tipUsername.find('.qtip-content').text('กรุณาป้อน "Username"');
						_this.el.tipUsername.fadeIn('fast');
					}else if(result.error_code==2){
						_this.el.tipAnswer.find('.qtip-content').text('กรุณาป้อน "คำตอบ"');
						_this.el.tipAnswer.fadeIn('fast');
					}else if(result.error_code==3){
						_this.el.tipAnswer.find('.qtip-content').text('คำตอบไม่ถูกต้อง');
						_this.el.tipAnswer.fadeIn('fast');
					}
					_this.__hideLoader();
				}
			},
			error: function(){
				alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
				_this.__hideLoader();
			}
		});
	},
	__runFlow: function(){
		if(this.__state==1){
			this.__doState1();
		}else{
			this.__doState2();
		}
	},
	__initEvent:function(){
		var _this=this;
		this.el.inputUsername.on('keyup', function(e){
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) { //Enter keycode
				_this.__runFlow();
			}
			_this.el.tipUsername.fadeOut();
		});

		this.el.inputAnswer.on('keyup', function(){
			_this.el.tipAnswer.fadeOut();
		});

		this.el.bNext.click(function(e){
			e.preventDefault();
			_this.__runFlow();
		});
	}
};