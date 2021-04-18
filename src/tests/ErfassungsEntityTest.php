<?php
namespace DB\Objects;
use PHPUnit\Framework\TestCase;

final class ErfassungsEntityTest extends TestCase {
    public function testCanBeCreatedFromValidParams(): void
    {
        $this->assertTrue(class_exists('DB\Objects\ErfassungsEntity'), "class \"ErfassungsEntity\" is not yet defined");
        
        $entity = new ErfassungsEntity("a", "b", "c", "d", "e");
        $this->assertTrue($entity->dauer == "e");
    }

    public function testCannotBeCreatedFromWrongNumberOfParams(): void
    {
        $this->expectException(\ArgumentCountError::class);

        new ErfassungsEntity("a", "b", "c", "d");
    }
    
    public function testDoSomething(): void
    {
        $entity = new ErfassungsEntity("a", "b", "c", "d", "e");
        $this->assertEquals( "bd", $entity->do_something());
    }
}
