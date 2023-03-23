<?php
namespace LidemFramework\Form;

class FormResult
{
    private string $success_message; //on déclare la propriété privé

    public function getSuccessMessage(): string //on crée son getter
    {
        return $this->success_message;
    }

    private array $form_error = [];

    public function getError(): array
    {
        return $this->form_error;
    }

    public function __construct(string $success_message = '')
    {
        $this->success_message = $success_message;
    }

    public function addError(FormError $error): void
    {
        $this->form_error[] = $error;
    }

    public function hasError(): bool
    {
        return !empty($this->form_error);
    }
}