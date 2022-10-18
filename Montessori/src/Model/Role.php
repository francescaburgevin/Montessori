<?php

class Role {
    
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $name
     */
    private string $name;


    /**
     * Constructeur $User
     */
    public function __construct(){}

    /**
     * Get $id
     *
     * @return  int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set $id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Get $name
     *
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
}