<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample:run {dir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(str_repeat('*', 64));
        $this->info('Entrypoint - Context Analysis');
        $this->info(str_repeat('*', 64));
        $this->newLine();
        $this->line('Starting parser... ');
        $this->line('Walking trees......');
        $this->line('Finding Vulnerabilities...');
        $this->newLine();
        $this->warn('Found [6] vulnerabilities.');
        $this->newLine();
        $this->alert('Routes:');
        $this->info('/blogs');
        $this->info('/blogs/create');
        $this->info('/uploads/start');
        $this->info('/contact_us/send');
        $this->newLine();

        $this->alert('Settings:');
        $this->info('$config["CSRF"] = false');
        $this->info('$config["database"] = "myself"');
        $this->newLine();

        $this->alert("Credentials:");
        $this->info("MySQL Username: eoin");
        $this->info("MySQL password: abcd12345");

        $this->newLine();
        $this->alert('Vulnerabilities');
        $this->info('/contact_us/send');
        $this->error("  * SQL Injection - \$_GET['abcd'] -> \$id -> \$result -> \$find");
        $this->error("  * SQL Injection - \$_POST['abcd'] -> \$id -> \$result -> \$find");

        $this->newLine();
        $this->info('/uploads/start');
        $this->error("  * Directory Traversal - \$_POST['name'] -> \$name -> \$upload -> \$target");
        $this->error("  *  Unsafe Uploads - \$_FILES['tmp_name']");

        $this->newLine();
        $this->info('/blogs/create');
        $this->error("  * SQL Injection - \$_POST['title'] -> \$name");
        $this->error("  * SQL Injection - \$_POST['description'] -> \$name");
        $this->error("  * File Inclusion - \$_POST['image'] -> \$image");

        $this->newLine(2);
        $this->info('Created report.html');
        return 0;
    }
}
