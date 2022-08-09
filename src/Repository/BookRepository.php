<?php

namespace App\Repository;

use App\Exception\BookNotFoundException;
use App\Model\Book;

class BookRepository
{
    private array $books;

    private int $currentIterator = 0;

    public function __construct()
    {
        $this->add(new Book('Python Crash Course', 'python'));
        $this->add(new Book('Code', 'computer-science'));
        $this->add(new Book('Essential Scrum', 'management'));
        $this->add(new Book('The Art Of Strategy', 'philosophy'));
        $this->add(new Book('Writing Is Designing', 'theory'));
        $this->add(new Book('The Go Programming Language', 'go'));
    }

    public function add(Book $book) : self
    {
        $this->currentIterator++;

        $this->books[$this->currentIterator] = $book;

        return $this;
    }


    public function get(int $id) : Book
    {
        if(!array_key_exists($id, $this->books)) {
            throw new BookNotFoundException(sprintf("Book %d is not exists", $id));
        }

        return $this->books[$id];
    }
}
