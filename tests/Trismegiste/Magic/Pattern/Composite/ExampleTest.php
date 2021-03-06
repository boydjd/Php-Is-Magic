<?php

/*
 * DesignPatternsPHP
 */

namespace tests\Trismegiste\Magic\Pattern\Composite;

use tests\Trismegiste\Magic\Pattern\Composite\Example\File;
use tests\Trismegiste\Magic\Pattern\Composite\Example\Folder;
use Trismegiste\Magic\Pattern\Composite\Iterator;

/**
 * ExampleTest tests the composite
 */
class ExampleTest extends CompositeTestCase
{

    protected function buildRootNode()
    {
        return new Folder('root');
    }

    protected function buildChild()
    {
        return new File(rand());
    }

    protected function buildNode($level)
    {
        if ($level == 0) {
            $node = new File($level);
        } else {
            $node = new Folder($level);
            $node->append($this->buildNode($level - 1));
            $node->append($this->buildNode($level - 1));
        }
        return $node;
    }

    public function testTree()
    {
        $depth = 4;
        $current = $this->buildNode($depth);
        for ($k = 0; $k < $depth; $k++) {
            $current = $current->getIterator()->current();
        }
        $this->assertInstanceOf(__NAMESPACE__ . '\Example\File', $current);
    }

    /**
     * Here it is an example of Iterator with the 
     * PHP ascii output \RecursiveTreeIterator
     */
    public function this_bugs_with_travisCI_testIterator()
    {
        $depth = 2;
        $current = $this->buildNode($depth);
        $it = new \RecursiveTreeIterator(new Iterator($current));
        $this->expectOutputString(<<<TREE
|-[1]
| |-[0]
| \-[0]
\-[1]
  |-[0]
  \-[0]

TREE
        );
        foreach ($it as $entry) {
            echo $entry . PHP_EOL;
        }
    }

}