/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    $('.clickableRow').css('cursor','pointer');
    $('.clickableRow').mouseover(function(){
       $(this).addClass('success');
    });
    $('.clickableRow').mouseout(function(){
       $(this).removeClass('success');
    });
    $('.clickableRow').click(function(event){
       $(this).find('div').toggleClass('hidden');
    });
    $('.clickableRow > a').click(function(event){
        event.stopPropagation();
    });
    
});

