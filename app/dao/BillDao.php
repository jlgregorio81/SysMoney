<?php
namespace app\dao;

use core\dao\Dao;
use app\model\BillModel;
use core\util\Strings;


final class BillDao extends Dao
{

    const COL_ID = 'id_bill';
    const COL_DESCRIPTION = 'desc_bill';
    const COL_USER = 'user_id';
    const COL_CATEGORY = 'id_category';
    const COL_DATE = 'date_bill';
    const COL_VALUE = 'value_bill';
    const COL_DUE = 'due_bill';
    const COL_TYPE = 'type_bill';
    const COL_PAYMENT = 'payment_bill';
    const COL_OBS = 'obs_bill';

    public function __construct(BillModel $model = null)
    {
        $this->model = is_null($model) ? new BillModel() : $model;
        $this->tableName = 'bill';
        $this->tableId = 'id_bill';
        $this->setColumns();
    }

    public function setColumns()
    {
        $this->columns = array(
            self::COL_DESCRIPTION => $this->model->getDescription(),
            self::COL_USER => $this->model->getUser()->getId(),
            self::COL_CATEGORY => $this->model->getCategory()->getId(),
            self::COL_DATE => $this->model->getDate(),
            self::COL_VALUE => $this->model->getValue(),
            self::COL_DUE => $this->model->getDue(),
            self::COL_TYPE => $this->model->getType(),
            self::COL_PAYMENT => $this->model->getPayment(),
            self::COL_OBS => $this->model->getObs()
        );
    }

    public function findById($id)
    {
        try {
            $data = parent::findById($id);
            if ($data) {
                return new BillModel(
                    $data[self::COL_ID],
                    $data[self::COL_DESCRIPTION],
                    (new UserDao())->findById($data[self::COL_USER]),
                    (new CategoryDao())->findById($data[self::COL_CATEGORY]),
                    $data[self::COL_DATE],
                    $data[self::COL_VALUE],
                    $data[self::COL_DUE],
                    $data[self::COL_TYPE],
                    $data[self::COL_PAYMENT],
                    $data[self::COL_OBS]
                );
            } else
                return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function selectAll($criteria = null, $orderBy = null, $groupBy = null, $limit = null, $offSet = null)
    {
        try {
            $data = parent::selectAll($criteria, $orderBy, $groupBy, $limit, $offSet);
            if ($data) {
                $list = new \ArrayObject();
                foreach ($data as $bill) {
                    $list->append(new BillModel(
                        $bill[self::COL_ID],
                        $bill[self::COL_DESCRIPTION],
                        (new UserDao())->findById($bill[self::COL_USER]),
                        (new CategoryDao())->findById($bill[self::COL_CATEGORY]),
                        $bill[self::COL_DATE],
                        $bill[self::COL_VALUE],
                        $bill[self::COL_DUE],
                        $bill[self::COL_TYPE],
                        $bill[self::COL_PAYMENT],
                        $bill[self::COL_OBS]
                    ));
                }
                return $list;
            } else
                return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


}