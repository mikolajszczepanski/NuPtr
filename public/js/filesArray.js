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
            '<label for="file_data{{NUMBER}}">Code</label>' +
            '<textarea class="form-control" name="files[{{NUMBER}}][data]" id="file_data{{NUMBER}}" rows="6"></textarea>' +
            '</div>' +
            '</div>';
    
   var numFiles = $('#num_of_files') ? $('#num_of_files').val() : 0;
   
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
        }
        event.preventDefault();
   });
   
   
});


