<?php
/**
 * a PHP Console
 */

// Libraries
include '../nutshell/Nutshell.autoloader.php'; 

if (isset($_POST['code'])){
    //(var_dump($_POST['code']);
    nutshell\util\Debugger::tryCode($_POST['code']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>a PHP Console</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>
        $(document).ready(function() {
        
        $("#console").focus();
        $("#console").keyup(function() {
            while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                $(this).height($(this).height()+1);
            };
        });
        $("#console" ).keydown(function(e) {
            if (e.keyCode == 13){
            
            $("#line-number").html("");
            for (i=1; i<=$("#console").val().split("\n").length + 1; i++) {
                $("#line-number").html($("#line-number").html() + "<div class=\"line\">." + i + "</div>");
            }
            
                var php_data = $("#console").val();
                
                $.ajax({
                    type: "POST",    //define the type of ajax call (POST, GET, etc)
                    url: "00_debugger.php",   //The name of the script you are calling
                    data: "code=" + encodeURIComponent(php_data),    //Your data you are sending to the script
                    success: function(output){
                        //$("#output").html(output.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2'));   //Your resulting action
                        $("#output").html(output);
                    }
                });
            }
        });

        });  
        </script>
        <style type="text/css">
            /* http://meyerweb.com/eric/tools/css/reset/ 
                v2.0 | 20110126
                License: none (public domain)
            */

            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed, 
            figure, figcaption, footer, header, hgroup, 
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
            }
            
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure, 
            footer, header, hgroup, menu, nav, section {
                display: block;
            }
            body {
                line-height: 1;
            }
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            
            .line {
                width: 40px;
                background-color: #ccc;
                color: #fff;
                line-height: 20px;
                padding: 0 7px;
                text-align: right;
            }
        
            #line-number {
                position:absolute;
                float: left;
                margin: 10px;
                margin-left: 7px;
                padding-top: 20px;
            }
        
             #console {
                resize: none;
                overflow: hidden;
                
                margin: 10px;
                width: 60em;
                float: left;
                padding: 20px;
                padding-left: 60px;
                
                background-color: #888;
                color: #fff;
                font-family: courier;
                line-height: 20px;
            }
             
             #output {
                margin-left: 56em;
                padding: 15px;
                color: #777;
                font-family: tahoma;
            }
        </style>
    </head>
    <body>
        <div id="line-number"><div class="line">.1</div></div>
        <textarea id="console" contenteditable="true"></textarea>
        <div id="output"></div>
    </body>
</html>
