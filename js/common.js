function Common(){

};

Common.prototype = {
	initFormTip : function(){

		$.each($('input[qtip-data]'), function(i,o){
			var el = $(o);
			var html = ['<div id="qtip-'+i+'" class="qtip qtip-default qtip-red qtip-pos-lc" tracking="false" role="alert" aria-live="polite" style="z-index: 1500; opacity: 1; display: block;">',
						'<div class="qtip-tip" style="background: transparent url('+__base_url+'js/lib/jquery.qtip/arrow-tip.gif) no-repeat! important; border: 0px none ! important; width: 8px; height: 8px; line-height: 8px; top: 50%; margin-top: -4px; left: -8px; visibility:visible !important;">',
						'&nbsp;</div><div class="qtip-content" aria-atomic="true">'+el.attr('qtip-data')+'</div></div>'
						].join('');
			var tip = $(html);
			el.attr('qtip-id', 'qtip-'+i);

			var el_pos = el.offset();
			tip.css({ top: (el_pos.top)+'px', left: (el_pos.left + el.width() + 22)+'px'});

			$('body').append(tip);

			el.on('keyup', function(){
				tip.fadeOut();
			}).on('change', function(){
				tip.fadeOut();
			});

			tip.click(function(){
				$(this).fadeOut();
			});
		});

/*
		$('input[qtip-data]').tipsy({title: 'qtip-data',gravity: 'w' });
		$.each($('input[qtip-data]'), function(o){
			console.log($(o));
			$(o).tipsy('show');
		});
		//$('input[qtip-data]').tipsy({title: 'qtip-data',gravity: 'w' }).tipsy('show');
*/
/*
		$('input[qtip-data]').qtip({
			content: { attr: 'qtip-data' },
			show: {
				when: false, // Don't specify a show event
				ready: false // Show the tooltip when ready
			},
			hide: 'keyup', // hide when key on input
			//hide: false, // Don't specify a hide event
			position: {
				my: 'center left',
				at: 'center right',
				adjust: { x: 5 }
			},
			style: {
				classes: 'qtip-red'
			},
			adjust: { scroll: false }
		});
*/
	},
	initToolTip: function(){
		$('.concert-tooltip').qtip();
	},
	popup : {
		queue: [],
		init : function(){
			var _this=this;
			//if close button is clicked
			$('.window .close').click(function (e) {
				//Cancel the link behavior
				e.preventDefault();
				_this.hide();
			});

			//if mask is clicked
			$('#mask').click(function () {
				_this.hide();
			});

			$(window).resize(function () {
				var box = $('#boxes .window');

				//Get the screen height and width
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();

				//Set height and width to mask to fill up the whole screen
				$('#mask').css({'width':maskWidth,'height':maskHeight});

				//Get the window height and width
				var winH = $(window).height();
				var winW = $(window).width();

				//Set the popup window to center
				box.css('top',  winH/2 - box.height()/2);
				box.css('left', winW/2 - box.width()/2);
			});
		},
		show : function(el, popup_id){
			var _this=this;
			// check another window is show
			if($('#boxes > .window:visible').length>0){
				this.queue.push(popup_id);
				return;
			}

			//Get the A tag
			// id is optional
			var id = popup_id || $(el).attr('href');

			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();

			//Set height and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});

			//transition effect
			//$('#mask').fadeIn(1000);
			//$('#mask').fadeTo("slow",0.8);
			$('#mask').fadeTo(200, 0.6);

			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();

			//Set the popup window to center
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);

			//transition effect
			$(id).fadeIn(200);
		},
		hide : function(){
			var _this=this;
			$('#mask, .window').fadeOut(100, function(){
				if(_this.queue.length>0){
					var qId = _this.queue.pop();
					_this.show(null, qId);
				}
			});
		}
	},
	combo : {
		create : function(el, cls){
			el.sexyCombo({
				triggerSelected: true,
				skin: 'custom',
				initCallback: function() {
					var parent = el.parent('.combo');
					parent
						.addClass(cls)
						.find('input[type="text"]').on('blur', function(){
							$(this).val(parent.find('select>option:selected').text());
						});
				}
			});
		}
	},
	form: {
		isValidDate : function(y,m,d) {
			// Assume not leap year by default (note zero index for Jan)
			var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

			// If evenly divisible by 4 and not evenly divisible by 100,
			// or is evenly divisible by 400, then a leap year
			if ( (!(y % 4) && y % 100) || !(y % 400)) {
				daysInMonth[1] = 29;
			}
			return d <= daysInMonth[--m];
		}
	},
	showConditionPopup: function(){
		//__not_show_term
		var btns = [{
			label: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตกลง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
			class: "btn-success btn-large",
			callback: function() {
				bootbox.hideAll();
			}
		}];
		if(!__not_show_term)
			btns.push({
				label: "อย่าแสดงอีก",
				class: "btn btn-not-show-term",
				callback: function() {
					$.ajax({
						type: 'POST',
						url: __site_url+'common/not_show_term_popup',
						dataType: 'json',
						success: function(result){
							__not_show_term = true;
						},
						error: function(){
						}
					});
				}
			});
		bootbox.dialog($('#term-condition-content').html(), btns, {
			header:'ข้อกำหนดและเงื่อนไข',
			animate: false,
			classes: 'term-condition-modal'
		});
	}
};

$(function(){
	var common = window['common'] = new Common();

	common.initFormTip();

	common.initToolTip();

	common.popup.init();

	$('.show-boxes').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();

		common.popup.show(this);
	});

	$('#menu-1 .menu-1, #menu-2 .menu-4').unbind('click').bind('click', function(e){
		e.preventDefault();
		common.showConditionPopup();
	});

	// disable drag image at all
	$('a,img,area').on('dragstart', function(event) { event.preventDefault(); });
});
