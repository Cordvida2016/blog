<%
function formatNumber(expr,decplaces)
{
   str = "" + Math.round(eval(expr) * Math.pow(10,decplaces));
   
   while (str.length <= decplaces)
   {
      str = "0" + str;
   }
   
   decpoint = str.length - decplaces;
   
   return str.substring(0,decpoint) + "." + str.substring(decpoint, str.length);

}
%>
