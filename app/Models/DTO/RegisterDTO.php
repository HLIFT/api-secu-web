<?php

namespace App\Models\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RegisterDTO extends DataTransferObject
{
    public string $firstname;

    public string $lastname;

    public string $email;

    public string $password;

    public static function fromRequest(Request $request): self {
        return new self([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);
    }
}
