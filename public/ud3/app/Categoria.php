<?php
declare(strict_types=1);
namespace TestClasses\Daw2;
class Categoria
{
    public function __construct(string $nombre, ?Categoria $padre = null){
        if(strlen(trim($nombre)) === 0 ){
            throw new \InvalidArgumentException("El nombre del categoria no puede estar vacio");
        }else{
            $this->nombre =$nombre;
            $this->padre = $padre;
        }
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPadre(): ?Categoria
    {
        return $this->padre;
    }

    public function getFullName() : string
    {
       if(!is_null($this->padre)){
           return "{$this->padre->getFullName()} > {$this->nombre}";
       }else{
           return $this->nombre;
       }
    }
}