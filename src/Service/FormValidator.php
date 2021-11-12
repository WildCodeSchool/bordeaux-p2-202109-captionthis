<?php

namespace App\Service;

class FormValidator
{
    private array $posts;

    protected array $errors = [];

    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function trimALL(): void
    {
        foreach ($this->posts as $key => $input) {
            if (is_string($input)) {
                $this->posts[$key] = trim($input);
            }
        }
    }

    /**
     * @return array
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    public function checkEmptyInputs(array $inputs): void
    {
        foreach ($this->posts as $key => $input) {
            if (array_key_exists($key, $inputs)) {
                if ($this->posts[$key] === '') {
                    $this->errors[] = $inputs[$key] . ' ne doit pas être vide';
                }
            }
        }
    }

    public function checkLength(string $input, string $label, int $min, int $max): void
    {
        if (strlen($input) <= $min) {
            $this->errors[] = $label . ' doit faire au minimum ' . $min . ' caractères.';
        }
        if (strlen($input) >= $max) {
            $this->errors[] = $label . ' doit faire au maximum '  . $max . ' caractères.';
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
