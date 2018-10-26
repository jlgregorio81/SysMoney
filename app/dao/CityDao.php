<?php
namespace app\dao;

use app\model\CityModel;
use core\dao\Dao;

final class CityDao extends Dao
{

    const COL_NAME = 'name_city';
    const COL_STATE = 'state_city';

    public function __construct(CityModel $model = null)
    {
        $this->model = is_null($model) ? new CityModel() : $model;
        $this->tableName = 'city';
        $this->tableId = 'id_city';
        $this->setColumns();
    }

    public function setColumns()
    {
        $this->columns = array(
            self::COL_NAME => $this->model->getName(),
            self::COL_STATE => $this->model->getState()
        );
    }

    public function findById($id)
    {
        $data = parent::findById($id);
        if ($data) {
            return new CityModel(
                $id,
                $data[self::COL_NAME],
                $data[self::COL_STATE]
            );
        }
        else {
            return null;
        }
    }

    public function selectAll($criteria = null, $orderBy = null, 
    $groupBy = null, $limit = null, $offSet = null)
    {
        $data = parent::selectAll($criteria, $orderBy, $groupBy, 
            $limit, $offSet);
        $arrayList = null;
        if ($data) {
            foreach ($data as $reg) {
                $arrayList[] = new CityModel(
                    $reg[$this->tableId],
                    $reg[self::COL_NAME],
                    $reg[self::COL_STATE]
                );
            }
        }
        return $arrayList;
    }

    


}