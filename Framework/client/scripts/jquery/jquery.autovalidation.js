(function(b){var a={reset:function(c){c.removeClass("input_ok");c.removeClass("input_error")},hide:function(){b("#input_msg").fadeOut("slow")},check:function(e){a.hide(e);a.reset(e);var d=e.closest("form").attr("action");var c=encodeURIComponent(e.attr("name"));var f=encodeURIComponent(e.val());b.ajax({url:d,data:"ajax="+c+"&"+c+"="+f,type:"POST",dataType:"json",success:function(g){if(g.hasOwnProperty("valid")){if(g.valid){e.addClass("input_ok")}else{e.addClass("input_error")}}if(g.hasOwnProperty("messages")){if(g.messages.length>0){b("#input_msg").remove();b("body").append('<div id="input_msg"><div id="input_msg_txt">'+g.messages.join("<br />")+'</div><div id="input_msg_img"></div></div>');b("#input_msg").mouseover(function(){hideTip()});b("#input_msg").css("top",(e.position().top-b("#input_msg").height())+"px").css("left",e.position().left+"px").fadeIn("slow")}}}})}};b.fn.AutoValidator=function(){for(var c in clientValidation){if(clientValidation.hasOwnProperty(c)){b("*[name="+clientValidation[c]+"]").blur(function(){a.check(b(this))}).focus(function(){a.hide();a.reset(b(this))})}}}})(jQuery);$(document).ready(function(){$().AutoValidator()});