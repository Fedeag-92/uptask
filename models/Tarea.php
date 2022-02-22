<?php

namespace Model;

class Tarea extends ActiveRecord {
    protected static $tabla = 'tareas';
    protected static $columnasDB = ['id', 'nombre', 'estado', 'prioridad', 'proyectoId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->prioridad = $args['prioridad'] ?? 0;
        $this->proyectoId = $args['proyectoId'] ?? '';
    }
}