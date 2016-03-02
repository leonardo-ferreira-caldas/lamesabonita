<?php

use Laracasts\Integrated\Extensions\Selenium as IntegrationTest;
use Laracasts\Integrated\Services\Laravel\Application as Laravel;
use Laracasts\Integrated\Extensions\Traits\WorksWithDatabase;

class CadastrarChefTest extends IntegrationTest
{

    use Laravel, WorksWithDatabase;

    public function tearDown()
    {
        $this->app['db']->table('chef')->delete();
        $this->app['db']->table('users')->delete();
    }

    public function test_cadastrar_chef_com_sucesso()
    {

        $this->visit('sou-chef/cadastrar')
            ->type('Chef',                          'name')
            ->type('Teste',                         'sobrenome')
            ->type('chef.teste@example.com',        'email')
            ->click('data_nascimento')
            ->type('25/08/1993',                    'data_nascimento')
            ->click('cpf')
            ->type('113.021.876-78',                'cpf')
            ->click('telefone')
            ->type('(11) 111111111',                'telefone')
            ->click('cep')
            ->type('11.111-111',                    'cep')
            ->type('Bairro Teste',                  'bairro')
            ->type('123',                           'logradouro_numero')
            ->type('Rua Teste',                     'logradouro')
            ->type('senha123',                      'password')
            ->type('senha123',                      'password_confirmation')
            ->select('fk_estado',                   'MG')
            ->wait(1000)
            ->select('fk_cidade',                   "2389")
            ->select('fk_sexo',                     "1")
            ->click('#aceitar-termos')
            ->press('Cadastrar')
            ->seeInDatabase('users', ['email' => 'chef.teste@example.com'])
            ->seeInDatabase('chef', [
                'sobrenome'         => 'Teste',
                'data_nascimento'   => '1993-08-25',
                'cpf'               => '11302187678',
                'cep'               => '11111111',
                'telefone'          => '(11) 111111111',
                'fk_estado'         => 'MG',
                'fk_cidade'         => '2389',
                'bairro'            => 'Bairro Teste',
                'logradouro'        => 'Rua Teste',
                'logradouro_numero' => '123',
                'fk_sexo'           => '1'
            ]);
    }

    public function test_cadastrar_chef_sem_aceitar_termos()
    {

        $this->makeRequest()

    }
}
