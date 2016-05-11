<%@Language=JavaScript%>
<%Response.Buffer = true%>
<!--#include virtual="/extranet/classes/xmlParser.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/client.asp" -->
<%
//Numero de variaveis passadas (devido a limitacao de 102399 bytes por var em um post)
num =  Request("c").item

Response.Write("--> " + num)

//Montagem da string xml com o conteudo
importContent = ""
for(i = 0; i < num; i++)
{
   importContent += Request("i"+i).item
}

xmlBean = new xmlParser(importContent)

numberOfImports = parseInt(xmlBean.getNumberOfItems("CLIENT"))

arrClientID    = xmlBean.getAllAttibuteValues("CLIENT","id")
arrName        = xmlBean.getTagValue("NAME")
arrSex         = xmlBean.getTagValue("SEX")
arrNameFather  = xmlBean.getTagValue("NAMEFATHER")
arrEmailFather = xmlBean.getTagValue("EMAILFATHER")
arrDocFather   = xmlBean.getTagValue("DOCFATHER")
arrCpfFather   = xmlBean.getTagValue("CPFFATHER")
arrNameMother  = xmlBean.getTagValue("NAMEMOTHER")
arrEmailMother = xmlBean.getTagValue("EMAILMOTHER")
arrDocMother   = xmlBean.getTagValue("DOCMOTHER")
arrCpfMother   = xmlBean.getTagValue("CPFMOTHER")
arrAddress     = xmlBean.getTagValue("ADDRESS")
arrPhone1      = xmlBean.getTagValue("PHONE1")
arrPhone2      = xmlBean.getTagValue("PHONE2")
arrPhone3      = xmlBean.getTagValue("PHONE3")
arrCity        = xmlBean.getTagValue("CITY")
arrState       = xmlBean.getTagValue("STATE")
arrZip         = xmlBean.getTagValue("ZIP")
arrBirthMother = xmlBean.getTagValue("BIRTHMOTHER")
arrExtranetUsername = xmlBean.getTagValue("EXTRANET_USERNAME")
arrExtranetPassword = xmlBean.getTagValue("EXTRANET_PASSWORD")

//DADOS DE COLETA DO CLIENTE
arrNurse    = xmlBean.getTagValue("NURSE")
arrCorenNurse = xmlBean.getAllAttibuteValues("NURSE","coren")
arrDoneBy   = xmlBean.getTagValue("DONE_BY") //INDICADOR DE QUEM FEZ A COLETA, ENFERMEIRA OU OBSTETRA
arrObstetra = xmlBean.getTagValue("OBSTETRA")
arrCRMObstetra = xmlBean.getAllAttibuteValues("OBSTETRA","crm")
arrHospital = xmlBean.getTagValue("HOSPITAL")

//DATA E HORA DA COLETA (NASCIMENTO)
arrBirthDate   = xmlBean.getTagValue("BIRTH_DATE")
arrBirthHour   = xmlBean.getTagValue("BIRTH_HOUR")
arrBirthMinute = xmlBean.getTagValue("BIRTH_MINUTE")

//DATA E HORA DA CRIOPRESERVAÇÃO
arrBioDate   = xmlBean.getTagValue("BIO_DATE")
arrBioHour   = xmlBean.getTagValue("BIO_HOUR")
arrBioMinute = xmlBean.getTagValue("BIO_MINUTE")

//DADOS DE PROCESSAMENTO (SCUP)
arrVolumeAmostra = xmlBean.getTagValue("VOLUME_AMOSTRA")
arrViabilidade   = xmlBean.getTagValue("VIABILIDADE_CELULAR")
arrCd34          = xmlBean.getTagValue("CELULAS_CD34")
arrBioID         = xmlBean.getTagValue("BIO_ID")
arrEstBac        = xmlBean.getTagValue("ESTERELIDADE_BACTERIA")
arrExtFun        = xmlBean.getTagValue("ESTERELIDADE_FUNGOS")


var arrClientData = new Array(
                               arrClientID,arrName,arrSex,arrNameFather,arrEmailFather,arrDocFather,arrCpfFather,
                               arrNameMother,arrEmailMother,arrDocMother,arrCpfMother,arrAddress, arrPhone1,
                               arrPhone2,arrPhone3,arrCity,arrState,arrZip,arrBirthMother,arrExtranetUsername,
                               arrExtranetPassword,arrNurse,arrDoneBy,arrObstetra,arrHospital,arrBirthDate,
                               arrBirthHour,arrBirthMinute,arrBioDate,arrBioHour,arrBioMinute,arrVolumeAmostra,
                               arrViabilidade,arrCd34,arrBioID,arrEstBac,arrExtFun,arrCorenNurse,arrCRMObstetra
                               )

clientsList = new clientData()   
for(g = 0; g < numberOfImports; g++)
{  
 
   clientInfo = clientsList.getClientFromID(arrClientID[g])  
  
   if(clientInfo == false)
   {
      clientsList.insertClientData(arrClientData,g)
   }
   else
   {
      clientsList.updateClientData(arrClientData,g)
   }
}
%>DONE!
