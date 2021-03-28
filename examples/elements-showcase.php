<?php

use GrizzIt\Task\Common\TaskInterface;
use GrizzIt\Task\Component\TaskList;
use GrizzIt\Cli\Factory\IoFactory;
use GrizzIt\Cli\Factory\ThemeFactory;
use GrizzIt\Cli\Factory\ElementFactory;
use GrizzIt\Cli\Generator\ThemeGenerator;
use GrizzIt\Cli\Component\Theme\DefaultTheme;

require_once(__DIR__ . '/../vendor/autoload.php');

$ioFactory = new IoFactory();
$theme = (new DefaultTheme(new ThemeGenerator(new ThemeFactory(
    $ioFactory
))))->getTheme();
$elementFactory = new ElementFactory($theme, $ioFactory);

// Create a textual element styled as a title.
$elementFactory->createText('This is a title', true, 'title')->render();

// Create a table with some information.
$elementFactory->createTable(
    ['firstname', 'lastname', 'age', 'height', 'description'],
    [
        [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'age' => 25,
            'height' => '194cm',
            'description' => 'A very peculiar man.'
        ],
        [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'age' => 23,
            'height' => '173cm',
            'description' => 'The wife of this very peculiar man.'
        ]
    ]
)->render();

// A list
$elementFactory->createList(
    ['foo', 'bar', 'baz', 'qux']
)->render();

// Create a command list and display all git commands.
$elementFactory->createExplainedList(
    [
        'git' => 'Displays a help command',
        'git.clone' => 'Clone a repository into a new directory',
        'git.init' => 'Create an empty Git repository or reinitialize an existing one',
        'git.add' => 'Add file contents to the index',
        'git.mv' => 'Move or rename a file, a directory, or a symlink',
        'git.reset' => 'Reset current HEAD to the specified state',
        'git.rm' => 'Remove files from the working tree and from the index',
        'git.bisect' => 'Use binary search to find the commit that introduced a bug',
        'git.grep' => 'Print lines matching a pattern',
        'git.log' => 'Show commit logs',
        'git.show' => 'Show various types of objects',
        'git.status' => 'Show the working tree status',
        'git.branch' => 'List, create, or delete branches',
        'git.checkout' => 'Switch branches or restore working tree files',
        'git.commit' => 'Record changes to the repository',
        'git.diff' => 'Show changes between commits, commit and working tree, etc',
        'git.merge' => 'Join two or more development histories together',
        'git.rebase' => 'Reapply commits on top of another base tip',
        'git.tag' => 'Create, list, delete or verify a tag object signed with GPG',
        'git.fetch' => 'Download objects and refs from another repository',
        'git.pull' => 'Fetch from and integrate with another repository or a local branch',
        'git.push' => 'Update remote refs along with associated objects',
    ],
    'command-explained-list-key',
    'command-explained-list-description'
)->render();

// Create a block with the style of an error.
$elementFactory->createBlock(
    'Exception: Some error occurred!',
    'error-block'
)->render();

// Create a block with the style of a success message.
$elementFactory->createBlock(
    'You did great!',
    'success-block'
)->render();

$taskList = new TaskList();
$task = (new class implements TaskInterface {
    /**
     * Executes the task.
     *
     * @return bool
     */
    public function execute(): bool
    {
        sleep(3);
        return true;
    }
});

$taskList->addTask($task, 'Loading wait message.');
$taskList->addTask($task, 'Acting like something is going on.');
$taskList->addTask($task, 'I am definitely doing something.');
$taskList->addTask($task, 'Notice how slow I am?');
$taskList->addTask($task, 'Well, I\'m not sleep deprived.');
$taskList->addTask($task, 'PHP applications need to rest as well sometimes.');
$taskList->addTask($task, 'Okay, I am done now, bye.');

$elementFactory->createProgressBar($taskList)->render();
