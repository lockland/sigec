<?php

namespace Sigec\model;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const MODEL = "Sigec\model\Client";
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
            CREATE TABLE IF NOT EXISTS CLIENTE (
              ID INTEGER PRIMARY KEY AUTOINCREMENT,
              NOME TEXT NULL,
              NOME_MAE TEXT NULL,
              END TEXT NULL,
              TEL TEXT NULL,
              CPF_CNPJ TEXT NULL,
              EMAIL TEXT NULL,
              CIDADE TEXT NULL,
              ESTADO TEXT NULL,
              BAIRRO TEXT NULL
            )
        ');

        $this->model = new Client($this->pdo);
    }

    protected function tearDown()
    {
        $this->pdo->exec('DROP TABLE CLIENTE');
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
        $this->assertInstanceOf(self::BASE, $this->model, 'Client class is not an instance of Model');
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
        $model = new Client();
    }

    /**
     * Create an user and stored
     *
     * @test
     * @testdox Try store client in database
     */
    public function save()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->assertEquals(1, (int) $id, 'Could not insert client into database');

    }

    /**
     * Delete an user in database
     *
     * @test
     * @testdox Try delete an client in database
     */
    public function delete()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->assertEquals(1, (int) $this->model->delete($id));
    }

    /**
     * @test
     * @textdox Try retrieve client by id
     */
    public function retrieve()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);

        $retrieved = new Client($this->pdo);
        $retrieved->retrieve($id);

        $this->assertEquals(
            $this->model->getId(),
            $retrieved->getId(),
            'Could not retrieve client by id'
        );

    }

    /**
     * @test
     * @textdox Try retrieve client by id using invalid id
     * @expectedException InvalidArgumentException
     */
    public function retrieveInvalidId()
    {
        $this->setModelAttributes();
        $id = $this->model->save();
        $this->model->setId($id);

        $retrieved = new Client($this->pdo);
        $retrieved->retrieve('');

        $this->assertEquals(
            $this->model->getId(),
            $retrieved->getId(),
            'Client retrieved using an invalid id'
        );

    }

    /**
     * @test
     * @testdox Try update client
     */
    public function update()
    {
        $name = 'UpdateName';

        $this->setModelAttributes();
        $id = $this->model->save();

        $this->model->setId($id);
        $this->model->setName($name);
        $this->model->update();

        $retrieved = new Client($this->pdo);
        $retrieved->retrieve($id);

        $this->assertEquals(
            $this->model->getName(),
            $retrieved->getName(),
            'Could not update'
        );
    }

    private function setModelAttributes()
    {
        $this->model->setName('name');
        $this->model->setMotherName('motherName');
        $this->model->setAddress('address');
        $this->model->setPhone('phone');
        $this->model->setCfpOrCnpj('cpfOrCnpj');
        $this->model->setEmail('email');
        $this->model->setCity('city');
        $this->model->setState('state');
        $this->model->setDistrict('district');
    }
}
