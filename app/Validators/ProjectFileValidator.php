<?php
namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:255',
            'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip',
            'description' => 'required|max:500',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|max:255',
            'description' => 'required|max:500',
        ]
    ];
}