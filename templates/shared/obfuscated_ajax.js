var az=false;function aarq(as,o,s){var bbb=null;if((!as)||(!o))return false;if(window.XMLHttpRequest)bbb=new XMLHttpRequest();else{if(window.ActiveXObject){az=true;bbb=new ActiveXObject("Microsoft.XMLHTTP");}}if(bbb){bbb.onreadystatechange=function(){if(bbb.readyState==4){try{if(bbb.status==200){o(bbb.responseText,bbb.responseXML);}else{if(s)s();}}finally{}}};bbb.open('GET',as,true);bbb.send('');}return false;}function aasf(r,bc,o,s){var bbb=null;var n=document.getElementById(r);var url='';var method='get';if(!n)return false;if(!bc){if(n.action)url=n.action;}else{url=bc;}if(url=='')return false;if(n.method)method=n.method;var params=aacp(r);if(window.XMLHttpRequest)bbb=new XMLHttpRequest();else{if(window.ActiveXObject){az=true;bbb=new ActiveXObject("Microsoft.XMLHTTP");}}if(bbb){bbb.onreadystatechange=function(){if(bbb.readyState==4){try{if(bbb.status==200){if(o)o(bbb.responseText,bbb.responseXML);else{if(bbb.responseXML)aadp(bbb.responseXML);}}else{if(s)s();}}finally{aaec(r);}}};if(method.toLowerCase()=='get'){bbb.open('get',url+'?'+params,true);bbb.send('');}else{bbb.open('post',url,true);bbb.setRequestHeader("Content-Type","application/x-www-form-urlencoded");bbb.send(params);}aadc(r);}return true;}function aadp(al){if(!al)return false;var x;try{x=al.getElementsByTagName("elements")[0];}catch(e){return false;}if(x){var v,cv,bb,by,ba,m;for(v=0;v<x.childNodes.length;v++){m=x.childNodes[v];html_item=document.getElementById(m.nodeName);if(html_item){cv=m.getElementsByTagName("src")[0];if(cv)try{html_item.src=aagn(null,'src',m,0);}finally{}by=m.getElementsByTagName("value")[0];if(by)try{html_item.value=aagn(null,'value',m,0);}finally{}bb=m.getElementsByTagName("innerHTML")[0];if(bb)try{html_item.innerHTML=aagn(null,'innerHTML',m,0);}finally{}ba=m.getElementsByTagName("className")[0];if(ba)try{html_item.className=aagn(null,'className',m,0);}finally{}cd=m.getElementsByTagName("checked")[0];if(cd)try{html_item.checked=aagn(null,'checked',m,0);}finally{}}}}return true;}function aasn(bt,as){var cc=function(response_text,response_xml){aafc(bt,response_text);};return aarq(as,cc);}function aacp(r){var dn;var dh;var g;var p='';if(!r)return p;var n=document.getElementById(r);if(n)for(var v=0;v<n.elements.length;v++){if(p!='')p+='&';if(n.elements[v].type=='radio'){g=n.elements[n.elements[v].name];dh='null';for(dn=0;dn<g.length;dn++){if(g[dn].checked)dh=g[dn].value;}p+=n.elements[v].name+'='+dh;}else{p+=n.elements[v].name+'='+encodeURIComponent(n.elements[v].value);}}return p;}function aagn(ak,local,u,index){try{var p="";if(ak&&az){p=u.getElementsByTagName(ak+":"+local)[index];}else{p=u.getElementsByTagName(local)[index];}if(p){if(p.childNodes.length>1){return p.childNodes[1].nodeValue;}else{return p.firstChild.nodeValue;}}else{return"";}}catch(e){return"";}}function aadc(r){var n=document.getElementById(r);if(n)for(var v=0;v<n.elements.length;v++){n.elements[v].disabled=true;}}function aaec(r){var n=document.getElementById(r);if(n)for(var v=0;v<n.elements.length;v++){n.elements[v].disabled=false;}}function aafc(l,q){var p=false;try{var g=document.getElementById(l);if(g){g.innerHTML=q;p=true;}}finally{}return p;}