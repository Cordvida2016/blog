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
%>