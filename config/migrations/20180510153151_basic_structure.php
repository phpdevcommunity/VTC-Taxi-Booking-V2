<?php


use Phinx\Migration\AbstractMigration;

/**
 * Class BasicStructure
 */
class BasicStructure extends AbstractMigration
{
    /**
     *
     */
    public function change()
    {

        $this->table('settings')
            ->addColumn('society', 'string')
            ->addColumn('numberSociety', 'string')
            ->addColumn('phone', 'string', ['limit' => 70])
            ->addColumn('link', 'string')
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('address', 'string')
            ->addColumn('background', 'string', ['null' => true])
            ->create();

        $this->table('users')
            ->addColumn('username', 'string', ['limit' => 100])
            ->addColumn('password', 'string')
            ->addColumn('role', 'string', ['limit' => 20])
            ->create();

        $this->table('cars')
            ->addColumn('type', 'string', ['limit' => 100])
            ->addColumn('kmPrice', 'float')
            ->addColumn('minutePrice', 'float')
            ->addColumn('minimumPrice', 'float')
            ->addColumn('increase', 'integer')
            ->addColumn('places', 'integer')
            ->addColumn('bags', 'integer')
            ->addColumn('image', 'string', ['null' => true])
            ->addColumn('active', 'boolean')
            ->create();

        $this->table('reservations')
            ->addColumn('carId', 'integer', ['null' => false])
            ->addColumn('reference', 'string', ['limit' => 60])
            ->addColumn('lastName', 'string')
            ->addColumn('firstName', 'string')
            ->addColumn('depart', 'string')
            ->addColumn('arrival', 'string')
            ->addColumn('dateTransfer', 'date')
            ->addColumn('timeTransfer', 'time')
            ->addColumn('createdAt', 'datetime')
            ->addColumn('distance', 'float')
            ->addColumn('howLong', 'string', ['limit' => 50])
            ->addColumn('passengers', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY])
            ->addColumn('vol', 'string', ['limit' => 20])
            ->addColumn('note', 'text')
            ->addColumn('price', 'string', ['limit' => 50])
            ->addColumn('mail', 'string')
            ->addColumn('methodPayment', 'string', ['limit' => 50])
            ->addColumn('phone', 'string')
            ->addIndex(['carId'])
            ->create();

        $this->table('reservations')
            ->addForeignKey(
                'carId',
                'cars'
            )
            ->save();

        $setting = [
            'id'    => 1,
            'society'  => 'VTC Webbym',
            'numberSociety'  => '000000000',
            'phone'  => '+33600000000',
            'link'  => 'https://www.monsitevtc.fr',
            'email'  => 'contact@monsitevtc.fr',
            'address'  => '18 rue de paris, Paris 75',
            'background'  => 'background.jpg'
        ];

        $user = [
            'id'    => 1,
            'username'  => 'admin@admin.fr',
            'password'  => '$1$Cce3ZfCD$BjouY.uG3vTpBV5Xxc02I/',
            'role'  => 'ROLE_ADMIN'
        ];

        $this->table('settings')
            ->insert($setting)
            ->saveData();

        $this->table('users')
            ->insert($user)
            ->saveData();
    }


}
