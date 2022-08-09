<?php

namespace App\Model;

class Book
{
    private $id;
    private $title;
    private $category;
    private $pagesCount;
    private $currentPage;

    public function __construct(string $title, string $category, int $pagesCount = 0)
    {
        $this->title = $title;
        $this->category = $category;
        $this->pagesCount = $pagesCount;
        $this->currentPage = 0;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getPagesCount() : int
    {
        return $this->pagesCount;
    }

    public function getCategory() : string
    {
        return $this->category;
    }

    public function getCurrentPage() : int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $page) : self
    {
        $this->currentPage = $page;

        return $this;
    }

}
