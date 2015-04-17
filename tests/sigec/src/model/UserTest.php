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
     * @testdox Could I no pass PDO instance by constructor?
     * @expectedException PHPUnit_Framework_Error
     */
    public function constructWithoutPdo()
    {
        $model = new User();
    }

    /**
     * create an user and stored
     *
     * @test
     * @testdox Try store user into Database
     */
    public function create()
    {
        $this->model->setName('User1');
        $this->model->setLogin('login1');
        $this->model->setPassword('pass1');
        $this->model->setProfile('perfil_usuario1');

        $id = $this->model->create();
        $this->assertEquals(1, (int) $id, 'Could not insert user into database');

    }

}
