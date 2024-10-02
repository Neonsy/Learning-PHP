<?php

declare(strict_types=1);

namespace MVCSpace\Model;

class Account extends Base
{
    public function create(string $username, string $email, string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query('INSERT INTO account (username,email,password) VALUES (:name,:mail,:password)',
            ['name' => $username, 'mail' => $email, 'password' => $hash]);
    }

    public function findName(string $username): array|bool
    {
        return $this->db->query('SELECT * FROM account WHERE username = :username',
            ['username' => $username])->fetch();
    }

    public function findMail(string $email): array|bool
    {
        return $this->db->query('SELECT * FROM account WHERE email = :email',
            [
                'email' => $email
            ])->fetch();
    }

    public function matchCredentials(string $email, string $password): bool|int
    {
        $data = $this->db->query('SELECT id, password FROM account WHERE email = :email',
            [
                'email' => $email
            ])->fetch();

        if ($data) {
            if (password_verify($password, $data['password'])) {
                return $data['id'];
            }
        }
        return false;
    }

    public function delete(int $id): void
    {
        $this->db->query('DELETE FROM account WHERE id = :id', [
            'id' => $id
        ]);
    }

    public function updateMail(int $id, string $newMail): void
    {
        $this->db->query('UPDATE account SET email = :mail WHERE id = :id', [
            'id' => $id,
            'mail' => $newMail
        ]);
    }

    public function updatePassword(int $id, string $newPassword): void
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query('UPDATE account SET password = :password WHERE id = :id', [
            'id' => $id,
            'password' => $hash
        ]);
    }
}