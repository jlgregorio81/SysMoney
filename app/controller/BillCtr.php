<?php
namespace app\controller;

use core\mvc\Controller;
use app\model\BillModel;
use app\dao\BillDao;
use app\view\bill\BillView;
use app\model\UserModel;
use app\model\CategoryModel;
use app\dao\CategoryDao;
use app\view\bill\BillList;
use core\util\Session;

class BillCtr extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new BillModel();
        $this->dao = new BillDao();
        $this->view = new BillView();
        $this->viewList = new BillList();
    }

    public function viewToModel()
    {
        $this->model = new BillModel(
            $this->post['id'],
            $this->post['description'],
            Session::getSession('activeUser'), //..pega o usuário ativo na sessão
            new CategoryModel($this->post['id_category']),
            $this->post['date'],
            $this->post['value'],
            $this->post['due'],
            $this->post['type'],
            $this->post['payment'],
            $this->post['obs']
        );
    }

    public function showView()
    {
        //..recupera as categorias para exibir na view 
        $categories = (new CategoryDao())->selectAll(null, CategoryDao::TBL_NAME);
        $this->view->setCategories($categories);
        parent::showView();
    }

    public function showList()
    {
        if ($this->post) {
            
            //..essa primeira condição aplica um filtro para mostrar apenas as contas do usuário que estiver logado.
            $this->criteria = BillDao::COL_USER . " = " . Session::getSession('activeUser')->getId();
                        
            //..pega os dados form - nome
            $this->criteria .=  " and " . BillDao::COL_DESCRIPTION . " like upper('{$this->post['data'][0]}%')";
                                    
            
            if ($this->post['data'][1] != 'T') //..se for diferente de todos, então...
                $this->criteria .= " and " . BillDao::COL_TYPE . " = '{$this->post['data'][1]}'";

            //..fitra pela data de vencimento
            $this->criteria .= " and " . BillDao::COL_DUE . " between '{$this->post['data'][2]}' and '{$this->post['data'][3]}' ";

            //..ordena pela data de criação ou vencimento
            if ($this->post['data'][4] == 'C')
                $this->orderBy .= BillDao::COL_DATE . ", " . BillDao::COL_DESCRIPTION;
            else
                $this->orderBy .= BillDao::COL_DUE . ", " . BillDao::COL_DESCRIPTION;
        }
        parent::showList();
    }

}