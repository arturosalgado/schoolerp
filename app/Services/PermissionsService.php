<?php

namespace App\Services;

class PermissionsService
{
    protected  $panels = ['admin','it'];

    protected $actions = ['create','viewAny','update','delete'];

    protected $resources = [ 'it'=>
                                        [ 'students','roles','users'],
                             'admin'=>
                                        [ 'students','roles','users']
                            ];

    function getPermissions(){
        $out = [];
        foreach($this->panels as $panel){
            foreach($this->actions as $action){
                foreach($this->resources[$panel] as $resource){
                  $out[] = ['panel'=>$panel,'action'=>$action,'resource'=>$resource];
                }
            }
        }


        return $out;
    }

}
