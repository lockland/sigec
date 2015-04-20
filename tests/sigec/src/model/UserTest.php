<?php

namespace Sigec\model;

class UserTest extends \PHPUnit_Framework_TestCase
{
    const MODEL = "Sigec\model\User";
    const BASE = "Core\model\Model";

    /**
     * Model instance
     *
     * @var Core\model\Model $model
     */
    private $model;

    private $pdo;
 
    protected function setUp()
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS USUARIO (
              ID INTEGER PRIMARY KEY AUTOINCREMENT,
              NOME TEXT NULL,
              LOGIN TEXT NULL,
              SENHA TEXT NULL,
              PERFIL_USUARIO TEXT NULL
            )
        ');

        $this->model = new User($this->pdo);
    }

    protected function tearDown()
    {
        $this->pdo->exec('DROP TABLE USUARIO');
        $this->pdo = null;
        $this->model = null;
    }

    /**
     * Verify is $model is a instance of Core\model\Model
     *
     * @test
     * @testdox Create a instance of Core\model\Model
     */
    public function isAInstanceOfBase()
    {
        $this->assertInstanceOf(self::BASE, $this->model, 'User class is not an instance of Model');
    }

    /**
     * Validate if constructor receive no pdo instance
     *
     * @test
     * @testdox           Could I no pass PDO instance by constructor?
     * @expectedException PHPUnit_Framework_Error
     */
    public function constructWithoutPdo()
    {
        $model = new User();
    }

    /**
     * Create an user and stored
     *
     * @test
     * @testdox Try store user in database
     */
    public function save()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->assertEquals(1, (int) $id, 'Could not insert user into database');

    }

    /**
     * Delete an user in database
     *
     * @test
     * @testdox Try delete an user in database
     */
    public function delete()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->assertEquals(1, (int) $this->model->delete($id));
    }

    /**
     * @test
     * @textdox Try retrieve user by id
     */
    public function retrieve()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);

        $retrieved = new User($this->pdo);
        $retrieved->retrieve($id);

        $this->assertEquals(
            $this->model->getId(),
            $retrieved->getId(),
            'Could not retrieve user by id'
        );

    }

    /**
     * @test
     * @textdox Try retrieve user by id using invalid id
     * @expectedException InvalidArgumentException
     */
    public function retrieveInvalidId()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);

        $retrieved = new User($this->pdo);
        $retrieved->retrieve('');

        $this->assertEquals(
            $this->model->getId(),
            $retrieved->getId(),
            'User retrieved using an invalid id'
        );

    }

    /**
     * @test
     * @textdox Try retrieve user by id using credential
     */
    public function retrieveByCredential()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);

        $retrieved = new User($this->pdo);
        $retrieved->retrieveByCredential(
            $this->model->getLogin(),
            $this->model->getPassword()
        );

        $this->assertEquals(
            $this->model->getId(),
            $retrieved->getId(),
            'Could not retrieve user by credential'
        );

    }

    /**
     * @test
     * @testdox Try update user
     */
    public function update()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);
        $this->model->setLogin('UpdateLogin');
        $this->model->setPassword('UpdatePassword');
        $this->model->update();

        $retrieved = new User($this->pdo);
        $retrieved->retrieveByCredential(
            $this->model->getLogin(),
            $this->model->getPassword()
        );

        $this->assertEquals(
            $this->model->getLogin(),
            $retrieved->getLogin(),
            'Could not update login'
        );

        $this->assertEquals(
            $this->model->getPassword(),
            $retrieved->getPassword(),
            'Could not update password'
        );
    }

    private function setModelAttributes()
    {
        $this->model->setName('User1');
        $this->model->setLogin('login1');
        $this->model->setPassword('pass1');
        $this->model->setProfile('perfil_usuario1');
    }
}
