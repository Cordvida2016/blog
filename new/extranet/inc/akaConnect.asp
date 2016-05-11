<%
Function akaSelectClient(clientID)

Dim qrySQL
Dim ResultSet

//Criar include de conexão
connection = akaConnect()

qrySQL = "SELECT a.NAME AS paciente FROM client a WHERE a.clientid = " + clientID
set ResultSet=Server.CreateObject("ADODB.Recordset")

ResultSet.Open qrySQL, connection


akaSelectClient = ResultSet
End Function




Function akaConnect()
Dim ConnectString

//Criar include de conexão
Set connectme = Server.CreateObject("ADODB.Connection")
connectme.ConnectionString = "driver={MySQL ODBC 3.51 Driver};server=mysql03.bighost.com.br;uid=pklien;pwd=cocord;database=cordvid_extranet"
connectme.Open

akaConnect = connectme
End Function
%>