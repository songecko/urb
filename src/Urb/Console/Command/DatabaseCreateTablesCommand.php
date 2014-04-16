<?php

namespace Urb\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseCreateTablesCommand extends Command
{		
	protected function configure()
    {    	
        $this
            ->setName('database:tables:create')
            ->setDescription('Create all tables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$output->write('creating tables...');
    	$container = $this->getApplication()->getContainer();
    	$conn = $container->get('database')->getConnection();
    	$platform = $conn->getDatabasePlatform();
    	
    	$schema = new \Doctrine\DBAL\Schema\Schema();
    	$userTable = $schema->createTable("user");
    	$userTable->addColumn("id", "integer", array("unsigned" => true, "autoincrement" => true));
    	$userTable->addColumn("fbid", "string", array("length" => 255));
    	$userTable->addColumn("name", "string", array("length" => 255));
    	$userTable->addColumn("last_name", "string", array("length" => 255));
    	$userTable->addColumn("dni", "string", array("length" => 255));
    	$userTable->addColumn("email", "string", array("length" => 255));
    	$userTable->addColumn("birth_date", "date");
    	$userTable->addColumn("newsletter", "boolean");
    	$userTable->setPrimaryKey(array("id"));
    	$userTable->addUniqueIndex(array("email"));
    	
    	$queries = $schema->toSql($platform); // get queries to create this schema.
    	foreach ($queries as $query)
    	{
    		$conn->query($query);
    	}
    	
    	$output->writeln('done.');
    }
}