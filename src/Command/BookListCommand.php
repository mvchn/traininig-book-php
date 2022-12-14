<?php

namespace App\Command;

use App\Repository\BookRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookListCommand extends Command
{
    protected static $defaultName = 'app:book-list';

    private BookRepository $books;

    public function __construct(string $name = null, BookRepository $books)
    {
        parent::__construct($name);
        $this->books = $books;
    }

    protected function configure(): void
    {
        $this
            // ...
            ->addArgument('id', InputArgument::OPTIONAL, 'Book identifier?')
            ->addArgument('action', InputArgument::OPTIONAL, 'Action name?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Home Library');

        $id = $input->getArgument('id');

        if(!$id) {
            $booksPresenter = [];
            foreach ($this->books as $key => $user) {
                $booksPresenter[] = sprintf('%d. %s', $key, $user->getTitle());
            }

            $io->listing($booksPresenter);

            $id = $io->ask('Enter book id:', 0, function ($number) {
                if (!is_numeric($number)) {
                    throw new \RuntimeException('You must type a number.');
                }

                return (int) $number;
            });
        }

        if(!$book = $this->books->get($id)) {
            $io->error(sprintf('Book %d is not available', $id));

            return Command::INVALID;
        }

        $io->section(sprintf('Book %s', $book));

        $io->writeln([
            sprintf('%s', $book->getTitle()),
            sprintf('[ %s ]', $book->getCategory()),
        ]);

        return Command::SUCCESS;

    }
}
