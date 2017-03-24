/*
 * Función para hacer llamadas AJAX usando GET
 */
function getAjax(url, success) {
  const xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  xhr.open('GET', url);
  xhr.onreadystatechange = function() {
      if (xhr.readyState>3 && xhr.status==200) success(JSON.parse(xhr.responseText));
  };
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.send();
  return xhr;
}

/*
 * Función para hacer llamadas AJAX usando POST
 */
function postAjax(url, data, success) {
  const params = typeof data == 'string' ? data : Object.keys(data).map(
          function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
      ).join('&');

  const xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  xhr.open('POST', url);
  xhr.onreadystatechange = function() {
      if (xhr.readyState>3 && xhr.status==200) { success(JSON.parse(xhr.responseText)); }
  };
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(params);
  return xhr;
}

/*

 */
function postAjaxFile(url,params,callback){
  const fd = new FormData();
  for (let ind in params){
    fd.append(ind, params[ind]);
  }

  const xhr = new XMLHttpRequest;

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4){
      if (xhr.status == 200){
        callback && callback(JSON.parse(xhr.responseText));
      }
    }
  };
  xhr.open('POST', url);
  xhr.send(fd);
}

/*
 * Función para renderizar plantillas
 */
function template(id,data){
  let obj = document.getElementById(id).innerHTML;

  for (let ind in data){
    obj = obj.replace(new RegExp('{{'+ind+'}}',"g") ,data[ind]);
  }

  return obj;
}

/*
 * Función equivalente al urlencode de php
 */
function urlencode(s){
  return encodeURIComponent( s ).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
}

/*
 * Función equivalente al urldecode de php
 */
function urldecode(s){
  return decodeURIComponent( s.replace( /\+/g, '%20' ).replace( /\%21/g, '!' ).replace( /\%27/g, "'" ).replace( /\%28/g, '(' ).replace( /\%29/g, ')' ).replace( /\%2A/g, '*' ).replace( /\%7E/g, '~' ) );
}

/*
 * Función para obtener el slug de un texto
 */
function slugify(text){
  text = text.toLowerCase();
	text = text.replace(/[^-a-zA-Z0-9,&\s]+/ig, '');
	text = text.replace(/-/gi, "_");
	text = text.replace(/\s/gi, "-");
	return text;
}

/*
 * Funciones equivalentes a trim de php
 */
function trim(str, chars){
  return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars){
  chars = chars || "\\s";
  return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars){
  chars = chars || "\\s";
  return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}