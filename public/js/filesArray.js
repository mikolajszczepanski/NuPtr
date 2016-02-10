/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    
   var template = 
            '<div id="file{{NUMBER}}">' +
            '<div class="form-group">' +
            '<label for="file_name{{NUMBER}}">File {{NUMBER}}</label>' +
            '<input type="text" name="files[{{NUMBER}}][name]" class="form-control" id="file_name{{NUMBER}}" placeholder="Name of file {{NUMBER}}">' +
            '</div><div class="form-group">' +
            '<label for="file_content{{NUMBER}}">Content</label>' +
            '<textarea class="form-control" name="files[{{NUMBER}}][content]" id="file_content{{NUMBER}}" rows="3"></textarea>' +
            '</div>' +
            '</div>';
    
   var numFiles = 0;
   
   $('#addFileToFilesArray').click(function(event){
       numFiles++;
       var temp = template.replace(/{{NUMBER}}/g,numFiles.toString());
       $('#filesArray').append(temp);
       event.preventDefault();
   });
   $('#removeFileFromFilesArray').click(function(event){
       if(numFiles>0){
            $('div#file' + numFiles.toString()).html('');
            numFiles--;
            event.preventDefault();
        }
   });
   
   
});


