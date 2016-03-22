<?php

namespace App\Repositories;

abstract class AbstractRepository
{

    private $found = [];
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instanciate();
    }

    /**
     * Cria uma nova instancia do modelo
     *
     * @return Model
     */
    private function instanciate()
    {
        return app($this->model);
    }

    /**
     * Obtem os dados de um registro pelo ID e salva em memoria
     *
     * @param $id
     * @param array $eager
     * @return mixed
     */
    public function findById($id, $eager = [])
    {
        if (isset($this->found[$id])) {
            return $this->found[$id];
        }

        $find = $this->instance->with($eager)->findOrFail($id);

        return $this->found[$id] = $find;
    }

    /**
     * Obtem uma lista dados usando um filtro where
     *
     * @param array .assoc $where Filtros
     * @param array $eager
     * @return mixed
     */
    public function find($where, $eager = [])
    {
        $model = $this->applyWhere($this->instanciate(), $where);
        return $model->get();
    }

    /**
     * Obtem o primeiro registro do modelo usando um filtro
     *
     * @param array .assoc $where Filtros
     * @return mixed
     */
    public function findFirst($where)
    {
        $model = $this->applyWhere($this->instanciate(), $where);
        return $model->first();
    }

    /**
     * Cria um novo registro
     *
     * @param $fields
     * @return Model
     */
    public function create($fields)
    {
        $model = $this->instanciate();

        foreach ($fields as $fieldName => $fieldValue) {
            $model->{$fieldName} = $fieldValue;
        }

        $model->save();

        return $model;
    }

    /**
     * Atualiza um registro
     *
     * @param int $id
     * @param array $update
     * @return void
     */
    public function updateById($id, $update)
    {
        $this->instance->where($this->instance->getKeyName(), $id)->update($update);

        return $this->findById($id);
    }

    /**
     * Atualiza vários registros
     *
     * @param int $id
     * @param array $update
     * @return void
     */
    public function update($where, $update)
    {
        $model = $this->applyWhere($this->instanciate(), $where);
        $model->update($update);
    }

    /**
     * Busca todos os registros do modelo
     *
     * @return array of Model
     */
    public function all($eager = [])
    {
        if ($eager) {
            return $this->instance->with($eager)->all();
        }

        return $this->instance->all();
    }

    /**
     * Conta a quantidade de registros para o filtro
     *
     * @return int
     */
    public function count($where)
    {
        $model = $this->applyWhere($this->instanciate(), $where);
        return $model->count();
    }

    /**
     * Verifica se um registo existe
     *
     * @return bool
     */
    public function exists($where)
    {
        return $this->count($where) > 0;
    }

    /**
     * Verifica se um registo existe pela chave
     *
     * @return bool
     */
    public function existsById($id)
    {
        return !empty($this->findById($id));
    }

    /**
     * Deleta registros por um filtro
     *
     * @return void
     */
    public function delete($where)
    {
        $model = $this->applyWhere($this->instanciate(), $where);
        $model->delete();
    }

    /**
     * Deleta um registro pelo ID
     *
     * @return void
     */
    public function deleteById($id)
    {
        $this->instanciate()->where($this->instance->getKeyName(), '=', $id)->delete();
    }

    /**
     * Aplica condições where na instancia do modelo
     *
     * @param Model $model
     * @param array $where
     * @return Model
     */
    private function applyWhere($model, $where)
    {
        foreach ($where as $fieldName => $fieldValue) {
            $model = $model->where($fieldName, '=', $fieldValue);
        }
        return $model;
    }
}