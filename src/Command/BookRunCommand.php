<?php

namespace App\Command;

use App\Exception\BookNotFoundException;
use App\Repository\BookRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookRunCommand extends Command
{
    protected static $defaultName = 'app:book-run';

    private BookRepository $books;

    public function __construct(string $name = null, BookRepository $books)
    {
        parent::__construct($name);

        $this->books = $books;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Book identifier?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Home Library');

        $id = $input->getArgument('id');

        try {
            $book = $this->books->get($id);
        } catch (BookNotFoundException $e) {
            $io->error(sprintf('Book %d is not available', $id));

            //TODO: log $e
            return Command::INVALID;
        }

        $io->section(sprintf('Book %s', $book));

        $io->writeln([
            sprintf('%s', $book->getTitle()),
            sprintf('[ %s ]', $book->getCategory()),
        ]);

        $action = $io->choice('Select action', ['run', 'edit', 'return']);

        $io->writeln($action);

        return Command::SUCCESS;

    }
}
