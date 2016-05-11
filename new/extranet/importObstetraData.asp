<%@Language=JavaScript%>
<%Response.Buffer = true%>
<!--#include virtual="/extranet/classes/xmlParser.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/obstetra.asp" -->
<%
//Numero de variaveis passadas (devido a limitacao de 102399 bytes por var em um post)
num =  Request("c").item

//Montagem da string xml com o conteudo
var importContent = ""
for(i = 0; i < num; i++)
{
   importContent += Request("i"+i).item
}

//importContent = '<?xml version="1.0"?><OBSTETRAS><OBSTETRA id="2"><NAME>1234</NAME><CRM>NULL</CRM><EMAIL>NULL</EMAIL><ADDRESS>NULL</ADDRESS><STATE>NULL</STATE><CITY>NULL</CITY><CEP>1234</CEP><CPF>NULL</CPF><RAZAO_SOCIAL>NULL</RAZAO_SOCIAL><SECRETARY>NULL</SECRETARY><SECOND_CEP>NULL</SECOND_CEP><PHONE1>NULL</PHONE1><PHONE2>NULL</PHONE2><PHONE3>NULL</PHONE3><SECOND_ADDRESS>NULL</SECOND_ADDRESS><SECOND_STATE>NULL</SECOND_STATE><SECOND_CITY>NULL</SECOND_CITY><BANCO>NULL</BANCO><AGENCIA>NULL</AGENCIA><CONTA_CORRENTE>NULL</CONTA_CORRENTE><PARCEIRO>1</PARCEIRO><TYPE>0</TYPE><TEM_DISPLAY>1</TEM_DISPLAY><EXTRANET_USERNAME>obs</EXTRANET_USERNAME><EXTRANET_PASSWORD>123</EXTRANET_PASSWORD></OBSTETRA><OBSTETRA id="1"><NAME>MEDICO 1</NAME><CRM>NULL</CRM><EMAIL>NULL</EMAIL><ADDRESS>NULL</ADDRESS><STATE>RJ</STATE><CITY>NULL</CITY><CEP>NULL</CEP><CPF>NULL</CPF><RAZAO_SOCIAL>NULL</RAZAO_SOCIAL><SECRETARY>NULL</SECRETARY><SECOND_CEP>NULL</SECOND_CEP><PHONE1>NULL</PHONE1><PHONE2>NULL</PHONE2><PHONE3>NULL</PHONE3><SECOND_ADDRESS>NULL</SECOND_ADDRESS><SECOND_STATE>NULL</SECOND_STATE><SECOND_CITY>NULL</SECOND_CITY><BANCO>NULL</BANCO><AGENCIA>NULL</AGENCIA><CONTA_CORRENTE>NULL</CONTA_CORRENTE><PARCEIRO>1</PARCEIRO><TYPE>2</TYPE><TEM_DISPLAY>1</TEM_DISPLAY><EXTRANET_USERNAME>mama</EXTRANET_USERNAME><EXTRANET_PASSWORD>1233</EXTRANET_PASSWORD></OBSTETRA></OBSTETRAS>'
xmlBean = new xmlParser(importContent)

numberOfImports = parseInt(xmlBean.getNumberOfItems("OBSTETRA"))

arrObstetraID       = xmlBean.getAllAttibuteValues("OBSTETRA","id")
arrName             = xmlBean.getTagValue("NAME")
arrCrm              = xmlBean.getTagValue("CRM")
arrEmail            = xmlBean.getTagValue("EMAIL")
arrAddress          = xmlBean.getTagValue("ADDRESS")
arrState            = xmlBean.getTagValue("STATE")
arrCity             = xmlBean.getTagValue("CITY")
arrCep              = xmlBean.getTagValue("CEP")
arrCpf              = xmlBean.getTagValue("CPF")
arrRazaoSocial      = xmlBean.getTagValue("RAZAO_SOCIAL")
arrSecretary        = xmlBean.getTagValue("SECRETARY")
arrSecondCep        = xmlBean.getTagValue("SECOND_CEP")
arrPhone1           = xmlBean.getTagValue("PHONE1")
arrPhone2           = xmlBean.getTagValue("PHONE2")
arrPhone3           = xmlBean.getTagValue("PHONE3")
arrSecondAddress    = xmlBean.getTagValue("SECOND_ADDRESS")
arrSecondState      = xmlBean.getTagValue("SECOND_STATE")
arrSecondCity       = xmlBean.getTagValue("SECOND_CITY")
arrBanco            = xmlBean.getTagValue("BANCO")
arrAgencia          = xmlBean.getTagValue("AGENCIA")
arrContaCorrente    = xmlBean.getTagValue("CONTA_CORRENTE")
arrParceiro         = xmlBean.getTagValue("PARCEIRO")
arrType             = xmlBean.getTagValue("TYPE")
arrTemDisplay       = xmlBean.getTagValue("TEM_DISPLAY")
arrExtranetUserName = xmlBean.getTagValue("EXTRANET_USERNAME")
arrExtranetPassword = xmlBean.getTagValue("EXTRANET_PASSWORD")

var arrObstetraData = new Array(
                               arrObstetraID,arrName,arrCrm,arrEmail,arrAddress,arrState,arrCity,
                               arrCep,arrCpf,arrRazaoSocial,arrSecretary,arrSecondCep, arrPhone1,
                               arrPhone2,arrPhone3,arrSecondAddress,arrSecondState,arrSecondCity,arrBanco,arrAgencia,
                               arrContaCorrente,arrParceiro,arrType,arrTemDisplay,arrExtranetUserName,arrExtranetPassword
                               )

obstetraList = new obstetra()   
for(g = 0; g < numberOfImports; g++)
{  
 
   osbtetraInfo = obstetraList.getObstetraFromID(arrObstetraID[g])  
  
   if(osbtetraInfo == false)
   {
      Response.Write(" Executei insert" )
      obstetraList.insertObstetraData(arrObstetraData,g)
   }
   else
   {
   Response.Write(obstetraList.getName()+" Executei update" )
      obstetraList.updateObstetraData(arrObstetraData,g)
   }
}
%>DONE!
