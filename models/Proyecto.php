<?php


namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord {
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }

    public function validarProyecto() {
        if(!$this->proyecto) {
            self::$alertas['error'][] = 'El Nombre del Proyecto es Obligatorio';
        }else if(strlen($this->proyecto) > 60){
            self::$alertas['error'][] = 'El Nombre del Proyecto no puede contener mas de 60 caracteres';
        }
        if(preg_match_all("/[\w]{17,}/", $this->proyecto, $matches)){
            self::$alertas['error'][] = 'No puede haber palabras de más de 16 caracteres';
        }


        return self::$alertas;
    }
}