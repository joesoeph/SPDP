<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Engine template
*/

class ParentModel {

    function valTitle() {
        return $Value = 'Proxis';
    }

    function arrMeta() {
        $Value = [
            [
                'name' => 'Content-Type',
                'content' => 'text/html; charset=UTF-8',
                'type' => 'equiv'
            ],
            [
                'name' => 'X-UA-Compatible',
                'content' => 'IE=edge'
            ],
            [
                'name' => 'viewport',
                'content' => 'width=device-width, initial-scale=1'
            ],
        ];

        return $Value;
    }

    function arrCss() {
        $Value = [
           // 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
          'assets/css/bootstrap.min.css',
          'assets/css/simple-sidebar.css',
          'assets/css/style.css',
          'assets/css/select2.min.css',
          'assets/css/jquery.dataTables.min.css',
          'assets/vendor/bootstrap-select/css/bootstrap-select.min.css',
          'assets/css/jquery-confirm.min.css',
        ];

        return $Value;
    }

    function arrCss2(){
      $Value = [
        'assets/css/bootstrap.min.css',
        'assets/css/style-login.css'
      ];

      return $Value;
    }

    function arrJsHeader() {
        $Value = [
          'assets/js/jquery-2.1.4.min.js',
          'assets/js/bootstrap.min.js',
          'assets/js/bootstrap-select.js',
          'assets/js/jquery.dataTables.min.js',
          'assets/js/jquery.sticky.js',
          'assets/js/jquery-confirm.min.js'
        ];

        return $Value;
    }

    function arrJsFooter() {
        $Value = [];

        return $Value;
    }

}
