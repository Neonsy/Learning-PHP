<?php

declare(strict_types=1);

namespace MVCSpace\Model;

class Note extends Base
{
    public function getAll(int $aid): bool|array
    {
        return $this->db->query('SELECT * FROM note WHERE aid=:aid', [
            'aid' => $aid
        ])->fetch(true);
    }

    public function get(int $id, int $aid): bool|array
    {
        return $this->db->query('SELECT * FROM note WHERE id=:id AND aid=:aid',
            [
                'id' => $id,
                'aid' => $aid
            ])->fetch();
    }

    public function update(int $id, string $title, string $content): void
    {
        $this->db->query('UPDATE note SET title=:title, content=:content WHERE id=:id',
            [
                'id' => $id,
                'title' => $title,
                'content' => $content
            ]);
    }

    public function delete(int $id, int $aid): void
    {
        $this->db->query('DELETE FROM note WHERE id=:id AND aid=:aid', [
            'id' => $id,
            'aid' => $aid
        ]);
    }

    public function add(int $aid, string $title, string $content): void
    {
        $this->db->query('INSERT INTO note (aid,title,content) VALUES (:aid,:title,:content)', [
            'aid' => $aid,
            'title' => $title,
            'content' => $content
        ]);
    }
}