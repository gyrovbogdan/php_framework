<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class UserService
{
    public function __construct(private Database $database)
    {
    }

    public function isEmailTaken(string $email, &$errors)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $params = ['email' => $email];

        $result = $this->database->query($query, $params);

        if ($result[0]['COUNT(*)'])
            $errors['email'][] = 'Email taken';
    }

    public function create($data)
    {
        $query = 'INSERT INTO users 
        (email, password, age, country, social_media_url)
        VALUES
        (:email, :password, :age, :country, :socialMediaURL);';

        $params = [
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'age' => $data['age'],
            'country' => $data['country'],
            'socialMediaURL' => $data['socialMediaURL']
        ];

        $this->database->query($query, $params);
    }

    public function checkPassword(array $formData, int &$id = null)
    {
        $query = 'SELECT id, password FROM users 
            WHERE email = :email';

        $params = ['email' => $formData['email']];
        $result =  $this->database->query($query, $params);

        $id = $result[0]['id'] ?? null;

        return password_verify($formData['password'], $result[0]['password'] ?? "");
    }

    public function id()
    {
        return $this->database->id();
    }
}
