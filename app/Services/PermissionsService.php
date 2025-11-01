<?php

namespace App\Services;

class PermissionsService
{
    protected static $panels = ['admin','it'];

    protected static $actions = ['create'=>'Crear','viewAny'=>'Ver','update'=>'Editar','delete'=>'Eliminar'];

    protected static $resources = [ 'it'=>
                                        [ 'students'=>'Alumnos','users'=>'Usuarios'],
                             'admin'=>
                                        [ 'students'=>'Alumnos','users'=>'Usuarios']
                            ];

    public static function getPermissions(){
        $out = [];
        foreach(self::$panels as $panel){
            foreach(self::$actions as $action=>$actionLabel){
                foreach(self::$resources[$panel] as $resource=>$label){
                  $out[] = ['panel'=>$panel,'action'=>$action,'resource'=>$resource,'resource_es'=>$label,'action_es'=>$actionLabel];
                }
            }
        }


        return $out;
    }

}
