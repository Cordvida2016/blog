    var url = document.location.href;

    if (url.indexOf("?") > 0) {
      query = url.split("?"); 
      param = query[1].split("&");
      for ( i=0; i < param.length; i++) { 
         v = param[i].split("="); 
         eval("var "+v[0]+"=\""+v[1]+"\";");
      }
    }
      
    var expires;
    var date; 
    var value;
    date = new Date();
    date.setTime(date.getTime()+(24*60*60*1000));
    expires = date.toUTCString();
    document.cookie = "campanha_cv"+"="+campanha+"; expires="+expires+"; path=/";