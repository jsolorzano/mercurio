<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('assets_url()'))
{
    function assets_url($ruta='')
    {

        $rut = base_url().'assets/';
        if($ruta != ''){
            $rut = base_url('assets/'.$ruta);
        }
        return $rut;
    }
}