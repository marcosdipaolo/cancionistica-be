<?php

namespace App\Dto;

class ContactFormData
{
    private string $name = "";
    private string $email = "";
    private string $mesage = "";

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMesage(): string
    {
        return $this->mesage;
    }

    /**
     * @param string $mesage
     * @return $this
     */
    public function setMesage(string $mesage): self
    {
        $this->mesage = $mesage;
        return $this;
    }

}
