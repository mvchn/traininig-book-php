<?php

namespace App\Tests\Repository;

use App\Exception\BookNotFoundException;
use App\Model\Book;
use App\Repository\BookRepository;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    public function testRepositoryFail() : void
    {
        $repository = new BookRepository();

        $this->expectException(BookNotFoundException::class);

        $repository->get(0);
    }

    public function testRepositorySuccess() : void
    {
        $repository = new BookRepository();
        $repository->add(new Book('test', 'test book'));

        $result = $repository->get(1);

        $this->assertInstanceOf(Book::class, $result);
    }
}
