<?php

namespace Core;

class Util
{
    // Obtener la URL
    public static function baseUrl()
    {
        $baseUrl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http');
        $baseUrl .= '://'.$_SERVER['HTTP_HOST'];
        $baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseUrl = str_replace(PUBLIC_FOLDER.'/', '', $baseUrl);
        return $baseUrl;
    }

    // Sanar una cadena
    public function cleanString($str, $type)
    {
        $search = array(
                '@<script[^>]*?>.*?</script>@si',
                '@<[\/\!]*?[^<>]*?>@si',
                '@<style[^>]*?>.*?</style>@siU',
                '@<![\s\S]*?--[ \t\n\r]*>@siU',
                "/\\\\n/"
            );

        $str = ini_get('magic_quotes_gpc') ? stripslashes($str) : $str;
        $str = strip_tags(preg_replace($search, '', $str));
        $str = trim($str);
        $str = htmlspecialchars($str);
        $str = stripslashes($str);
        $str = htmlentities($str);
        $str = addslashes($str);

        if($type == 'string'){

            $str = filter_var($str, FILTER_SANITIZE_STRING);

        }elseif($type == 'email'){

            $str = filter_var($str, FILTER_SANITIZE_EMAIL);


        }elseif($type == 'int'){

            $str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);

        }
                        
        return $str;
    }

    // Plugin Sweet Alert
    public function sweetAlert($data)
    {
        if($data['alert'] == "simple"){
            $alert = " 
                <script>
                    swal({
                        type: '".$data['type']."',
                        title: '".$data['title']."',
                        text: '".$data['text']."'
                    });
                </script>
            ";

        }elseif($data['alert'] == "reload") {

            $alert = " 
                <script>
                    swal({
                        type: '".$data['type']."',
                        title: '".$data['title']."',
                        text: '".$data['text']."',
                        confirmButtonText: 'OK'
                        }).then(function(){
                                location.reload();
                        });
                </script>
            ";

        }elseif($data['alert'] == "clean") {

            $alert = " 
                <script>
                    swal({
                        type: '".$data['type']."',
                        title: '".$data['title']."',
                        text: '".$data['text']."',
                        confirmButtonText: 'OK'
                        }).then(function(){
                                $('form')[0].reset();
                        });
                </script>
            ";

        }elseif($data['alert'] == "redirect") {

            $alert = " 
                <script>
                    swal({
                        type: '".$data['type']."',
                        title: '".$data['title']."',
                        text: '".$data['text']."',
                        confirmButtonText: 'OK'
                        }).then(function(){
                                window.location.href = '".self::baseUrl()."'
                        });
                </script>
            ";

        }

        return $alert;
    }

    // Mensajes de Bootstrap
    public function alert($data){

        $alert = '

            <div class="alert alert-'.$data['type'].'" role="alert">
                <span class="alert-inner--icon"><i class="'.$data['icon'].'"></i></span>
                <span class="alert-inner--text">'.$data['text'].'</span>
            </div>

        ';

        return $alert;

    }
}
