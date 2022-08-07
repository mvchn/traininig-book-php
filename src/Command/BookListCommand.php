<?php

namespace App\Command;

use App\Model\Book;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookListCommand extends Command
{
    protected static $defaultName = 'app:book-list';

    private array $books = [];

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->books[1] = new Book('Python Crash Course', 'python');
        $this->books[2] = new Book('Code', 'computer-science');
        $this->books[3] = new Book('Essential Scrum', 'management');
        $this->books[4] = new Book('The Art Of Strategy', 'philosophy');
        $this->books[5] = new Book('Writing Is Designing', 'theory');
        $this->books[6] = new Book('The Go Programming Language', 'go');
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

        if(!array_key_exists($id, $this->books)) {
            $io->error(sprintf('Book %d is not available', $id));

            return Command::INVALID;
        }

        $book = $this->books[$id];

        $io->section(sprintf('Book by id: %d', $id));

        $io->writeln([
            sprintf('%s', $book->getTitle()),
            sprintf('[ %s ]', $book->getCategory()),
        ]);

        return Command::SUCCESS;

    }
}
