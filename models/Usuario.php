<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes escribir tu password';
        }
        return self::$alertas;

    }

    // Validación para cuentas nuevas
    public function validarNuevaCuenta() {
        $this->revisar_nombre();
        $this->revisar_email();
        $this->revisar_password();
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        $this->revisar_email();
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        $this->revisar_password();

        return self::$alertas;
    }

    public function validar_perfil() {
        $this->revisar_nombre();
        $this->revisar_email();
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El password nuevo debe contener al menos 6 caracteres';
        }else if(strlen($this->password_nuevo) > 60){
            self::$alertas['error'][] = 'El password nuevo no debe superar los 60 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }

    private function revisar_password(){
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }else if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }else if(strlen($this->password) > 60){
            self::$alertas['error'][] = 'El password no debe superar los 60 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password deben coincidir';
        }
    }

    private function revisar_email(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }else if(strlen($this->email) > 50){
            self::$alertas['error'][] = 'El email no debe superar los 50 caracteres';
        }
    }

    private function revisar_nombre(){
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }else if(strlen($this->nombre) > 30){
            self::$alertas['error'][] = 'El Nombre del Usuario no debe superar los 30 caracteres';
        }
        if(preg_match_all("/[\w]{23,}/", $this->nombre, $matches)){
            self::$alertas['error'][] = 'No puede haber palabras de más de 22 caracteres';
        }
    }
}