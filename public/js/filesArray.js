/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    
    var template = null;
    
    /* For test server */
    var url = document.URL;
    var link_add = '';
    if(url.indexOf('nuptr.azurewebsites.net') == -1){
        link_add = '/nuptr';
    }
    
    $.get('http://' + document.domain + link_add + "/api/get/file_template", function( data ) {
       template = data.file;
    }).fail(function() {
        console.log('Error');
    });
    
   var numFiles = $('#num_of_files') ? $('#num_of_files').val() : 0;
   
   $('#addFileToFilesArray').click(function(event){
       if(!template){
           event.preventDefault();
           return;
       }
       numFiles++;
       var temp = template.replace(/{NUMBER}/g,numFiles.toString());
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


