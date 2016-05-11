<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include file="client.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/login.asp" -->
<%
function obstetra()
{
   //propriedades
   this.obstetraID    = null
   this.interacaoID   = null
   this.name          = null
   this.email         = null
   this.crm           = null
   this.state         = null
   this.city          = null
   this.secondAddress = null     
   this.secondState   = null
   this.secondCity    = null   
   this.secondCep     = null
   this.phone1        = null
   this.phone2        = null
   this.phone3        = null   
   this.address       = null
   this.cep           = null
   this.dataInteracao = null
   this.horaInteracao    = null
   this.minutoInteracao  = null
   this.descricaoContato = null
   this.cpf           = null
   this.contaCorrente = null
   this.razaoSocial   = null
   this.agencia       = null
   this.banco         = null
   this.type          = null
   this.crm = null
   this.secretary = null
   this.parceiro = null
   this.temDisplay = null   
   this.mesPagamento = null
   this.anoPagamento = null
   this.paidValue = null   
   this.extranetUsername = null
   this.extranetPassword = null
   
 

   //metodos de captura dos dados
   this.getAll              = _getAllObstetras
   this.getAllByFilter      = _getAllObstetrasByFilter
   this.getAllExtranetEnabled = _getAllExtranetEnabled   
   this.getName             = _getObstetraName
   this.getObstetraID       = _getObstetraID
   this.getInteracaoID      = _getInteracaoID   
   this.getEmail            = _getObstetraEmail
   this.getCrm              = _getCrm          
   this.getSecondState      = _getSecondState        
   this.getSecondCity       = _getSecondCity 
   this.getState            = _getState        
   this.getCity             = _getCity         
   this.getPhone1           = _getPhone1       
   this.getPhone2           = _getPhone2   
   this.getPhone3           = _getPhone3      
   this.getAddress          = _getAddress  
   this.getSecondAddress    = _getSecondAddress
   this.getCep              = _getCep   
   this.getSecondCep        = _getSecondCep      
   this.getDataInteracao    = _getDataInteracao
   this.getHoraInteracao    = _getHoraInteracao
   this.getMinutoInteracao  = _getMinutoInteracao
   this.getDescricaoContato = _getDescricaoContato
   this.getCpf = _getCpf
   this.getContaCorrente = _getContaCorrente
   this.getRazaoSocial   = _getRazaoSocial
   this.getAgencia       = _getAgencia
   this.getBanco         = _getBanco
   this.getType          = _getType
   this.getCRM           = _getCRM
   this.getSecretary     = _getSecretary
   this.getNumeroDeColetas     = _getNumeroDeColetas
   this.getNumeroDeColetasByID = _getNumeroDeColetasByID
   this.getObstetra            = _getObstetra
   this.getObstetraFromID      = _getObstetraFromID
   this.getAllPayments = _getAllPayments
   this.getPayment    = _getPayment
   this.getParceiro = _getParceiro
   this.getTemDisplay = _getTemDisplay   

   this.getClientID = _getClientID
   this.getDatePayment = _getDatePayment
   this.getPaymentAmount = _getPaymentAmount
   this.getPaymentID = _getPaymentID
   
   this.getMesPagamento = _getMesPagamento
   this.getAnoPagamento = _getAnoPagamento
   this.getPaidValue = _getPaidValue   
   
   this.getExtranetUsername = _getExtranetUsername
   this.getExtranetPassword = _getExtranetPassword


   //metodos de tratamentos de dados
   this.updateObstetraData     = _updateObstetraData
   this.insertObstetraData     = _insertObstetraData
   this.removeObstetra     = _removeObstetra
   this.insertInteracao    = _insertInteracao
   this.updateInteracao    = _updateInteracao
   this.getInteracao       = _getInteracao
   this.getInteracaoFromID = _getInteracaoFromID
   this.getAllInteracoes   = _getAllInteracoes
   this.removeInteracao    = _removeInteracao
   this.insertPayment = _insertPayment
   this.updatePayment = _updatePayment
   this.removePayment = _removePayment
   this.getPaymentFromID = _getPaymentFromID
   this.getSnapshotPayments = _getSnapshotPayments


function _getObstetraID()
{
   return this.obstetraID
}

function _getObstetraName()
{
   return this.name
}

function _getObstetraEmail()
{
   return this.email
}

function _getCrm()
{
	return this.crm 
}

function _getState()
{
	return this.state
}

function _getSecondCity()
{
	return this.secondCity
}

function _getSecondState()
{
	return this.secondState
}

function _getCity()
{
	return this.city
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

function _getAddress()
{
	return this.address
}

function _getSecondAddress()
{
	return this.secondAddress
}

function _getCep()
{
	return this.cep 
}

function _getSecondCep()
{
   return this.secondCep
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

function _getCpf()
{
	return this.cpf
}

function _getContaCorrente()
{
	return this.contaCorrente
}

function _getRazaoSocial()
{
	return this.razaoSocial
}

function _getAgencia()
{
	return this.agencia
}

function _getBanco()
{
	return this.banco
}

function _getType()
{
	return this.type
}

function _getCRM()
{
   return this.crm
}

function _getSecretary()
{
   return this.secretary
}

function _getClientID()
{
   return this.clientID
}

function _getDatePayment()
{
   return this.datePayment
}

function _getPaymentAmount()
{
   return this.paymentAmount
}

function _getPaymentID()
{
   return this.paymentID
}

function _getParceiro()
{
	return this.parceiro
}

function _getTemDisplay()
{
	return this.temDisplay
}

function _getMesPagamento()
{
	return this.mesPagamento
}

function _getAnoPagamento()
{
	return this.anoPagamento
}

function _getPaidValue()
{
	return this.paidValue
}

function _getExtranetUsername()
{
   return this.extranetUsername
}

function _getExtranetPassword()
{
   return this.extranetPassword
}

function _getObstetraFromID(oi)
{
   this.obstetraID = oi
   this.getObstetra()
}

function _getInteracaoFromID(ii)
{
   this.interacaoID = ii
   this.getInteracao()
}

function _getPaymentFromID(pi)
{
   this.paymentID = pi
   this.getPayment()
}

function _updateObstetraData(arrOfData,pos)
{
  
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_OBSTETRA_DATA"))

   name             = (arrOfData[1][pos] != "NULL")?arrOfData[1][pos]:""
   crm              = (arrOfData[2][pos] != "NULL")?arrOfData[2][pos]:""
   email            = (arrOfData[3][pos] != "NULL")?arrOfData[3][pos]:""
   address          = (arrOfData[4][pos] != "NULL")?arrOfData[4][pos]:""
   state            = (arrOfData[5][pos] != "NULL")?arrOfData[5][pos]:""
   city             = (arrOfData[6][pos] != "NULL")?arrOfData[6][pos]:""
   cep              = (arrOfData[7][pos] != "NULL")?arrOfData[7][pos]:""
   cpf              = (arrOfData[8][pos] != "NULL")?arrOfData[8][pos]:""
   razaoSocial      = (arrOfData[9][pos] != "NULL")?arrOfData[9][pos]:""
   secretary        = (arrOfData[10][pos] != "NULL")?arrOfData[10][pos]:""
   secondCep        = (arrOfData[11][pos] != "NULL")?arrOfData[11][pos]:""
   phone1           = (arrOfData[12][pos] != "NULL")?arrOfData[12][pos]:""
   phone2           = (arrOfData[13][pos] != "NULL")?arrOfData[13][pos]:""
   phone3           = (arrOfData[14][pos] != "NULL")?arrOfData[14][pos]:""
   secondAddress    = (arrOfData[15][pos] != "NULL")?arrOfData[15][pos]:""
   secondState      = (arrOfData[16][pos] != "NULL")?arrOfData[16][pos]:""
   secondCity       = (arrOfData[17][pos] != "NULL")?arrOfData[17][pos]:""
   banco            = (arrOfData[18][pos] != "NULL")?arrOfData[18][pos]:""
   agencia          = (arrOfData[19][pos] != "NULL")?arrOfData[19][pos]:""
   contaCorrente    = (arrOfData[20][pos] != "NULL")?arrOfData[20][pos]:""
   parceiro         = (arrOfData[21][pos] != "NULL")?arrOfData[21][pos]:"0"
   type             = (arrOfData[22][pos] != "NULL")?arrOfData[22][pos]:"0"
   temDisplay       = (arrOfData[23][pos] != "NULL")?arrOfData[23][pos]:"0"
   obstetraID       = (arrOfData[0][pos]  != "NULL")?arrOfData[0][pos]:""     
   extranetUserName = (arrOfData[24][pos]  != "NULL")?arrOfData[24][pos]:""
   extranetPassword = (arrOfData[25][pos]  != "NULL")?arrOfData[25][pos]:""
   
   //definindo os valores dos campos na query
   clientQuery.setStr(1,name)
   clientQuery.setStr(2,crm)
   clientQuery.setStr(3,email)
   clientQuery.setStr(4,address)
   clientQuery.setStr(5,state)
   clientQuery.setStr(6,city)
   clientQuery.setStr(7,cep)
   clientQuery.setStr(8,cpf)
   clientQuery.setStr(9,razaoSocial)
   clientQuery.setStr(10,secretary)
   clientQuery.setStr(11,secondCep)
   clientQuery.setStr(12,phone1)
   clientQuery.setStr(13,phone2)
   clientQuery.setStr(14,phone3)
   clientQuery.setStr(15,secondAddress)
   clientQuery.setStr(16,secondState)
   clientQuery.setStr(17,secondCity)
   clientQuery.setStr(18,banco)
   clientQuery.setStr(19,agencia) 
   clientQuery.setStr(20,contaCorrente)  
   clientQuery.setInt(21,parceiro)
   clientQuery.setInt(22,type)
   clientQuery.setInt(23,temDisplay)
   clientQuery.setStr(24,extranetUserName)
   clientQuery.setStr(25,extranetPassword)
   clientQuery.setInt(26,obstetraID)
   
   obstetraData   = new updateDB()
   clientResult = obstetraData.execute(clientQuery.toString())   
   
   if(obstetraData.getErrorMessage() != null)
   {
      errMessage = "Erro Inesperado\n<!--DB Error:" +obstetraData.getErrorMessage()+  clientQuery.toString() + "-->"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");   
   }
   
   clientQuery = null

}

function _insertObstetraData(arrOfData,pos)
{
  
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_OBSTETRA_DATA"))

   name             = (arrOfData[1][pos] != "NULL")?arrOfData[1][pos]:""
   crm              = (arrOfData[2][pos] != "NULL")?arrOfData[2][pos]:""
   email            = (arrOfData[3][pos] != "NULL")?arrOfData[3][pos]:""
   address          = (arrOfData[4][pos] != "NULL")?arrOfData[4][pos]:""
   state            = (arrOfData[5][pos] != "NULL")?arrOfData[5][pos]:""
   city             = (arrOfData[6][pos] != "NULL")?arrOfData[6][pos]:""
   cep              = (arrOfData[7][pos] != "NULL")?arrOfData[7][pos]:""
   cpf              = (arrOfData[8][pos] != "NULL")?arrOfData[8][pos]:""
   razaoSocial      = (arrOfData[9][pos] != "NULL")?arrOfData[9][pos]:""
   secretary        = (arrOfData[10][pos] != "NULL")?arrOfData[10][pos]:""
   secondCep        = (arrOfData[11][pos] != "NULL")?arrOfData[11][pos]:""
   phone1           = (arrOfData[12][pos] != "NULL")?arrOfData[12][pos]:""
   phone2           = (arrOfData[13][pos] != "NULL")?arrOfData[13][pos]:""
   phone3           = (arrOfData[14][pos] != "NULL")?arrOfData[14][pos]:""
   secondAddress    = (arrOfData[15][pos] != "NULL")?arrOfData[15][pos]:""
   secondState      = (arrOfData[16][pos] != "NULL")?arrOfData[16][pos]:""
   secondCity       = (arrOfData[17][pos] != "NULL")?arrOfData[17][pos]:""
   banco            = (arrOfData[18][pos] != "NULL")?arrOfData[18][pos]:""
   agencia          = (arrOfData[19][pos] != "NULL")?arrOfData[19][pos]:""
   contaCorrente    = (arrOfData[20][pos] != "NULL")?arrOfData[20][pos]:""
   parceiro         = (arrOfData[21][pos] != "NULL")?arrOfData[21][pos]:"0"
   type             = (arrOfData[22][pos] != "NULL")?arrOfData[22][pos]:"0"
   temDisplay       = (arrOfData[23][pos] != "NULL")?arrOfData[23][pos]:"0"
   obstetraID       = (arrOfData[0][pos]  != "NULL")?arrOfData[0][pos]:""     
   extranetUserName = (arrOfData[24][pos]  != "NULL")?arrOfData[24][pos]:""
   extranetPassword = (arrOfData[25][pos]  != "NULL")?arrOfData[25][pos]:""
   
   //definindo os valores dos campos na query
   clientQuery.setStr(1,name)
   clientQuery.setStr(2,crm)
   clientQuery.setStr(3,email)
   clientQuery.setStr(4,address)
   clientQuery.setStr(5,state)
   clientQuery.setStr(6,city)
   clientQuery.setStr(7,cep)
   clientQuery.setStr(8,cpf)
   clientQuery.setStr(9,razaoSocial)
   clientQuery.setStr(10,secretary)
   clientQuery.setStr(11,secondCep)
   clientQuery.setStr(12,phone1)
   clientQuery.setStr(13,phone2)
   clientQuery.setStr(14,phone3)
   clientQuery.setStr(15,secondAddress)
   clientQuery.setStr(16,secondState)
   clientQuery.setStr(17,secondCity)
   clientQuery.setStr(18,banco)
   clientQuery.setStr(19,agencia) 
   clientQuery.setStr(20,contaCorrente)  
   clientQuery.setInt(21,parceiro)
   clientQuery.setInt(22,type)
   clientQuery.setInt(23,temDisplay)
   clientQuery.setStr(24,extranetUserName)
   clientQuery.setStr(25,extranetPassword)
   clientQuery.setInt(26,obstetraID)
   
   obstetraData   = new updateDB()
   clientResult = obstetraData.execute(clientQuery.toString())   
   
   if(obstetraData.getErrorMessage() != null)
   {
      errMessage = "Erro Inesperado\n<!--DB Error:" +obstetraData.getErrorMessage()+  clientQuery.toString() + "-->"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");   
   }
   
   clientQuery = null

}


function _getObstetra()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_OBSTETRA_DATA"))
   
   clientQuery.setInt(1,this.obstetraID)
   
   clientDataObs   = new searchDB()
   clientResult = clientDataObs.execute(clientQuery.toString())

   if(!clientDataObs.EOF())
   {
      this.name    = clientDataObs.getValue("name")
      this.email   = clientDataObs.getValue("email")
      this.crm     = clientDataObs.getValue("crm")
      this.state   = clientDataObs.getValue("state")
      this.city    = clientDataObs.getValue("city")
      this.phone1  = clientDataObs.getValue("phone1")
      this.phone2  = clientDataObs.getValue("phone2")
      this.phone3  = clientDataObs.getValue("phone3")
      this.address = clientDataObs.getValue("address")
      this.cep     = clientDataObs.getValue("cep")
      this.cpf           = clientDataObs.getValue("cpf")
      this.contaCorrente = clientDataObs.getValue("contaCorrente")
      this.razaoSocial   = clientDataObs.getValue("razaoSocial")
      this.agencia       = clientDataObs.getValue("agencia")
      this.banco         = clientDataObs.getValue("banco")      
      this.secondAddress = clientDataObs.getValue("secondAddress")       
      this.secondState   = clientDataObs.getValue("secondState")  
      this.secondCity    = clientDataObs.getValue("secondCity")     
      this.secondCep     = clientDataObs.getValue("secondCep")
      this.type          = clientDataObs.getValue("type")
      this.secretary     = clientDataObs.getValue("secretary")
      this.parceiro      = clientDataObs.getValue("parceiro")
      this.temDisplay    = clientDataObs.getValue("temDisplay")
      this.extranetUsername = clientDataObs.getValue("extranetUsername")
      this.extranetPassword = clientDataObs.getValue("extranetPassword")

      //cfgQuery = null
      //clientQuery = null
      //clientDataObs = null      
      
      return true
   }
   else
   {
      //cfgQuery = null
      //clientQuery = null
      //clientDataObs = null   
      return false      
   }
}

function _getAllExtranetEnabled()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_OBSTETRA_FOR_EXTRANET_EXPORT"))
    
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())
   
   tempCounter = 0
   if(!clientData.EOF())
   {
      this.obstetraID = new Array()
      this.name       = new Array()
      this.email      = new Array()
      this.crm        = new Array()
      this.state      = new Array()
      this.city       = new Array()
      this.phone1     = new Array()
      this.phone2     = new Array()
      this.phone3     = new Array()
      this.address    = new Array()
      this.cep        = new Array()
      this.cpf           = new Array()
      this.contaCorrente = new Array()
      this.razaoSocial   = new Array()
      this.agencia       = new Array()
      this.banco         = new Array()   
      this.secondAddress = new Array()      
      this.secondState   = new Array() 
      this.secondCity    = new Array()     
      this.secondCep     = new Array()
      this.type          = new Array()
      this.secretary     = new Array()
      this.parceiro      = new Array()
      this.temDisplay    = new Array()  
      this.extranetUsername = new Array()
      this.extranetPassword = new Array()
      
      while(!clientData.EOF())
      {      
         this.obstetraID.push(clientData.getValue("obstetraID"))
         this.name.push(clientData.getValue("name"))
         this.email.push(clientData.getValue("email"))
         this.crm.push(clientData.getValue("crm"))
         this.state.push(clientData.getValue("state"))
         this.city.push(clientData.getValue("city"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.address.push(clientData.getValue("address"))
         this.cep.push(clientData.getValue("cep"))
         this.cpf.push(clientData.getValue("cpf"))
         this.contaCorrente.push(clientData.getValue("contaCorrente"))
         this.razaoSocial.push(clientData.getValue("razaoSocial"))
         this.agencia.push(clientData.getValue("agencia"))
         this.banco.push(clientData.getValue("banco"))
         this.secondAddress.push(clientData.getValue("secondAddress"))   
         this.secondState.push(clientData.getValue("secondState"))  
         this.secondCity.push(clientData.getValue("secondCity"))     
         this.secondCep.push(clientData.getValue("secondCep"))
         this.type.push(clientData.getValue("type"))
         this.secretary.push(clientData.getValue("secretary"))
         this.parceiro.push(clientData.getValue("parceiro"))
         this.temDisplay.push(clientData.getValue("temDisplay"))        
         this.extranetUsername.push(clientData.getValue("extranetUsername"))
         this.extranetPassword.push(clientData.getValue("extranetPassword"))        
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum(a) Médico(a) Encontrado(a)!"
      Session("errorMessage") = errMessage
      Response.Redirect("/lifeDB/error.asp");       
   }
   
   return tempCounter  
}


function _getAllObstetras()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_OBSTETRA"))
    
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())
   
   tempCounter = 0
   if(!clientData.EOF())
   {
      this.obstetraID = new Array()
      this.name       = new Array()
      this.email      = new Array()
      this.crm        = new Array()
      this.state      = new Array()
      this.city       = new Array()
      this.phone1     = new Array()
      this.phone2     = new Array()
      this.phone3     = new Array()
      this.address    = new Array()
      this.cep        = new Array()
      this.cpf           = new Array()
      this.contaCorrente = new Array()
      this.razaoSocial   = new Array()
      this.agencia       = new Array()
      this.banco         = new Array()   
      this.secondAddress = new Array()      
      this.secondState   = new Array() 
      this.secondCity    = new Array()     
      this.secondCep     = new Array()
      this.type          = new Array()
      this.secretary     = new Array()
      this.parceiro      = new Array()
      this.temDisplay    = new Array()  
      this.extranetUsername = new Array()
      this.extranetPassword = new Array()
      
      while(!clientData.EOF())
      {      
         this.obstetraID.push(clientData.getValue("obstetraID"))
         this.name.push(clientData.getValue("name"))
         this.email.push(clientData.getValue("email"))
         this.crm.push(clientData.getValue("crm"))
         this.state.push(clientData.getValue("state"))
         this.city.push(clientData.getValue("city"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.address.push(clientData.getValue("address"))
         this.cep.push(clientData.getValue("cep"))
         this.cpf.push(clientData.getValue("cpf"))
         this.contaCorrente.push(clientData.getValue("contaCorrente"))
         this.razaoSocial.push(clientData.getValue("razaoSocial"))
         this.agencia.push(clientData.getValue("agencia"))
         this.banco.push(clientData.getValue("banco"))
         this.secondAddress.push(clientData.getValue("secondAddress"))   
         this.secondState.push(clientData.getValue("secondState"))  
         this.secondCity.push(clientData.getValue("secondCity"))     
         this.secondCep.push(clientData.getValue("secondCep"))
         this.type.push(clientData.getValue("type"))
         this.secretary.push(clientData.getValue("secretary"))
         this.parceiro.push(clientData.getValue("parceiro"))
         this.temDisplay.push(clientData.getValue("temDisplay"))        
         this.extranetUsername.push(clientData.getValue("extranetUsername"))
         this.extranetPassword.push(clientData.getValue("extranetPassword"))        
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum(a) Médico(a) Encontrado(a)!"
      Session("errorMessage") = errMessage
      Response.Redirect("/lifeDB/error.asp");       
   }
   
   return tempCounter  
}


function _getAllObstetrasByFilter()
{
   name = getRequestParameterAsString("name")
   city  = getRequestParameterAsString("city")
   state = getRequestParameterAsString("state")
   parceiro = getRequestParameterAsInt("parceiro")
   temDisplay = getRequestParameterAsInt("temDisplay")

   otherFilterItems = ""
   
   if(state != "")
   {
      otherFilterItems += " AND state = '" + state + "' "
   }

   if(city != "")
   {
      otherFilterItems += " AND city = '" + city + "' "
   }
   
   if(parceiro != ERROR)
   {
      otherFilterItems += " AND parceiro = 1 "
   }   
 
   if(temDisplay != ERROR)
   {
      otherFilterItems += " AND temDisplay = 1 "
   } 
   
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   searchQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_OBSTETRA_BY_FILTER"))
   
   searchQuery.setGenericValue(1,name)
   searchQuery.setGenericValue(2,otherFilterItems)
   
   clientData   = new searchDB()
   result       = clientData.execute(searchQuery.toString())
   
   tempCounter = 0
   if(!clientData.EOF())
   {
      this.obstetraID = new Array()
      this.name       = new Array()
      this.email      = new Array()
      this.crm        = new Array()
      this.state      = new Array()
      this.city       = new Array()
      this.phone1     = new Array()
      this.phone2     = new Array()
      this.phone3     = new Array()
      this.address    = new Array()
      this.cep        = new Array()
      this.cpf           = new Array()
      this.contaCorrente = new Array()
      this.razaoSocial   = new Array()
      this.agencia       = new Array()
      this.banco         = new Array()   
      this.secondAddress = new Array()      
      this.secondState   = new Array() 
      this.secondCity    = new Array()     
      this.secondCep     = new Array()
      this.type          = new Array()
      this.secretary     = new Array()
      this.parceiro      = new Array()
      this.temDisplay    = new Array()   
      this.extranetUsername = new Array()
      this.extranetPassword = new Array()
      
      while(!clientData.EOF())
      {      
         this.obstetraID.push(clientData.getValue("obstetraID"))
         this.name.push(clientData.getValue("name"))
         this.email.push(clientData.getValue("email"))
         this.crm.push(clientData.getValue("crm"))
         this.state.push(clientData.getValue("state"))
         this.city.push(clientData.getValue("city"))
         this.phone1.push(clientData.getValue("phone1"))
         this.phone2.push(clientData.getValue("phone2"))
         this.phone3.push(clientData.getValue("phone3"))
         this.address.push(clientData.getValue("address"))
         this.cep.push(clientData.getValue("cep"))
         this.cpf.push(clientData.getValue("cpf"))
         this.contaCorrente.push(clientData.getValue("contaCorrente"))
         this.razaoSocial.push(clientData.getValue("razaoSocial"))
         this.agencia.push(clientData.getValue("agencia"))
         this.banco.push(clientData.getValue("banco"))
         this.secondAddress.push(clientData.getValue("secondAddress"))   
         this.secondState.push(clientData.getValue("secondState"))  
         this.secondCity.push(clientData.getValue("secondCity"))     
         this.secondCep.push(clientData.getValue("secondCep"))
         this.type.push(clientData.getValue("type"))
         this.secretary.push(clientData.getValue("secretary"))
         this.parceiro.push(clientData.getValue("parceiro"))
         this.temDisplay.push(clientData.getValue("temDisplay"))
         this.extranetUsername.push(clientData.getValue("extranetUsername"))
         this.extranetPassword.push(clientData.getValue("extranetPassword"))           
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhum(a) Médico(a) Encontrado(a) para esses critérios de busca."
      Session("errorMessage") = errMessage     
   }
   
   return tempCounter  
}

function _removeObstetra()
{
   obstetraID = getRequestParameterAsInt("id")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_ISDELETED"))   
   
   updateQuery.setTable(1,"obstetra")
   updateQuery.setColumm(2,"obstetraID")
   updateQuery.setInt(3,obstetraID)
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_OBSTETRA,obstetraID)
      
      Session("successMessage") = "Médico(a) removido(a) com sucesso!"
      Response.Redirect("/lifeDB/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover o/a Médico(a)"
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }   
}


function _updatePayment()
{  
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   obstetraQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_PAYMENT_OBSTETRA"))   
   
   paymentID      = getRequestParameterAsInt("paymentID")
   obstetraID     = getRequestParameterAsInt("obstetraID")
   clientID       = getRequestParameterAsInt("clientID")
   horarioContato = "00:00"
   datePayment    = strDateToMySQL(getRequestParameterAsString("datePayment")) + " "+ horarioContato + ":00"
   paymentAmount  = getRequestParameterAsDouble("paymentAmount")

   obstetraQuery.setInt(1,clientID)
   obstetraQuery.setStr(2,datePayment)
   obstetraQuery.setDouble(3,paymentAmount)
   obstetraQuery.setInt(4,paymentID)
   
   taskData = new insertionDB()
   taskData.execute(obstetraQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_UPDATE_PAYMENT_OBSTETRA,paymentID)
      
      Session("successMessage") = "Pagamento atualizado com sucesso!"
      Response.Redirect("/lifeDB/obstetraPaymentsList.asp?id="+obstetraID);
   }
   else
   {
      errMessage = "Erro ao tentar editar as informações de pagamento."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+obstetraQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }
}

function _insertPayment()
{  
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   obstetraQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_PAYMENT_OBSTETRA"))   
   
   obstetraID     = getRequestParameterAsInt("obstetraID")
   clientID       = getRequestParameterAsInt("clientID")
   horarioContato = "00:00"
   datePayment    = strDateToMySQL(getRequestParameterAsString("datePayment")) + " "+ horarioContato + ":00"
   paymentAmount  = getRequestParameterAsDouble("paymentAmount")

   obstetraQuery.setInt(1,obstetraID)
   obstetraQuery.setInt(2,clientID)
   obstetraQuery.setStr(3,datePayment)
   obstetraQuery.setDouble(4,paymentAmount)
   
   taskData = new insertionDB()
   taskData.execute(obstetraQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_INSERT_PAYMENT_OBSTETRA,obstetraID)
      
      Session("successMessage") = "Pagamento registrado com sucesso!"
      Response.Redirect("/lifeDB/obstetraPaymentsList.asp?id="+obstetraID);
   }
   else
   {
      errMessage = "Erro ao tentar inserir o pagamento."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+obstetraQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }
}

function _removePayment()
{
   paymentID = getRequestParameterAsInt("id")
   obstetraID = getRequestParameterAsInt("obstetraID")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_ISDELETED"))   
   
   updateQuery.setTable(1,"obstetra_payments")
   updateQuery.setColumm(2,"paymentID")
   updateQuery.setInt(3,paymentID)
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_PAYMENT_OBSTETRA,paymentID)
      
      Session("successMessage") = "Informação de Pagamento removida com sucesso!<br><br><a href=obstetraPaymentsList.asp?id="+obstetraID+">Voltar para lista de pagamentos.</a>"
      Response.Redirect("/lifeDB/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover a informação de pagamento."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }   
}


function _getAllPayments(obstetraID)
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_PAYMENT_OBSTETRA"))
   
   clientQuery.setInt(1,obstetraID)
   
   var clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())
   
   tempCounter = 0
   if(!clientData.EOF())
   {
      this.paymentID   = new Array()
      this.datePayment = new Array()
      this.paymentAmount = new Array()  
      this.clientID  = new Array()
      
      while(!clientData.EOF())
      {      
         this.paymentID.push(clientData.getValue("paymentID"))
         this.datePayment.push(clientData.getValue("datePayment"))
         this.paymentAmount.push(clientData.getValue("paymentAmount"))        
         this.clientID.push(clientData.getValue("clientID"))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhuma informação de pagamento encontrada!"
      Session("errorMessage") = errMessage       
   }
   
   return tempCounter  
}

function _getSnapshotPayments(obstetraID)
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_SNAPSHOT_PAYMENT_OBSTETRA"))
   
   clientQuery.setInt(1,obstetraID)
   
   var clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())
   
   var tempCounter = 0
   if(!clientData.EOF())
   {
      this.mesPagamento = new Array()
      this.anoPagamento = new Array()
      this.paidValue = new Array()  
      
      while(!clientData.EOF())
      {      
         this.mesPagamento.push(clientData.getValue("mes"))
         this.anoPagamento.push(clientData.getValue("ano"))
         this.paidValue.push(clientData.getValue("paid"))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Nenhuma informação de pagamento encontrada!"
      Session("errorMessage") = errMessage       
   }
   
   return tempCounter  
}


function _getPayment()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_PAYMENT_OBSTETRA"))
   
   clientQuery.setInt(1,this.paymentID)
   
   var clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   if(!clientData.EOF())
   {      
      this.clientID    = clientData.getValue("clientID")
      this.paymentID   = clientData.getValue("paymentID")
      this.datePayment = clientData.getValue("datePayment")
      this.paymentAmount = clientData.getValue("paymentAmount")  
      this.obstetraID = clientData.getValue("obstetraID")
   }
   else
   {
      errMessage = "Nenhuma informação de pagamento encontrada!"
      Session("errorMessage") = errMessage
      Response.Redirect("/lifeDB/error.asp");       
   }
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null  
}


function _insertInteracao()
{  
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   obstetraQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_INTERACAO_OBSTETRA"))   
   
   obstetraID     = getRequestParameterAsInt("obstetraID")
   horaContato    = getRequestParameterAsString("horaContato")
   minutoContato  = getRequestParameterAsString("minutoContato")
   horarioContato = horaContato + ":" + minutoContato
   dataContato    = strDateToMySQL(getRequestParameterAsString("dataContato")) + " "+ horarioContato + ":00"
   contatoDesc    = getRequestParameterAsString("contatoDesc")

   obstetraQuery.setStr(1,dataContato)
   obstetraQuery.setStr(2,contatoDesc)
   obstetraQuery.setInt(3,obstetraID)
   
   taskData = new insertionDB()
   taskData.execute(obstetraQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_INSERT_INTERACAO_OBSTETRA,obstetraID)
      
      Session("successMessage") = "Interação registrada com sucesso!"
      Response.Redirect("/lifeDB/obstetraInteracoesList.asp?id="+obstetraID);
   }
   else
   {
      errMessage = "Erro ao tentar inserir a interação."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+obstetraQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }
}

function _updateInteracao()
{
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   obstetraQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_INTERACAO_OBSTETRA"))   
   
   interacaoID    = getRequestParameterAsInt("interacaoID")
   obstetraID     = getRequestParameterAsInt("obstetraID")   
   horaContato    = getRequestParameterAsString("horaContato")
   minutoContato  = getRequestParameterAsString("minutoContato")
   horarioContato = horaContato + ":" + minutoContato
   dataContato    = strDateToMySQL(getRequestParameterAsString("dataContato")) + " "+ horarioContato + ":00"
   contatoDesc    = getRequestParameterAsString("contatoDesc")

   obstetraQuery.setStr(1,dataContato)
   obstetraQuery.setStr(2,contatoDesc)
   obstetraQuery.setInt(3,interacaoID)
   
   taskData = new updateDB()
   taskData.execute(obstetraQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_UPDATE_INTERACAO_OBSTETRA,interacaoID)
      
      Session("successMessage") = "Interação atualizada com sucesso!"
      Response.Redirect("/lifeDB/obstetraInteracoesList.asp?id=" + obstetraID);
   }
   else
   {
      errMessage = "Erro ao tentar atualizar a interação."
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+obstetraQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }
}

function _getAllInteracoes()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_ALL_INTERACAO_OBSTETRA"))
   
   obstetraID     = getRequestParameterAsInt("id")
   clientQuery.setInt(1,obstetraID)
   
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
      Response.Redirect("/lifeDB/error.asp");       
   }
   
   return tempCounter  
}

function _getInteracao()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_INTERACAO_OBSTETRA"))
   
   clientQuery.setInt(1,this.interacaoID)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   if(!clientData.EOF())
   {
      this.dataInteracao    = clientData.getValue("dataInteracao")
      this.descricaoContato = clientData.getValue("descricaoContato")
      this.obstetraID       = clientData.getValue("obstetraID")
      this.name             = clientData.getValue("name")

      arrDateInteracao      = splitDateValues(this.dataInteracao)
      this.horaInteracao    = arrDateInteracao["hour"]
      this.minutoInteracao  = arrDateInteracao["minute"]         
   }
   else
   {
      errMessage = "Nenhuma Interação Encontrada!"
      Session("errorMessage") = errMessage
      Response.Redirect("/lifeDB/error.asp");       
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
   
   updateQuery.setTable(1,"interacao_obstetra")
   updateQuery.setColumm(2,"interacaoID")
   updateQuery.setInt(3,interacaoID)
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_INTERACAO_OBSTETRA,interacaoID)
      
      Session("successMessage") = "Interação removida com sucesso!"
      Response.Redirect("/lifeDB/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover a interação"
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/lifeDB/error.asp");   
   }   
}

function _getNumeroDeColetasByID(obstetraID)
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_COLETAS_OBSTETRA"))
   
   clientQuery.setInt(1,obstetraID)
   
   clientDataObs   = new searchDB()
   clientResult = clientDataObs.execute(clientQuery.toString())

   if(!clientDataObs.EOF())
   {
      return clientDataObs.getValue("total")   
   }
   else
   {
      return 0     
   }  
}

function _getNumeroDeColetas()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_COLETAS_OBSTETRA"))
   
   clientQuery.setInt(1,this.obstetraID)
   
   clientDataObs   = new searchDB()
   clientResult = clientDataObs.execute(clientQuery.toString())

   if(!clientDataObs.EOF())
   {
      return clientDataObs.getValue("total")   
   }
   else
   {
      return 0     
   }   
}

function verifyExtranetUsername(username,obstetraID)
{
   var cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   var clientQuery = new queryStatement(cfgQuery.getKeyValue("CHECK_OBSTETRA_EXTRANET_USERNAME"))
   
   clientQuery.setStr(1,username)
   
   var clientData   = new searchDB()
   var clientResult = clientData.execute(clientQuery.toString())
   
   if(!clientData.EOF())
   {
      //verifica se o id de cliente foi passado para evitar que o sistema diga que o o username ja esta definido
      //quando ele ja existe para esse mesmo usuario
      if(obstetraID)
      {
         if(obstetraID == clientData.getValue("obstetraID"))
         {
            return true;
         }
      }
      
      var errMessage = "O Nome de usuario para acesso a extranet que você digitou já esta definido para o obstetra " + clientData.getValue("name")
      errMessage += ". Por favor selecione um outro nome de usuario, por exemplo: '" + username + "_1'"
      
      Session("errorMessage") = errMessage
      Response.Redirect("/lifeDB/error.asp");      
   }
}

}
%>
