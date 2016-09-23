/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    var conteudoSistema = $("#conteudoSistema");
    
    var linkRapido = function (href) {
       $(conteudoSistema).load(href, null);
    };
    
    $("div.tile").each(function () {
        $(this).css('cursor', 'pointer');
        $(this).click(function (evt) {
            evt.stopPropagation();
            linkRapido($(this).data("url"));
        });
    });
});