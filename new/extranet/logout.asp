<%@Language=JavaScript%>
<%Response.Buffer = true%>
<%
Session.Abandon()
Response.Redirect("index.asp")
%>
