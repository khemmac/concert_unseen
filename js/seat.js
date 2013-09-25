function Seat(cfg){
	var _this=this;
	if(cfg){
		for(var k in cfg){
			_this.cfg[k] = cfg[k];
		}
	}

	this.__initEl();
	this.__initSeatEvent();

	// fectch datas
	this.__callFetchTimer();

	return this;
};

Seat.prototype = {
	cfg: {
		current:0,
		limit:6
	},
	el: {
		seatContainer: null,
		seat: null,
		checkbox: null
	},
	pending: false,
	__initEl: function(){
		this.el.seatContainer = $('#seat-container');
		this.el.seat = this.el.seatContainer.find('a');
		this.el.checkbox = this.el.seatContainer.find('input[name="seat\[\]"]');
	},
	__showLoader: function(el){
		this.pending = true;
		el.addClass('loader');
	},
	__hideLoader: function(el){
		this.pending = false;
		el.removeClass('loader');
	},
	__fetchTimer: null,
	__fetchData: function(cb){
		var _this=this;

		$.ajax({
			type: 'POST',
			data: {
				booking_id: $('input[name=booking_id]').val(),
				booking_round: $('input[name=booking_round]').val(),
				zone_name: $('input[name=zone_name]').val()
			},
			url: __site_url+'seat/fetch',
			dataType: 'html',
			success: function(result){
				$('#seat-container').empty().html(result);
				if(typeof(cb)=='function') cb();
			},
			error: function(){
				if(typeof(cb)=='function') cb();
			}
		});
	},
	__callFetchTimer: function(time){
		time = time||5000;
		var _this=this;
		var fetch_seat = function(){
			_this.__fetchData(function(){
				_this.__initEl();
				_this.__initSeatEvent();
				_this.fetchTimer = setTimeout(function(){
					fetch_seat();
				}, 5000);
			});
		};
		_this.fetchTimer = setTimeout(fetch_seat, time);
	},
	__clearFetchTimer: function(){
		clearTimeout(this.fetchTimer);
	},
	__initSeatEvent: function(){
		var _this=this;

		this.el.seat.bind('click', function(e){
			e.preventDefault();

			if(_this.pending) return false;


			var el = $(this),
				chk_box = $(el.attr('href')),
				is_disabled = chk_box.is(':disabled');

			if(is_disabled) return false;

			_this.__showLoader(el);

			//console.log('before : '+_this.cfg.current);
			var is_checked = chk_box.is(':checked');
			if(is_checked){
				_this.cfg.current = (_this.cfg.current>0)?_this.cfg.current-1:0;
				//console.log('after (checked) : '+_this.cfg.current);

				// clear timer
				_this.__clearFetchTimer();
				$.ajax({
					type: 'POST',
					data: {
						booking_id: $('input[name=booking_id]').val(),
						seat_id: chk_box.attr('value')
					},
					url: __site_url+'seat/remove',
					dataType: 'json',
					success: function(result){
						if(result.success){
							el.removeClass('active').html(el.attr('title').substring(1));
							_this.__hideLoader(el);
							chk_box.attr("checked", false);
						}
						_this.__hideLoader(el);

						_this.__callFetchTimer(1);
					},
					error: function(){
						bootbox.alert("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
						_this.__hideLoader(el);

						_this.__callFetchTimer(1);
					}
				});
			}else{
				// ถ้าเป็นการจองที่นั่งเพิ่มให้บวกค่าเข้าไป
				_this.cfg.current++;

				// clear timer
				_this.__clearFetchTimer();
				$.ajax({
					type: 'POST',
					data: {
						booking_id: $('input[name=booking_id]').val(),
						seat_id: chk_box.attr('value')
					},
					url: __site_url+'seat/add',
					dataType: 'json',
					success: function(result){
						if(result.success){
							chk_box.attr("checked", true);
							el.addClass('active').html('<span></span>');
						}else{
							if(result.error_code==1){
								bootbox.alert("กรุณาเข้าสู่ระบบใหม่อีกครั้ง", function(result) {
									self.location.href(__site_url('member/login'));
								});
							}else if(result.error_code==2){
								bootbox.alert("ที่นั่งนี้มีผู้จองแล้ว กรุณาลองเลือกที่อื่น");
								// remove seat and fill booked seat
								var cls = el.attr('class');
								$('<div class="booked '+cls+'"></div>').insertBefore(el);
								el.remove();
								chk_box.attr("checked", true);
							}
						}
						_this.__hideLoader(el);

						_this.__callFetchTimer(1);
					},
					error: function(){
						bootbox.alert("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
						_this.__hideLoader(el);

						_this.__callFetchTimer(1);
					}
				});
			}

		});

		$('#b-continue').bind('click', function(e){
			if(_this.el.seatContainer.find('input[name="seat\[\]"]:checked').length<=0){
				e.preventDefault();
				common.popup.show(null, '#seat-no-select-popup');
			}
		});

		$('#seat-no-select-popup .ok').bind('click', function(e){
			e.preventDefault();
			self.location.href=__site_url+'/zone';
		});

	}
};