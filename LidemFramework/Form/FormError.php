<?php

namespace LidemFramework\Form;

class FormError
{
    private string $field_name;

    public function getFieldName(): string
    {
        return $this->field_name;
    }

    private string $message;

    public function getMessage(): string
    {
        return $this->message;
    }

    public function __construct(string $message, string $field_name = '')
    {
        $this->message = $message;
        $this->field_name = $field_name;
    }
}