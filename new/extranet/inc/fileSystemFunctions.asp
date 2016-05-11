<%
//Setting some constants for use with the FilesystemObject
var TristateFalse = false
var ForAppending = 8, ForReading = 1, ForWriting = 2

function recDatainFile(file,data,action)
{
  e = new Error();
  try
  {
      fso = Server.CreateObject("Scripting.FileSystemObject"); 
      arc = fso.OpenTextFile(file,action,true)   
      arc.Write(data)
      arc.Close();
      arc = null  
      fso = null
      return true;
  }
  
  catch(e)
  {
    return false
    errorDescription = e.description;
  }
}


function readDatainFile(file,createFile)
{
  e = new Error();
  try
  {
     fso = Server.CreateObject("Scripting.FileSystemObject")
     arq = fso.OpenTextFile(file,1,createFile)
     content = arq.ReadAll()
     arq.Close();
     arq = null
     fso = null
  }
  
  catch(e)
  {
    return false
    errorDescription = e.description;
  } 

   return content
}


//Load content from one file and write it into another
function fileToFile(File,NewFile)
{
  errorObj = new Error();//create an object error to cacth any error to return in the function
  try{
    Fso = Server.CreateObject("Scripting.FileSystemObject");
    Arc = Fso.OpenTextFile(File,1,true)//True Create the file if it dont exist
    FileContent = Arc.ReadAll()//read the content of the file
    Arc = Fso.OpenTextFile(NewFile,2,true)
    Arc.Write(FileContent)//now write the content of the first file on the second
    Arc.Close();
    Arc = null
    NoError = false;
  }//end try
  
  catch(errorObj)
  {
    NoError =  true;  
    errorDescription= errorObj.description;//show the error that occured
  }
  
  return NoError
}//end method
%>
