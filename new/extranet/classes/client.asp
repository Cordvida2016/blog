<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/login.asp" -->
<%
function clientData()
{
   //propriedades
   this.clientID      = null
   this.interacaoID   = null   
   this.name          = null
   this.sex           = null
   this.docChild      = null
   this.cpfChild      = null
   this.nameFather    = null
   this.emailFather   = null
   this.docFather     = null
   this.cpfFather     = null
   this.nameMother    = null
   this.emailMother   = null
   this.docMother     = null
   this.cpfMother     = null
   this.address       = null
   this.phone1        = null
   this.phone2        = null
   this.phone3        = null
   this.city          = null
   this.state         = null
   this.zip           = null
   this.birthMother   = null
   this.interleavedID = null
   this.bioArchiveID  = null
   this.dataInteracao = null
   this.horaInteracao    = null
   this.minutoInteracao  = null
   this.descricaoContato = null   
   this.errorMessage  = null
   
   //metodos de captura dos dados
   this.getClientData     = _getClientData
   this.getClientID       = _getClientID
   this.getAllClients     = _getAllClientData
   this.getName           = _getName
   this.getSex            = _getSex
   this.getDocChild       = _getDocChild
   this.getCPFChild       = _getCPFChild
   this.getNameFather     = _getNameFather
   this.getEmailFather    = _getEmailFather
   this.getDocFather      = _getDocFather
   this.getCPFFather      = _getCPFFather
   this.getNameMother     = _getNameMother
   this.getEmailMother    = _getEmailMother
   this.getDocMother      = _getDocMother
   this.getCPFMother      = _getCPFMother
   this.getAddress        = _getAddress
   this.getPhone1         = _getPhone1
   this.getPhone2         = _getPhone2
   this.getPhone3         = _getPhone3
   this.getCity           = _getCity
   this.getState          = _getState
   this.getZip            = _getZip
   this.getBirthMother    = _getBirthMother
   this.getInterleavedID  = _getInterleavedID
   this.getBioArchiveID   = _getBioArchiveID    
   this.getInteracaoID      = _getInteracaoID 
   this.getDataInteracao    = _getDataInteracao
   this.getHoraInteracao    = _getHoraInteracao
   this.getMinutoInteracao  = _getMinutoInteracao
   this.getDescricaoContato = _getDescricaoContato
   
   
   //metodos de tratamentos de dados
   this.insertClientData   = _insertClientData 
   this.updateClientData   = _updateClientData
   this.getClientFromID    = _getClientFromID
   this.getClientByName    = _getClientByName
   this.getClientByDocs    = _getClientByDocs 
   this.getInterleavedCode = _getInterleavedCode   
   this.setBioArchiveID    = _setBioArchiveID
   this.insertInteracao    = _insertInteracao
   this.updateInteracao    = _updateInteracao
   this.getInteracao       = _getInteracao
   this.getInteracaoFromID = _getInteracaoFromID
   this.getAllInteracoes   = _getAllInteracoes  
   this.removeInteracao    = _removeInteracao   
   this.removeClient       = _removeClient

}

function _getClientID()
{
   return this.clientID
}

function _getDataInteracao()
{
   return this.dataInteracao
}

function _getHoraInteracao()
{
   return this.horaInteracao
}

function _getMinutoInteracao()
{
   return this.minutoInteracao
}

function _getDescricaoContato()
{
   return this.descricaoContato
}

function _getInteracaoID()
{
   return this.interacaoID
}

function _getName()
{
   return this.name
}

function _getSex()
{
   return this.sex
}

function _getDocChild()
{
   return this.docChild
}

function _getCPFChild()
{
   return this.cpfChild
} 

function _getNameFather()
{
   return this.nameFather
}

function _getEmailFather()
{
   return this.emailFather
}

function _getDocFather()
{
   return this.docFather
}

function _getCPFFather()
{
   return this.cpfFather
}

function _getNameMother()
{
   return this.nameMother
}

function _getEmailMother()
{
   return this.emailMother
}

function _getDocMother()
{
   return this.docMother
}

function _getCPFMother()
{
   return this.cpfMother
}

function _getAddress()
{
   return this.address
}

function _getPhone1()
{
   return this.phone1
}

function _getPhone2()
{
   return this.phone2
}

function _getPhone3()
{
   return this.phone3
}

function _getCity()
{
   return this.city
}

function _getState()
{
   return this.state
}

function _getZip()
{
   return this.zip
}

function _getBirthMother()
{
   return this.birthMother
}

function _getInterleavedID()
{
   return this.interleavedID
}

function _getBioArchiveID()
{
   return this.bioArchiveID
}

function _getClientFromID(ci)
{
   this.clientID = ci
   return this.getClientData()
}

function _getInteracaoFromID(ii)
{
   this.interacaoID = ii
   this.getInteracao()
}

function _insertClientData(arrOfData,pos)
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_CLIENTS_DATA"))
   
   name        = (arrOfData[1][pos] != "NULL")?arrOfData[1][pos]:""
   sex         = (arrOfData[2][pos] != "NULL")?arrOfData[2][pos]:"0"
   nameFather  = (arrOfData[3][pos] != "NULL")?arrOfData[3][pos]:""
   emailFather = (arrOfData[4][pos] != "NULL")?arrOfData[4][pos]:""
   docFather   = (arrOfData[5][pos] != "NULL")?arrOfData[5][pos]:""
   cpfFather   = (arrOfData[6][pos] != "NULL")?arrOfData[6][pos]:""
   nameMother  = (arrOfData[7][pos] != "NULL")?arrOfData[7][pos]:""
   emailMother = (arrOfData[8][pos] != "NULL")?arrOfData[8][pos]:""
   docMother   = (arrOfData[9][pos] != "NULL")?arrOfData[9][pos]:""
   cpfMother   = (arrOfData[10][pos] != "NULL")?arrOfData[10][pos]:""
   address     = (arrOfData[11][pos] != "NULL")?arrOfData[11][pos]:""
   phone1      = (arrOfData[12][pos] != "NULL")?arrOfData[12][pos]:""
   phone2      = (arrOfData[13][pos] != "NULL")?arrOfData[13][pos]:""
   phone3      = (arrOfData[14][pos] != "NULL")?arrOfData[14][pos]:""
   city        = (arrOfData[15][pos] != "NULL")?arrOfData[15][pos]:""
   state       = (arrOfData[16][pos] != "NULL")?arrOfData[16][pos]:""
   zip         = (arrOfData[17][pos] != "NULL")?arrOfData[17][pos]:""
   birthMother = (arrOfData[18][pos] != "NULL")?strDateToMySQL(arrOfData[18][pos]):""
   clientID    = (arrOfData[0][pos]  != "NULL")?arrOfData[0][pos]:""
   extranetUsername = (arrOfData[19][pos]  != "NULL")?arrOfData[19][pos]:""
   extranetPassword = (arrOfData[20][pos]  != "NULL")?arrOfData[20][pos]:""    
   
   
   arrCorenNurse = (arrOfData[37][pos]  != "NULL")?arrOfData[37][pos]:""
   arrNurse = (arrOfData[21][pos]  != "NULL")?arrOfData[21][pos]:""
   
   arrDoneBy = (arrOfData[22][pos]  != "NULL")?arrOfData[22][pos]:"0"
   arrObstetra = (arrOfData[23][pos]  != "NULL")?arrOfData[23][pos]:""
   arrCRMObstetra = (arrOfData[38][pos]  != "NULL")?arrOfData[38][pos]:""
  
   arrHospital = (arrOfData[24][pos]  != "NULL")?arrOfData[24][pos]:""
   
   arrBirthDate = (arrOfData[25][pos]  != "NULL")?strDateToMySQL(arrOfData[25][pos]):""
   arrBirthHour = (arrOfData[26][pos]  != "NULL")?arrOfData[26][pos]:"00"
   arrBirthMinute = (arrOfData[27][pos]  != "NULL")?arrOfData[27][pos]:"00"
   if(arrBirthDate != "")
   {
      arrBirthDate += " " + arrBirthHour + ":" + arrBirthMinute + ":" + "00"      
   }
   
   arrBioDate = (arrOfData[28][pos]  != "NULL")?strDateToMySQL(arrOfData[28][pos]):""
   arrBioHour = (arrOfData[29][pos]  != "NULL")?arrOfData[29][pos]:"00"
   arrBioMinute = (arrOfData[30][pos]  != "NULL")?arrOfData[30][pos]:"00"
   if(arrBioDate != "")
   {
      arrBioDate += " " + arrBioHour + ":" + arrBioMinute + ":" + "00"
   }
   
   arrVolumeAmostra = (arrOfData[31][pos]  != "NULL")?arrOfData[31][pos]:"0"
   arrViabilidade = (arrOfData[32][pos]  != "NULL")?arrOfData[32][pos]:"0"
   arrCd34 = (arrOfData[33][pos]  != "NULL")?arrOfData[33][pos]:"0"
   arrBioID = (arrOfData[34][pos]  != "NULL")?arrOfData[34][pos]:""
   arrEstBac = (arrOfData[35][pos]  != "NULL")?arrOfData[35][pos]:"0"
   arrExtFun = (arrOfData[36][pos]  != "NULL")?arrOfData[36][pos]:"0"
   
   
   //definindo os valores dos campos na query
   clientQuery.setStr(1,name)
   clientQuery.setInt(2,sex)
   clientQuery.setStr(3,nameFather)
   clientQuery.setStr(4,emailFather)
   clientQuery.setStr(5,docFather)
   clientQuery.setStr(6,cpfFather)
   clientQuery.setStr(7,nameMother)
   clientQuery.setStr(8,emailMother)
   clientQuery.setStr(9,docMother)
   clientQuery.setStr(10,cpfMother)
   clientQuery.setStr(11,address)
   clientQuery.setStr(12,phone1)
   clientQuery.setStr(13,phone2)
   clientQuery.setStr(14,phone3)
   clientQuery.setStr(15,city)
   clientQuery.setStr(16,state)
   clientQuery.setStr(17,zip)
   clientQuery.setStr(18,birthMother)
   clientQuery.setInt(19,clientID)  
   clientQuery.setStr(20,extranetUsername)  
   clientQuery.setStr(21,extranetPassword)  
   
   
   clientQuery.setStr(22,arrNurse)
   clientQuery.setInt(23,arrDoneBy)
   clientQuery.setStr(24,arrObstetra)
   clientQuery.setStr(25,arrHospital)
   clientQuery.setStr(26,arrBirthDate)
   clientQuery.setStr(27,arrBioDate)
   clientQuery.setInt(28,arrVolumeAmostra.replace(",","."))
   clientQuery.setInt(29,arrViabilidade.replace(",","."))
   clientQuery.setInt(30,arrCd34.replace(",","."))
   clientQuery.setStr(31,arrBioID)
   clientQuery.setInt(32,arrEstBac.replace(",","."))
   clientQuery.setInt(33,arrExtFun.replace(",","."))
   clientQuery.setStr(34,arrCorenNurse) 
   clientQuery.setStr(35,arrCRMObstetra) 
   
     
   clientDataInsert   = new insertionDB()

   clientResult = clientDataInsert.execute(clientQuery.toString())   

   if(clientDataInsert.getErrorMessage() != null)
   {     
      errMessage = "Erro ao Inserir Novo Cliente\n<!--DB Error:" +clientDataInsert.getErrorMessage()+ clientQuery.toString() + "-->"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");   
   }
   
   clientDataInsert = null
   clientQuery = null
  

}


function _updateClientData(arrOfData,pos)
{
  
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_CLIENT_DATA"))

   name        = (arrOfData[1][pos] != "NULL")?arrOfData[1][pos]:""
   sex         = (arrOfData[2][pos] != "NULL")?arrOfData[2][pos]:"0"
   nameFather  = (arrOfData[3][pos] != "NULL")?arrOfData[3][pos]:""
   emailFather = (arrOfData[4][pos] != "NULL")?arrOfData[4][pos]:""
   docFather   = (arrOfData[5][pos] != "NULL")?arrOfData[5][pos]:""
   cpfFather   = (arrOfData[6][pos] != "NULL")?arrOfData[6][pos]:""
   nameMother  = (arrOfData[7][pos] != "NULL")?arrOfData[7][pos]:""
   emailMother = (arrOfData[8][pos] != "NULL")?arrOfData[8][pos]:""
   docMother   = (arrOfData[9][pos] != "NULL")?arrOfData[9][pos]:""
   cpfMother   = (arrOfData[10][pos] != "NULL")?arrOfData[10][pos]:""
   address     = (arrOfData[11][pos] != "NULL")?arrOfData[11][pos]:""
   phone1      = (arrOfData[12][pos] != "NULL")?arrOfData[12][pos]:""
   phone2      = (arrOfData[13][pos] != "NULL")?arrOfData[13][pos]:""
   phone3      = (arrOfData[14][pos] != "NULL")?arrOfData[14][pos]:""
   city        = (arrOfData[15][pos] != "NULL")?arrOfData[15][pos]:""
   state       = (arrOfData[16][pos] != "NULL")?arrOfData[16][pos]:""
   zip         = (arrOfData[17][pos] != "NULL")?arrOfData[17][pos]:""
   birthMother = (arrOfData[18][pos] != "NULL")?strDateToMySQL(arrOfData[18][pos]):""
   clientID    = (arrOfData[0][pos]  != "NULL")?arrOfData[0][pos]:""     
   extranetUsername = (arrOfData[19][pos]  != "NULL")?arrOfData[19][pos]:""
   extranetPassword = (arrOfData[20][pos]  != "NULL")?arrOfData[20][pos]:""

   arrCorenNurse = (arrOfData[37][pos]  != "NULL")?arrOfData[37][pos]:""
   arrNurse = (arrOfData[21][pos]  != "NULL")?arrOfData[21][pos]:""
   arrDoneBy = (arrOfData[22][pos]  != "NULL")?arrOfData[22][pos]:"0"
   arrCRMObstetra = (arrOfData[38][pos]  != "NULL")?arrOfData[38][pos]:""
   arrObstetra = (arrOfData[23][pos]  != "NULL")?arrOfData[23][pos]:""
   arrHospital = (arrOfData[24][pos]  != "NULL")?arrOfData[24][pos]:""
   
   arrBirthDate = (arrOfData[25][pos]  != "NULL")?strDateToMySQL(arrOfData[25][pos]):""
   arrBirthHour = (arrOfData[26][pos]  != "NULL")?arrOfData[26][pos]:"00"
   arrBirthMinute = (arrOfData[27][pos]  != "NULL")?arrOfData[27][pos]:"00"
   if(arrBirthDate != "")
   {
      arrBirthDate += " " + arrBirthHour + ":" + arrBirthMinute + ":" + "00"      
   }
   
   arrBioDate = (arrOfData[28][pos]  != "NULL")?strDateToMySQL(arrOfData[28][pos]):""
   arrBioHour = (arrOfData[29][pos]  != "NULL")?arrOfData[29][pos]:"00"
   arrBioMinute = (arrOfData[30][pos]  != "NULL")?arrOfData[30][pos]:"00"
   if(arrBioDate != "")
   {
      arrBioDate += " " + arrBioHour + ":" + arrBioMinute + ":" + "00"
   }
   
   arrVolumeAmostra = (arrOfData[31][pos]  != "NULL")?arrOfData[31][pos]:"0"
   arrViabilidade = (arrOfData[32][pos]  != "NULL")?arrOfData[32][pos]:"0"
   arrCd34 = (arrOfData[33][pos]  != "NULL")?arrOfData[33][pos]:"0"
   arrBioID = (arrOfData[34][pos]  != "NULL")?arrOfData[34][pos]:""
   arrEstBac = (arrOfData[35][pos]  != "NULL")?arrOfData[35][pos]:"0"
   arrExtFun = (arrOfData[36][pos]  != "NULL")?arrOfData[36][pos]:"0"
   
   
   //definindo os valores dos campos na query
   clientQuery.setStr(1,name)
   clientQuery.setInt(2,sex)
   clientQuery.setStr(3,nameFather)
   clientQuery.setStr(4,emailFather)
   clientQuery.setStr(5,docFather)
   clientQuery.setStr(6,cpfFather)
   clientQuery.setStr(7,nameMother)
   clientQuery.setStr(8,emailMother)
   clientQuery.setStr(9,docMother)
   clientQuery.setStr(10,cpfMother)
   clientQuery.setStr(11,address)
   clientQuery.setStr(12,phone1)
   clientQuery.setStr(13,phone2)
   clientQuery.setStr(14,phone3)
   clientQuery.setStr(15,city)
   clientQuery.setStr(16,state)
   clientQuery.setStr(17,zip)
   clientQuery.setStr(18,birthMother)
   clientQuery.setInt(35,clientID) 
   clientQuery.setStr(19,extranetUsername)  
   clientQuery.setStr(20,extranetPassword)   
   
   clientQuery.setStr(21,arrNurse)
   clientQuery.setInt(22,arrDoneBy)
   clientQuery.setStr(23,arrObstetra)
   clientQuery.setStr(24,arrHospital)
   clientQuery.setStr(25,arrBirthDate)
   clientQuery.setStr(26,arrBioDate)
   clientQuery.setInt(27,arrVolumeAmostra.replace(",","."))
   clientQuery.setInt(28,arrViabilidade.replace(",","."))
   clientQuery.setInt(29,arrCd34.replace(",","."))
   clientQuery.setStr(30,arrBioID)
   clientQuery.setInt(31,arrEstBac.replace(",","."))
   clientQuery.setInt(32,arrExtFun.replace(",",".")) 
   clientQuery.setStr(33,arrCorenNurse) 
   clientQuery.setStr(34,arrCRMObstetra)    
    
   
   clientData   = new updateDB()
   clientResult = clientData.execute(clientQuery.toString())   
   
   if(clientData.getErrorMessage() != null)
   {
      errMessage = "Erro Inesperado\n<!--DB Error:" +clientData.getErrorMessage()+  clientQuery.toString() + "-->"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");   
   }
   
   clientQuery = null

}

function _getClientData()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_CLIENT_DATA"))
   
   clientQuery.setInt(1,this.clientID)
   
   clientDatas   = new searchDB()
   clientResult = clientDatas.execute(clientQuery.toString())

   if(!clientDatas.EOF())
   {
      this.name        = clientDatas.getValue("name")
      this.sex         = parseInt(clientDatas.getValue("sex"))
      this.nameFather  = clientDatas.getValue("nameFather")
      this.emailFather = clientDatas.getValue("emailFather")
      this.docFather   = clientDatas.getValue("docFather")
      this.nameMother  = clientDatas.getValue("nameMother")
      this.emailMother = clientDatas.getValue("emailMother")
      this.docMother   = clientDatas.getValue("docMother")
      this.address     = clientDatas.getValue("address")
      this.phone1      = clientDatas.getValue("phone1")
      this.phone2      = clientDatas.getValue("phone2")
      this.phone3      = clientDatas.getValue("phone3")
      this.city        = clientDatas.getValue("city")
      this.state       = clientDatas.getValue("state")
      this.zip         = clientDatas.getValue("zip")
      this.birthMother = clientDatas.getValue("birthMother")
      this.cpfFather   = clientDatas.getValue("cpfFather")
      this.cpfMother   = clientDatas.getValue("cpfMother")
      this.docChild    = clientDatas.getValue("docChild")
      this.cpfChild    = clientDatas.getValue("cpfChild")
      this.interleavedID = clientDatas.getValue("interleavedID")
      this.bioArchiveID  = clientDatas.getValue("bioArchiveID")
      
      return true
   }
   else
   {
      return false     
   }
   
  
}

//Captura ID de padrao de codigo de barras interlaved 2-5 unico para cada usuario e redefine a chave para o proximo usuario
function _getInterleavedCode()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   codeQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_INTERLEAVEDID"))
   
   codeData     = new searchDB()
   clientResult = codeData.execute(codeQuery.toString())

   if(!codeData.EOF())
   {
      thisTempCode = codeData.getValue("interleavedID")
      
      codeData   = new updateDB()
      codeQuery.setQuery(cfgQuery.getKeyValue("UPDATE_INTERLEAVEDID"))
      clientResult = codeData.execute(codeQuery.toString()) 

      if(codeData.getErrorMessage() != null)
      {
         errMessage = "Erro ao tentar gravar informações para geração de código de barras!<br>Por favor entre em contato com o Administrador. <!-- " + codeData.getErrorMessage() + " -->"
         Session("errorMessage") = errMessage
         Response.Redirect("/extranet/error.asp");        
      }
      
      return thisTempCode    
   }
   else
   {
      errMessage = "Erro ao tentar gravar informações para geração de código de barras!<br>Por favor entre em contato com o Administrador."
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }  
}

//Captura bioArchiveID unico para cada usuario e redefine a chave para o proximo usuario
function _setBioArchiveID()
{
   cfgQuery  = new loadConfigFiles(CONFIG_QUERIES_FILE)
   codeQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_BIOARCHIVEID"))
   
   codeData     = new searchDB()
   clientResult = codeData.execute(codeQuery.toString())

   if(!codeData.EOF())
   {
      thisTempBioArchiveID = codeData.getValue("bioArchiveID")
      
      codeData   = new updateDB()
      codeQuery.setQuery(cfgQuery.getKeyValue("UPDATE_BIOARCHIVEID"))
      clientResult = codeData.execute(codeQuery.toString()) 

      if(codeData.getErrorMessage() != null)
      {
         errMessage = "Erro ao tentar gravar informações de BioArchive ID!<br>Por favor entre em contato com o Administrador. <!-- " + codeData.getErrorMessage() + " -->"
         Session("errorMessage") = errMessage
         Response.Redirect("/extranet/error.asp");        
      }
      
      return thisTempBioArchiveID    
   }
   else
   {
      errMessage = "Erro ao tentar gravar informações de BioArchive ID!<br>Por favor entre em contato com o Administrador."
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }  
}

//Lista todos os clientes cadastrados e não deletados
function _getAllClientData()
{
   cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery  = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_CLIENT_DATA"))
     
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   tempCounter = 0
   
   if(!clientData.EOF())
   {
      this.name          = new Array()
      this.sex           = new Array()
      this.nameFather    = new Array()
      this.emailFather   = new Array()
      this.docFather     = new Array()
      this.nameMother    = new Array()
      this.emailMother   = new Array()
      this.docMother     = new Array()
      this.address       = new Array()
      this.phone1        = new Array()
      this.phone2        = new Array()
      this.phone3        = new Array()
      this.city          = new Array()
      this.state         = new Array()
      this.zip           = new Array()
      this.birthMother   = new Array()  
      this.clientID      = new Array()
      this.cpfFather     = new Array()
      this.cpfMother     = new Array()    
      this.docChild      = new Array()
      this.cpfChild      = new Array()
      this.interleavedID = new Array()
      this.bioArchiveID  = new Array()
      
      while(!clientData.EOF())
      {
         this.name.push(clientData.getValue("name"))
         this.sex.push(parseInt(clientData.getValue("sex")))
         this.nameFather.push(clientData.getValue("nameFather"))
         this.emailFather.push(clientData.getValue("emailFather"))
         this.docFather.push(clientData.getValue("docFather"))
         this.nameMother.push(clientData.getValue("nameMother"))
         this.emailMother.push(clientData.getValue("emailMother"))
         this.docMother.push(clientData.getValue("docMother"))
         this.address.push(clientData.getValue("address"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.city.push(clientData.getValue("city"))
         this.state.push(clientData.getValue("state"))
         this.zip.push(clientData.getValue("zip"))
         this.birthMother.push(clientData.getValue("birthMother"))
         this.clientID.push(clientData.getValue("clientID"))
         this.cpfFather.push(clientData.getValue("cpfFather"))
         this.cpfMother.push(clientData.getValue("cpfMother"))
         this.docChild.push(clientData.getValue("docChild"))
         this.cpfChild.push(clientData.getValue("cpfChild"))
         this.interleavedID.push(clientData.getValue("interleavedID"))
         this.bioArchiveID.push(clientData.getValue("bioArchiveID"))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum Cliente Encontrado!"
      Session("errorMessage") = errMessage
      //Response.Redirect("/extranet/error.asp");       
   }
   
   return tempCounter
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null   
}

//Lista todos os clientes cadastrados e não deletados
function _getClientByName()
{
   //definindo os valores dos campos que vierem a uma hash que sera lida pelo statement para montar a query
   hashValues = new Array()
   
   name        = getRequestParameterAsString("n")
   nameBy      = getRequestParameterAsInt("by")
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_CLIENT_BY_NAME"))
   
   nameStringBy = ""
   switch(parseInt(nameBy))
   {
      case 1:
         nameStringBy = ""
      break
      case 2:
         nameStringBy = "Mother"
      break
      case 3:
         nameStringBy = "Father"
      break
   }   
   
   hashValues.push(new Array("LIKE","%"+name+"%","name"+nameStringBy,"AND"))  
   clientQuery.setDynamicQuery(1,hashValues)

   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   tempCounter = 0
   
   if(!clientData.EOF())
   {
      this.name         = new Array()
      this.sex          = new Array()
      this.nameFather   = new Array()
      this.emailFather  = new Array()
      this.docFather    = new Array()
      this.nameMother   = new Array()
      this.emailMother  = new Array()
      this.docMother    = new Array()
      this.address      = new Array()
      this.phone1       = new Array()
      this.phone2       = new Array()
      this.phone3       = new Array()
      this.city         = new Array()
      this.state        = new Array()
      this.zip          = new Array()
      this.birthMother  = new Array()  
      this.clientID     = new Array()
      this.cpfFather    = new Array()
      this.cpfMother    = new Array()    
      this.docChild     = new Array()
      this.cpfChild     = new Array()
      this.interleavedID = new Array()
      this.bioArchiveID = new Array()
      
      while(!clientData.EOF())
      {
         this.name.push(clientData.getValue("name"))
         this.sex.push(parseInt(clientData.getValue("sex")))
         this.nameFather.push(clientData.getValue("nameFather"))
         this.emailFather.push(clientData.getValue("emailFather"))
         this.docFather.push(clientData.getValue("docFather"))
         this.nameMother.push(clientData.getValue("nameMother"))
         this.emailMother.push(clientData.getValue("emailMother"))
         this.docMother.push(clientData.getValue("docMother"))
         this.address.push(clientData.getValue("address"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.city.push(clientData.getValue("city"))
         this.state.push(clientData.getValue("state"))
         this.zip.push(clientData.getValue("zip"))
         this.birthMother.push(clientData.getValue("birthMother"))
         this.clientID.push(clientData.getValue("clientID"))
         this.cpfFather.push(clientData.getValue("cpfFather"))
         this.cpfMother.push(clientData.getValue("cpfMother"))
         this.docChild.push(clientData.getValue("docChild"))
         this.cpfChild.push(clientData.getValue("cpfChild"))
         this.interleavedID.push(clientData.getValue("interleavedID"))
         this.bioArchiveID.push(clientData.getValue("bioArchiveID"))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum Cliente Encontrado!"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }
   
   return tempCounter
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null   
}

function _getClientByDocs()
{
   //definindo os valores dos campos que vierem a uma hash que sera lida pelo statement para montar a query
   hashValues = new Array()
   
   rg     = getRequestParameterAsString("rg")
   cpf    = getRequestParameterAsString("cpf")
   docsBy = getRequestParameterAsInt("by")
   
   docsStringBy = ""
   switch(parseInt(docsBy))
   {
      case 1:
         docsStringBy = "Child"
      break
      case 2:
         docsStringBy = "Mother"
      break
      case 3:
         docsStringBy = "Father"
      break
   }
   
   if(rg != "")
   {
      hashValues.push(new Array("=",rg,"doc"+docsStringBy,"AND"))
   }
   
   if(cpf != "")
   {
      hashValues.push(new Array("=",cpf,"cpf"+docsStringBy,"AND"))
   }
   
   
   cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery  = new queryStatement(cfgQuery.getKeyValue("SELECT_CLIENT_BY_DOCS"))
     
   clientQuery.setDynamicQuery(1,hashValues)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   tempCounter = 0
   
   if(!clientData.EOF())
   {
      this.name         = new Array()
      this.sex          = new Array()
      this.nameFather   = new Array()
      this.emailFather  = new Array()
      this.docFather    = new Array()
      this.nameMother   = new Array()
      this.emailMother  = new Array()
      this.docMother    = new Array()
      this.address      = new Array()
      this.phone1       = new Array()
      this.phone2       = new Array()
      this.phone3       = new Array()
      this.city         = new Array()
      this.state        = new Array()
      this.zip          = new Array()
      this.birthMother  = new Array()  
      this.clientID     = new Array()
      this.cpfFather    = new Array()
      this.cpfMother    = new Array()    
      this.docChild     = new Array()
      this.cpfChild     = new Array()
      this.interleavedID = new Array()
      this.bioArchiveID  = new Array()
      
      while(!clientData.EOF())
      {
         this.name.push(clientData.getValue("name"))
         this.sex.push(parseInt(clientData.getValue("sex")))
         this.nameFather.push(clientData.getValue("nameFather"))
         this.emailFather.push(clientData.getValue("emailFather"))
         this.docFather.push(clientData.getValue("docFather"))
         this.nameMother.push(clientData.getValue("nameMother"))
         this.emailMother.push(clientData.getValue("emailMother"))
         this.docMother.push(clientData.getValue("docMother"))
         this.address.push(clientData.getValue("address"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.city.push(clientData.getValue("city"))
         this.state.push(clientData.getValue("state"))
         this.zip.push(clientData.getValue("zip"))
         this.birthMother.push(clientData.getValue("birthMother"))
         this.clientID.push(clientData.getValue("clientID"))
         this.cpfFather.push(clientData.getValue("cpfFather"))
         this.cpfMother.push(clientData.getValue("cpfMother"))
         this.docChild.push(clientData.getValue("docChild"))
         this.cpfChild.push(clientData.getValue("cpfChild"))
         this.interleavedID.push(clientData.getValue("interleavedID"))
         this.bioArchiveID.push(clientData.getValue("bioArchiveID"))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum Cliente Encontrado!"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }
   
   return tempCounter
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null 
}


function _getSexAsString(product)
{
   switch(product)
   {
      case 1:
      return "Masculino"
      break
      case 2:
      return "Feminino"
      break
   }
}

function _insertInteracao()
{  
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_INTERACAO_CLIENT"))   
   
   clientID     = getRequestParameterAsInt("clientID")
   horaContato    = getRequestParameterAsString("horaContato")
   minutoContato  = getRequestParameterAsString("minutoContato")
   horarioContato = horaContato + ":" + minutoContato
   dataContato    = strDateToMySQL(getRequestParameterAsString("dataContato")) + " "+ horarioContato + ":00"
   contatoDesc    = getRequestParameterAsString("contatoDesc")

   clientQuery.setStr(1,dataContato)
   clientQuery.setStr(2,contatoDesc)
   clientQuery.setInt(3,clientID)
   
   Session("clientID") = clientID
   
   taskData = new insertionDB()
   taskData.execute(clientQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_INSERT_INTERACAO_CLIENT,clientID)
      
      Session("successMessage") = "Interação registrada com sucesso!"
      Response.Redirect("/extranet/clientInteracoesList.asp?id=" + clientID);
   }
   else
   {
      errMessage = "Erro ao tentar inserir a interação."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+clientQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }
}

function _updateInteracao()
{
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_INTERACAO_CLIENT"))   
   
   interacaoID    = getRequestParameterAsInt("interacaoID")
   clientID       = getRequestParameterAsInt("clientID")   
   horaContato    = getRequestParameterAsString("horaContato")
   minutoContato  = getRequestParameterAsString("minutoContato")
   horarioContato = horaContato + ":" + minutoContato
   dataContato    = strDateToMySQL(getRequestParameterAsString("dataContato")) + " "+ horarioContato + ":00"
   contatoDesc    = getRequestParameterAsString("contatoDesc")

   clientQuery.setStr(1,dataContato)
   clientQuery.setStr(2,contatoDesc)
   clientQuery.setInt(3,interacaoID)
   
   taskData = new updateDB()
   taskData.execute(clientQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_UPDATE_INTERACAO_CLIENT,interacaoID)
      
      Session("successMessage") = "Interação atualizada com sucesso!"
      Response.Redirect("/extranet/clientInteracoesList.asp?id=" + clientID);
   }
   else
   {
      errMessage = "Erro ao tentar atualizar a interação."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+clientQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }
}

function _getAllInteracoes()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_INTERACAO_CLIENT"))
   
   clientID     = getRequestParameterAsInt("id")
   clientQuery.setInt(1,clientID)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())
   
   tempCounter = 0
   if(!clientData.EOF())
   {
      this.interacaoID      = new Array()
      this.dataInteracao    = new Array()
      this.descricaoContato = new Array()  
      this.horaInteracao    = new Array()
      this.minutoInteracao  = new Array()
      
      while(!clientData.EOF())
      {      
         this.interacaoID.push(clientData.getValue("interacaoID"))
         this.dataInteracao.push(clientData.getValue("dataInteracao"))
         this.descricaoContato.push(clientData.getValue("descricaoContato"))

         arrDateInteracao = splitDateValues(clientData.getValue("dataInteracao"))
         this.horaInteracao.push(arrDateInteracao["hour"])
         this.minutoInteracao.push(arrDateInteracao["minute"]) 
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhuma Interação Encontrada!"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }
   
   return tempCounter
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null   
}

function _getInteracao()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_INTERACAO_CLIENT"))
   
   clientQuery.setInt(1,this.interacaoID)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   if(!clientData.EOF())
   {
      this.dataInteracao    = clientData.getValue("dataInteracao")
      this.descricaoContato = clientData.getValue("descricaoContato")
      this.clientID         = clientData.getValue("clientID")
      this.name             = clientData.getValue("name")

      arrDateInteracao      = splitDateValues(this.dataInteracao)
      this.horaInteracao    = arrDateInteracao["hour"]
      this.minutoInteracao  = arrDateInteracao["minute"]  

      Session("clientID") = this.clientID       
   }
   else
   {
      errMessage = "Nenhuma Interação Encontrada!"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null  
}

function _removeInteracao()
{
   interacaoID = getRequestParameterAsInt("id")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_ISDELETED"))   
   
   updateQuery.setTable(1,"interacao_client")
   updateQuery.setColumm(2,"interacaoID")
   updateQuery.setInt(3,interacaoID)
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_INTERACAO_CLIENT,interacaoID)
      
      Session("successMessage") = "Interação removida com sucesso!"
      Response.Redirect("/extranet/success.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover a interação"
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }   
}

function _removeClient()
{
   clientID = getRequestParameterAsInt("id")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_ISDELETED"))   
   
   updateQuery.setTable(1,"CLIENT")
   updateQuery.setColumm(2,"clientID")
   updateQuery.setInt(3,clientID)
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_CLIENT_DATA,clientID)
      
      Session("successMessage") = "Cliente removido(a) com sucesso!"
      Response.Redirect("/extranet/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover o/a Cliente"
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }   
}

%>
