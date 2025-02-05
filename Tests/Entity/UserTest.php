<?php

namespace App\Tests\Entiry;

use PHPUnit\Framework\TestCase;
use App\Entity\Users;

class UserTest extends TestCase
{
    public function testSetNameValid()
    {
        $user = new Users();
        $user->setName("Olena Nesterets");
        $this->assertEquals("Olena Nesterets", $user->getName());
    }

    public function testSetNameEmpty()
    {
        $user = new Users();
        $user->setName("");
        $this->assertEquals("", $user->getName());
    }

    public function testSetEmailValid()
    {
        $user = new Users();
        $user->setEmail("johndoe@example.com");
        $this->assertEquals("johndoe@example.com", $user->getEmail());
    }

    public function testSetEmailInvalid()
    {
        $user = new Users();
        $user->setEmail("invalid-email");
        $this->assertFalse($user->isValidEmail());
    }

    public function testSetEmailEmpty()
    {
        $user = new Users();
        $user->setEmail("");
        $this->assertFalse($user->isValidEmail());
    }

    public function testGetNameBeforeSetting()
    {
        $user = new Users();
        $this->assertNull($user->getName());
    }

    public function testSetAndGetMultipleAttributes()
    {
        $user = new Users();
        $user->setName("Alice");
        $user->setEmail("alice@example.com");
        $this->assertEquals("Alice", $user->getName());
        $this->assertEquals("alice@example.com", $user->getEmail());
    }

    public function testInvalidEmailFormat()
    {
        $user = new Users();
        $user->setEmail("not-an-email");
        $this->assertFalse($user->isValidEmail());
    }

    public function testValidEmailFormat()
    {
        $user = new Users();
        $user->setEmail("test@example.com");
        $this->assertTrue($user->isValidEmail());
    }

    public function testNameLengthExceeded()
    {
        $user = new Users();
        $longName = str_repeat("a", 256); // Assuming name limit is 255 characters
        $user->setName($longName);
        $this->assertEquals($longName, $user->getName());
    }

    public function testNameAndEmailCombination()
    {
        $user = new Users();
        $user->setName("Charlie");
        $user->setEmail("charlie@example.com");
        $this->assertEquals("Charlie", $user->getName());
        $this->assertEquals("charlie@example.com", $user->getEmail());
    }

    public function testEmailWithSpecialCharacters()
    {
        $user = new Users();
        $user->setEmail("user+test@example.com");
        $this->assertTrue($user->isValidEmail());
    }

    public function testEmailWithSpaces()
    {
        $user = new Users();
        $user->setEmail(" user@example.com ");
        $this->assertFalse($user->isValidEmail());
    }
}