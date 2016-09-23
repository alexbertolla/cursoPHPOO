/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


tinyMCE.init({
    selector: "textarea",
    menubar: false,

//    theme: "",
    width: "50rem",
    height: "10rem",
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
//    content_css: "css/formConfigurarSituacaoPedido.css",

    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview",
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]




//    mode: "textareas"
//    theme: "advanced",
////    plugins: "table,save,advhr,advimage,advlink,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,-emotions,fullpage",
////    theme_advanced_buttons1_add_before: "save,newdocument,separator",
//    theme_advanced_buttons1_add: "fontselect,fontsizeselect",
////    theme_advanced_buttons2_add: "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
////    theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
////    theme_advanced_buttons3_add_before: "tablecontrols,separator",
////    theme_advanced_buttons3_add: "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen,fullpage",
//    theme_advanced_toolbar_location: "top",
//    theme_advanced_toolbar_align: "left",
//    //theme_advanced_path_location: "bottom",
//    content_css: "example_full.css",
//    plugin_insertdate_dateFormat: "%Y-%m-%d",
//    plugin_insertdate_timeFormat: "%H:%M:%S",
//    extended_valid_elements: "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
//    external_link_list_url: "example_link_list.js",
//    external_image_list_url: "example_image_list.js",
//    flash_external_list_url: "example_flash_list.js",
//    file_browser_callback: "fileBrowserCallBack",
//    theme_advanced_resize_horizontal: false,
//    theme_advanced_resizing: false,
//    apply_source_formatting: true,
//    language: "pt_br"

});