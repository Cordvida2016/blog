<%
//Retorna o dia da semana de uma data específica. Recebe: mm/dd/yyyy
function getWeekday(date)
{
  var thedate = new Date(date);
  Weekday = new Array("Domingo", "Segunda", "Terça","Quarta","Quinta", "Sex","Sábado");
  return Weekday[thedate.getDay()];
}

//Retorna em qual semana uma data específica se encontra. Recebe: mm/dd/yyyy
function getWeeknumber(month,day,year)
{
  FirstDay = month+"/1/"+year; //monta-se a data com o rimeiro dia daquele mes

  //capturamos o dia da semana
  Today = getWeekday(FirstDay);
  
  //De acordo com o dia da semana setamos um offset para ser usado no calculo do numero da semana do primeiro dia da semana
  switch (Today){
  case "Domingo":
    weeknumber = 0;
  break;
  case "Segunda":
    weeknumber = 1;
  break;
  case "Terça":
    weeknumber = 2;
  break;
  case "Quarta":
    weeknumber = 3;
  break;
  case "Quinta":
    weeknumber = 4;
  break;
  case "Sexta":
    weeknumber = 5;
  break;
  case "Sábado":
    weeknumber = 6;
  break;
  }
  
  //Captura a semana inicial
  number = Math.floor((day+weeknumber)/7);
  
  //Se o resultado da divisao acima gerar um resto, adcionamos 1 para capturar o numero correto
  if (((day+weeknumber) %7) != 0){
    number++;
  } 
  
  return number;
}

//Retorna diferenca entre 2 datas
function datediff(per,d1,d2)
{
   if(per != null && d1 != null && d2 != null)
   {
      d = (d2.getTime()-d1.getTime())/1000
      switch(per) 
      {
         case "yyyy": 
            d/=12 //anos
   
         case "m": 
            d*=12*7/365.25 //meses
   
         case "ww": 
            d/=7 //semanas
   
         case "d": 
            d/=24 //dias
   
         case "h": 
            d/=60 //horas
   
         case "n": 
            d/=60 //minutos
      }
      return Math.round(d);
   }
   else
   {
      return 0
   }
}

//Retorna o mes recebendo como parametro o mes do array de uma data (0=jan, dez=11)
function getMonthAsString(monthNumber)
{
  var monthNow = new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
  return monthNow[monthNumber];
}


//Retorna o mes abreviado recebendo como parametro o mes do array de uma data (0=jan, dez=11)
function getShortMonth(monthNumber)
{
  var monthNow = new Array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");
  return monthNow[monthNumber];
}

//Retorna data de 1 semana atras formatada dd/mm/yyyy
function getLasWeekDate()
{
   thisDate = new Date()
   thisDate.setDate(thisDate.getDate() - 7)
   d = (thisDate.getDate() < 10)?"0" + thisDate.getDate():thisDate.getDate()
   m = ((thisDate.getMonth()+1) < 10)?"0" + (thisDate.getMonth() + 1):(thisDate.getMonth() + 1)
   y = thisDate.getFullYear()  
   
   return d + "/" + m + "/" + y
}

//Retorna data atual formatada dd/mm/yyyy
function getTodayDate()
{
   thisDate = new Date()
   d = (thisDate.getDate() < 10)?"0" + thisDate.getDate():thisDate.getDate()
   m = ((thisDate.getMonth()+1) < 10)?"0" + (thisDate.getMonth() + 1):(thisDate.getMonth() + 1)
   y = thisDate.getFullYear()  
   
   return d + "/" + m + "/" + y
}

//Retorna uma data formatada como dd/mm/yyyy hh:mm:ss
function genFullDate(intDate)
{
   d  = (intDate.getDate() < 10)?"0" + intDate.getDate():intDate.getDate()
   m  = ((intDate.getMonth()+1) < 10)?"0" + (intDate.getMonth() +1 ):(intDate.getMonth() + 1)
   y  = intDate.getFullYear()
   h  = intDate.getHours()
   mm = intDate.getMinutes()
   s  = intDate.getSeconds()
   
   return d + "/" + m + "/" + y + " " + h + ":" + mm + ":" + s
}

//Recebe um objeto data, formata e devolve com o formato data do MySQL : yyyy-mm-dd hh:mm:ss
function genMySQLDate(intDate)
{
   intDate = new Date(intDate)
   d  = (intDate.getDate() < 10)?"0" + intDate.getDate():intDate.getDate()
   m  = ((intDate.getMonth()+1) < 10)?"0" + (intDate.getMonth() + 1):(intDate.getMonth()+1)
   y  = intDate.getFullYear()
   h  = intDate.getHours()
   mm = intDate.getMinutes()
   s  = intDate.getSeconds()
   
   return y + "-" + m + "-" + d + " " + h + ":" + mm + ":" + s   
}

//Devolve com o formato data do MySQL : yyyy-mm-dd hh:mm:ss
function genMySqlDateNow(sep)
{
   today = new Date()
   d  = (today.getDate() < 10)?"0" + today.getDate():today.getDate()
   m  = ((today.getMonth()+1) < 10)?"0" + (today.getMonth() + 1):(today.getMonth() + 1)
   y  = today.getFullYear()
   h  = today.getHours()
   mm = today.getMinutes()
   s  = today.getSeconds()
   
   return y + sep + m + sep + d + " " + h + ":" + mm + ":" + s
}

//Retorna a data atual formatada como dd/mm/yyyy hh:mm:ss (pode-se definir o separador da data)
function genDateNow(sep)
{
   today = new Date()
   d = (today.getDate() < 10)?"0"+today.getDate():today.getDate()
   m = ((today.getMonth()+1) < 10)?"0"+(today.getMonth()+1):(today.getMonth()+1)
   y = today.getFullYear()
   h = today.getHours()
   mm = today.getMinutes()
   s = today.getSeconds()
   return d + sep + m + sep + y + " " + h + ":" + mm + ":" + s
}

//Retorna a data atual formatada como dd/mm/yyyy hh:mm:ss (pode-se definir o separador da data)
function genDate(intDate,sep)
{
   m = new Number(intDate.substr(0,2))
   d = new Number(intDate.substr(3,2))
   y = new Number(intDate.substr(6,4))
   d = leadingZero(d)
   m = leadingZero(m)
   return d + sep + m + sep + y
}

//Format data MySQL para padrao dd/mm/yyyy ou em branco caso o parametro seja nulo
function genDateFromMySQL(intDate,full)
{
   if(intDate == null || intDate == "")
   {
      return ""
   }
   
   intDate = new Date(intDate)
   d  = (intDate.getDate() < 10)?"0"+intDate.getDate():intDate.getDate()
   m  = ((intDate.getMonth()+1) < 10)?"0"+(intDate.getMonth()+1):(intDate.getMonth()+1)
   y  = intDate.getFullYear()
   h  = intDate.getHours()
   mm = intDate.getMinutes()
   s  = intDate.getSeconds()
   
   returnValue = d + "/" + m + "/" + y
   
   if(full == true)
   {
     returnValue += " " + leadingZero(h) + ":" + leadingZero(mm) + ":" + leadingZero(s)
   }
   
   return returnValue     
}

//Pega uma data no formato mm/dd/yyyy e formata para formato mySQL sem horario
function strDateToMySQL(intDate)
{
   if(intDate != null)
   {
      m = new Number(intDate.substr(0,2))
      d = new Number(intDate.substr(3,2))
      y = new Number(intDate.substr(6,4))
      d = leadingZero(d)
      m = leadingZero(m)
      
      return y + "-" + d + "-" + m    
   }
   else
   {
      return ""
   }
}

//Recebe uma data formato dd/mm/yyyy hh:mm:ss e cria um array associativo com os valores para serem usados em separado
function splitDateValues(date)
{
  arrDate = new Array()
  
  arrDate["day"]    = ""
  arrDate["month"]  = ""
  arrDate["year"]   = ""
  arrDate["hour"]   = ""
  arrDate["minute"] = ""

  if(date != null)
  {  
     intDate = new Date(date)
     arrDate["day"]    = ((intDate.getMonth()+1) < 10)?"0"+(intDate.getMonth()+1):(intDate.getMonth()+1);
     arrDate["month"]  = (intDate.getDate() < 10)?"0"+intDate.getDate():intDate.getDate();
     arrDate["year"]   = intDate.getFullYear()
     arrDate["hour"]   = (intDate.getHours() < 10)?"0"+intDate.getHours():intDate.getHours()
     arrDate["minute"] = (intDate.getMinutes() <10)?"0"+intDate.getMinutes():intDate.getMinutes()
   }
  
  return arrDate
}

function leadingZero(nr)
{
	if (nr < 10) nr = "0" + nr;
	return nr;
}
%>
