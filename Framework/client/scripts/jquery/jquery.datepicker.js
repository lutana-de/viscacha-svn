/**
 * Date picker
 * Author: Stefan Petre www.eyecon.ro
 * Dual licensed under the MIT and GPL licenses
 */
(function(b){var a=function(){var o={},f={years:"datepickerViewYears",moths:"datepickerViewMonths",days:"datepickerViewDays"},h={flat:false,starts:1,prev:"&#9664;",next:"&#9654;",lastSel:false,mode:"single",view:"days",calendars:1,format:"Y-m-d",position:"bottom",eventName:"click",onRender:function(){return{}},onChange:function(){return true},onShow:function(){return true},onBeforeShow:function(){return true},onHide:function(){return true},locale:{days:["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag","Sonntag"],daysShort:["So","Mo","Di","Mi","Do","Fr","Sa","So"],months:["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],monthsShort:["Jan","Feb","Mär","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"]}},m=function(){return'<div class="datepickerContainer"><table cellspacing="0" cellpadding="0"><tbody><tr></tr></tbody></table></div>'},e=function(){var y='<td><table cellspacing="0" cellpadding="0"><thead><tr><th class="datepickerGoPrev"><a href="#"><span><%=prev%></span></a></th><th colspan="5" class="datepickerMonth"><a href="#"><span></span></a></th><th class="datepickerGoNext"><a href="#"><span><%=next%></span></a></th></tr><tr class="datepickerDoW">';for(i=1;i<=7;i++){y+="<th><span><%=day"+i+"%></span></th>"}y+="</tr></thead></table></td>";return y},g=function(){var y='<tbody class="datepickerDays">';for(w=0;w<=5;w++){y+="<tr>";for(d=0;d<=6;d++){y+='<td class="<%=weeks['+w+"].days["+d+'].classname%>"><a href="#"><span><%=weeks['+w+"].days["+d+"].text%></span></a></td>"}y+="</tr>"}y+="</tbody>";return y},l=function(){var y='<tbody class="<%=className%>">';for(i=0;i<=2;i++){y+="<tr>";for(d=0;d<=3;d++){y+='<td colspan="2"><a href="#"><span><%=data['+(i*4+d)+"]%></span></a></td>"}y+="</tr>"}y+="</tbody>";return y},q=function(x){var A=b(x).data("datepicker");var E=b(x);var y=Math.floor(A.calendars/2),L,N,F,M,J=0,B,z,C,D,G;E.find("td>table tbody").remove();for(var K=0;K<A.calendars;K++){L=new Date(A.current);L.addMonths(-y+K);G=E.find("table").eq(K+1);switch(G[0].className){case"datepickerViewDays":F=k(L,"F Y");break;case"datepickerViewMonths":F=L.getFullYear();break;case"datepickerViewYears":F=(L.getFullYear()-6)+" - "+(L.getFullYear()+5);break}G.find("thead tr:first th:eq(1) span").text(F);F=L.getFullYear()-6;N={data:[],className:"datepickerYears"};for(var I=0;I<12;I++){N.data.push(F+I)}D=tmpl(l(),N);L.setDate(1);N={weeks:[],test:10};M=L.getMonth();var F=(L.getDay()-A.starts)%7;L.addDays(-(F+(F<0?7:0)));J=0;while(J<42){z=parseInt(J/7,10);C=J%7;if(!N.weeks[z]){N.weeks[z]={days:[]}}N.weeks[z].days[C]={text:L.getDate(),classname:[]};if(M!=L.getMonth()){N.weeks[z].days[C].classname.push("datepickerNotInMonth")}if(L.getDay()==0){N.weeks[z].days[C].classname.push("datepickerSunday")}if(L.getDay()==6){N.weeks[z].days[C].classname.push("datepickerSaturday")}var H=A.onRender(L);var O=L.valueOf();if(H.selected||A.date==O||b.inArray(O,A.date)>-1||(A.mode=="range"&&O>=A.date[0]&&O<=A.date[1])){N.weeks[z].days[C].classname.push("datepickerSelected")}if(H.disabled){N.weeks[z].days[C].classname.push("datepickerDisabled")}if(H.className){N.weeks[z].days[C].classname.push(H.className)}N.weeks[z].days[C].classname=N.weeks[z].days[C].classname.join(" ");J++;L.addDays(1)}D=tmpl(g(),N)+D;N={data:A.locale.monthsShort,className:"datepickerMonths"};D=tmpl(l(),N)+D;G.append(D)}},v=function(z,J){if(z.constructor==Date){return new Date(z)}var D=z.split(/\W+/);var A=J.split(/\W+/),H,B,I,F,C,G,x=new Date();for(var E=0;E<D.length;E++){switch(A[E]){case"d":case"j":H=parseInt(D[E],10);break;case"m":case"n":B=parseInt(D[E],10)-1;break;case"Y":case"y":I=parseInt(D[E],10);I+=I>100?0:(I<29?2000:1900);break;case"g":case"G":case"h":case"H":F=parseInt(D[E],10);break;case"a":case"A":if(/pm/i.test(D[E])&&F<12){F+=12}else{if(/am/i.test(D[E])&&F>=12){F-=12}}break;case"i":C=parseInt(D[E],10);break;case"s":G=parseInt(D[E],10);break}}return new Date(!(I>=1000&&I<=2999)?x.getFullYear():I,!(B>=1&&B<=12)?x.getMonth():B,!(H>=1&&H<=31)?x.getDate():H,!(F>=0&&F<=23)?x.getHours():F,!(C>=0&&C<=59)?x.getMinutes():C,!(G>=0&&G<=59)?x.getSeconds():G)},k=function(z,J){var A=z.getMonth();var H=z.getDate();var I=z.getFullYear();var K=z.getWeekNumber();var L=z.getDay();var O={};var M=z.getHours();var B=(M>=12);var F=(B)?(M-12):M;var N=z.getDayOfYear();if(F==0){F=12}var D=z.getMinutes();var G=z.getSeconds();var C=J.split(""),x;for(var E=0;E<C.length;E++){x=C[E];switch(C[E]){case"D":x=z.getDayName();break;case"l":x=z.getDayName(true);break;case"M":x=z.getMonthName();break;case"F":x=z.getMonthName(true);break;case"C":x=1+Math.floor(I/100);break;case"d":x=(H<10)?("0"+H):H;break;case"j":x=H;break;case"H":x=(M<10)?("0"+M):M;break;case"h":x=(F<10)?("0"+F):F;break;case"z":x=(N<100)?((N<10)?("00"+N):("0"+N)):N;break;case"G":x=M;break;case"g":x=F;break;case"m":x=(A<9)?("0"+(1+A)):(1+A);break;case"i":x=(D<10)?("0"+D):D;break;case"A":x=B?"PM":"AM";break;case"a":x=B?"pm":"am";break;case"U":x=Math.floor(z.getTime()/1000);break;case"s":x=(G<10)?("0"+G):G;break;case"N":x=L+1;break;case"w":x=L;break;case"y":x=(""+I).substr(2,2);break;case"Y":x=I;break}C[E]=x}return C.join("")},r=function(x){if(Date.prototype.tempDate){return}Date.prototype.tempDate=null;Date.prototype.months=x.months;Date.prototype.monthsShort=x.monthsShort;Date.prototype.days=x.days;Date.prototype.daysShort=x.daysShort;Date.prototype.getMonthName=function(y){return this[y?"months":"monthsShort"][this.getMonth()]};Date.prototype.getDayName=function(y){return this[y?"days":"daysShort"][this.getDay()]};Date.prototype.addDays=function(y){this.setDate(this.getDate()+y);this.tempDate=this.getDate()};Date.prototype.addMonths=function(y){if(this.tempDate==null){this.tempDate=this.getDate()}this.setDate(1);this.setMonth(this.getMonth()+y);this.setDate(Math.min(this.tempDate,this.getMaxDays()))};Date.prototype.addYears=function(y){if(this.tempDate==null){this.tempDate=this.getDate()}this.setDate(1);this.setFullYear(this.getFullYear()+y);this.setDate(Math.min(this.tempDate,this.getMaxDays()))};Date.prototype.getMaxDays=function(){var z=new Date(Date.parse(this)),A=28,y;y=z.getMonth();A=28;while(z.getMonth()==y){A++;z.setDate(A)}return A-1};Date.prototype.getFirstDay=function(){var y=new Date(Date.parse(this));y.setDate(1);return y.getDay()};Date.prototype.getWeekNumber=function(){var y=new Date(this);y.setDate(y.getDate()-(y.getDay()+6)%7+3);var z=y.valueOf();y.setMonth(0);y.setDate(4);return Math.round((z-y.valueOf())/(604800000))+1};Date.prototype.getDayOfYear=function(){var y=new Date(this.getFullYear(),this.getMonth(),this.getDate(),0,0,0);var A=new Date(this.getFullYear(),0,0,0,0,0);var z=y-A;return Math.floor(z/24*60*60*1000)}},t=function(A){var y=b(A).data("datepicker");var C=b("#"+y.id);var B=C.find("table:first").get(0);var z=B.offsetWidth;var x=B.offsetHeight;C.find("div.datepickerContainer").css({width:z+"px",height:x+"px"})},n=function(E){if(b(E.target).is("span")){E.target=E.target.parentNode}var z=b(E.target);if(z.is("a")){E.target.blur();if(z.hasClass("datepickerDisabled")){return false}var G=b(this).data("datepicker");var D=z.parent();var y=D.parent().parent().parent();var F=b("table",this).index(y.get(0))-1;var C=new Date(G.current);var B=false;var x=false;if(D.is("th")){if(D.hasClass("datepickerWeek")&&G.mode=="range"&&!D.next().hasClass("datepickerDisabled")){var A=parseInt(D.next().text(),10);C.addMonths(F-Math.floor(G.calendars/2));if(D.next().hasClass("datepickerNotInMonth")){C.addMonths(A>15?-1:1)}C.setDate(A);G.date[0]=(C.setHours(0,0,0,0)).valueOf();C.setHours(23,59,59,0);C.addDays(6);G.date[1]=C.valueOf();x=true;B=true;G.lastSel=false}else{if(D.hasClass("datepickerMonth")){C.addMonths(F-Math.floor(G.calendars/2));switch(y.get(0).className){case"datepickerViewDays":y.get(0).className="datepickerViewMonths";z.find("span").text(C.getFullYear());break;case"datepickerViewMonths":y.get(0).className="datepickerViewYears";z.find("span").text((C.getFullYear()-6)+" - "+(C.getFullYear()+5));break;case"datepickerViewYears":y.get(0).className="datepickerViewDays";z.find("span").text(k(C,"F Y"));break}}else{if(D.parent().parent().is("thead")){switch(y.get(0).className){case"datepickerViewDays":G.current.addMonths(D.hasClass("datepickerGoPrev")?-1:1);break;case"datepickerViewMonths":G.current.addYears(D.hasClass("datepickerGoPrev")?-1:1);break;case"datepickerViewYears":G.current.addYears(D.hasClass("datepickerGoPrev")?-12:12);break}x=true}}}}else{if(D.is("td")&&!D.hasClass("datepickerDisabled")){switch(y.get(0).className){case"datepickerViewMonths":G.current.setMonth(y.find("tbody.datepickerMonths td").index(D));G.current.setFullYear(parseInt(y.find("thead th.datepickerMonth span").text(),10));G.current.addMonths(Math.floor(G.calendars/2)-F);y.get(0).className="datepickerViewDays";break;case"datepickerViewYears":G.current.setFullYear(parseInt(z.text(),10));y.get(0).className="datepickerViewMonths";break;default:var A=parseInt(z.text(),10);C.addMonths(F-Math.floor(G.calendars/2));if(D.hasClass("datepickerNotInMonth")){C.addMonths(A>15?-1:1)}C.setDate(A);switch(G.mode){case"multiple":A=(C.setHours(0,0,0,0)).valueOf();if(b.inArray(A,G.date)>-1){b.each(G.date,function(H,I){if(I==A){G.date.splice(H,1);return false}})}else{G.date.push(A)}break;case"range":if(!G.lastSel){G.date[0]=(C.setHours(0,0,0,0)).valueOf()}A=(C.setHours(23,59,59,0)).valueOf();if(A<G.date[0]){G.date[1]=G.date[0]+86399000;G.date[0]=A-86399000}else{G.date[1]=A}G.lastSel=!G.lastSel;break;default:G.date=C.valueOf();break}B=true;break}x=true}}if(x){q(this)}if(B){G.onChange.apply(this,c(G))}}return false},c=function(x){var y;if(x.mode=="single"){y=new Date(x.date);return[k(y,x.format),y,x.el]}else{y=[[],[],x.el];b.each(x.date,function(A,B){var z=new Date(B);y[0].push(k(z,x.format));y[1].push(z)});return y}},s=function(){var x=document.compatMode=="CSS1Compat";return{l:window.pageXOffset||(x?document.documentElement.scrollLeft:document.body.scrollLeft),t:window.pageYOffset||(x?document.documentElement.scrollTop:document.body.scrollTop),w:window.innerWidth||(x?document.documentElement.clientWidth:document.body.clientWidth),h:window.innerHeight||(x?document.documentElement.clientHeight:document.body.clientHeight)}},p=function(z,y,x){if(z==y){return true}if(z.contains){return z.contains(y)}if(z.compareDocumentPosition){return !!(z.compareDocumentPosition(y)&16)}var A=y.parentNode;while(A&&A!=x){if(A==z){return true}A=A.parentNode}return false},u=function(C){var x=b("#"+b(this).data("datepickerId"));if(!x.is(":visible")){var D=x.get(0);q(D);var F=x.data("datepicker");F.onBeforeShow.apply(this,[x.get(0)]);var A=b(this).offset();var E=s();var B=A.top;var y=A.left;var z=b.curCSS(D,"display");x.css({visibility:"hidden",display:"block"});t(D);switch(F.position){case"top":B-=D.offsetHeight;break;case"left":y-=D.offsetWidth;break;case"right":y+=this.offsetWidth;break;case"bottom":B+=this.offsetHeight;break}if(B+D.offsetHeight>E.t+E.h){B=A.top-D.offsetHeight}if(B<E.t){B=A.top+this.offsetHeight+D.offsetHeight}if(y+D.offsetWidth>E.l+E.w){y=A.left-D.offsetWidth}if(y<E.l){y=A.left+this.offsetWidth}x.css({visibility:"visible",display:"block",top:B+"px",left:y+"px"});if(F.onShow.apply(this,[x.get(0)])!=false){x.show()}b(document).bind("mousedown",{cal:x,trigger:this},j)}return false},j=function(x){if(x.target!=x.data.trigger&&!p(x.data.cal.get(0),x.target,x.data.cal.get(0))){if(x.data.cal.data("datepicker").onHide.apply(this,[x.data.cal.get(0)])!=false){x.data.cal.hide()}b(document).unbind("mousedown",j)}};return{init:function(x){x=b.extend({},h,x||{});r(x.locale);x.calendars=Math.max(1,parseInt(x.calendars,10)||1);x.mode=/single|multiple|range/.test(x.mode)?x.mode:"single";return this.each(function(){if(!b(this).data("datepicker")){x.el=this;if(x.date.constructor==String){x.date=v(x.date,x.format);x.date.setHours(0,0,0,0)}if(x.mode!="single"){if(x.date.constructor!=Array){x.date=[x.date.valueOf()];if(x.mode=="range"){x.date.push(((new Date(x.date[0])).setHours(23,59,59,0)).valueOf())}}else{for(var A=0;A<x.date.length;A++){x.date[A]=(v(x.date[A],x.format).setHours(0,0,0,0)).valueOf()}if(x.mode=="range"){x.date[1]=((new Date(x.date[1])).setHours(23,59,59,0)).valueOf()}}}else{x.date=x.date.valueOf()}if(!x.current){x.current=new Date()}else{x.current=v(x.current,x.format)}x.current.setDate(1);x.current.setHours(0,0,0,0);var C="datepicker_"+parseInt(Math.random()*1000),z;x.id=C;b(this).data("datepickerId",x.id);var B=b(m()).attr("id",C).bind("click",n).data("datepicker",x);if(x.className){B.addClass(x.className)}var y="";for(A=0;A<x.calendars;A++){z=x.starts;y+=tmpl(e(),{prev:x.prev,next:x.next,day1:x.locale.daysShort[(z++)%7],day2:x.locale.daysShort[(z++)%7],day3:x.locale.daysShort[(z++)%7],day4:x.locale.daysShort[(z++)%7],day5:x.locale.daysShort[(z++)%7],day6:x.locale.daysShort[(z++)%7],day7:x.locale.daysShort[(z++)%7]})}B.find("tr:first").append(y).find("table").addClass(f[x.view]);q(B.get(0));if(x.flat){B.appendTo(this).show().css("position","relative");t(B.get(0))}else{B.appendTo(document.body);b(this).bind(x.eventName,u)}}})},showPicker:function(){return this.each(function(){if(b(this).data("datepickerId")){u.apply(this)}})},hidePicker:function(){return this.each(function(){if(b(this).data("datepickerId")){b("#"+b(this).data("datepickerId")).hide()}})},setDate:function(x,y){return this.each(function(){if(b(this).data("datepickerId")){var B=b("#"+b(this).data("datepickerId"));var z=B.data("datepicker");z.date=x;if(z.date.constructor==String){z.date=v(z.date,z.format);z.date.setHours(0,0,0,0)}if(z.mode!="single"){if(z.date.constructor!=Array){z.date=[z.date.valueOf()];if(z.mode=="range"){z.date.push(((new Date(z.date[0])).setHours(23,59,59,0)).valueOf())}}else{for(var A=0;A<z.date.length;A++){z.date[A]=(v(z.date[A],z.format).setHours(0,0,0,0)).valueOf()}if(z.mode=="range"){z.date[1]=((new Date(z.date[1])).setHours(23,59,59,0)).valueOf()}}}else{z.date=z.date.valueOf()}if(y){z.current=new Date(z.mode!="single"?z.date[0]:z.date)}q(B.get(0))}})},getDate:function(x){if(this.size()>0){return c(b("#"+b(this).data("datepickerId")).data("datepicker"))[x?0:1]}},clear:function(){return this.each(function(){if(b(this).data("datepickerId")){var y=b("#"+b(this).data("datepickerId"));var x=y.data("datepicker");if(x.mode!="single"){x.date=[];q(y.get(0))}}})},fixLayout:function(){return this.each(function(){if(b(this).data("datepickerId")){var y=b("#"+b(this).data("datepickerId"));var x=y.data("datepicker");if(x.flat){t(y.get(0))}}})}}}();b.fn.extend({DatePicker:a.init,DatePickerHide:a.hidePicker,DatePickerShow:a.showPicker,DatePickerSetDate:a.setDate,DatePickerGetDate:a.getDate,DatePickerClear:a.clear,DatePickerLayout:a.fixLayout})})(jQuery);(function(){var b={};this.tmpl=function a(f,e){var c=!/\W/.test(f)?b[f]=b[f]||a(document.getElementById(f).innerHTML):new Function("obj","var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('"+f.replace(/[\r\t\n]/g," ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g,"$1\r").replace(/\t=(.*?)%>/g,"',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'")+"');}return p.join('');");return e?c(e):c}})();