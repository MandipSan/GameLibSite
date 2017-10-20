function singleValidator(formName, gameName){
   var temp = gameName + "date";
   var releaseDateData = document.forms[formName][temp].value;
   temp = gameName + "genre[]";
   var genreData = document.forms[formName];
   genreData = genreData.elements[temp];
   
   if(gameName == ""){
      var gameTitleData = document.forms[formName]["gamename"].value;
      if(gameTitleData == ""){
         alert("Missing Game Title");
         return false;
      }
   }
   if(releaseDateData == ""){
      alert(gameName + " Missing Release Date");
      return false;
   }
   var selected = false;
   for(var i = 0; i < genreData.length; i++){
      if(genreData[i].checked){
         selected = true;
         break;
      } 
   }
   if(!selected){
      alert(gameName + " No Genre Selected");
      return false;
   }
   return true;
}

function multValidator(formName, gameNames){
   for(var i = 0; i < gameNames.length; i++){
      if(!singleValidator(formName, gameNames[i])){
         return false;
      }
   }
   return true;
}

