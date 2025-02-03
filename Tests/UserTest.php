
<!-- 

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetNameValid()
    {
        $user = new User();
        $user->setName("John Doe");
        $this->assertEquals("John Doe", $user->getName());
    }

    public function testSetNameEmpty()
    {
        $user = new User();
        $user->setName("");
        $this->assertEquals("", $user->getName());
    }

    public function testSetEmailValid()
    {
        $user = new User();
        $user->setEmail("johndoe@example.com");
        $this->assertEquals("johndoe@example.com", $user->getEmail());
    }

    public function testSetEmailInvalid()
    {
        $user = new User();
        $user->setEmail("invalid-email");
        $this->assertFalse($user->isValidEmail());
    }

    public function testSetEmailEmpty()
    {
        $user = new User();
        $user->setEmail("");
        $this->assertFalse($user->isValidEmail());
    }

    public function testGetNameBeforeSetting()
    {
        $user = new User();
        $this->assertNull($user->getName());
    }

    public function testSetAndGetMultipleAttributes()
    {
        $user = new User();
        $user->setName("Alice");
        $user->setEmail("alice@example.com");
        $this->assertEquals("Alice", $user->getName());
        $this->assertEquals("alice@example.com", $user->getEmail());
    }

    public function testInvalidEmailFormat()
    {
        $user = new User();
        $user->setEmail("not-an-email");
        $this->assertFalse($user->isValidEmail());
    }

    public function testValidEmailFormat()
    {
        $user = new User();
        $user->setEmail("test@example.com");
        $this->assertTrue($user->isValidEmail());
    }

    public function testNameLengthExceeded()
    {
        $user = new User();
        $longName = str_repeat("a", 256); // Assuming name limit is 255 characters
        $user->setName($longName);
        $this->assertEquals($longName, $user->getName());
    }

    public function testNameAndEmailCombination()
    {
        $user = new User();
        $user->setName("Charlie");
        $user->setEmail("charlie@example.com");
        $this->assertEquals("Charlie", $user->getName());
        $this->assertEquals("charlie@example.com", $user->getEmail());
    }

    // Test for setting a null value
    public function testSetNullName()
    {
        $user = new User();
        $user->setName(null);
        $this->assertNull($user->getName());
    }

    public function testEmailWithSpecialCharacters()
    {
        $user = new User();
        $user->setEmail("user+test@example.com");
        $this->assertTrue($user->isValidEmail());
    }

    public function testEmailWithSpaces()
    {
        $user = new User();
        $user->setEmail(" user@example.com ");
        $this->assertFalse($user->isValidEmail());
    }
}