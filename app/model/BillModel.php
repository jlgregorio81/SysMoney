<?php
namespace app\model;

use core\mvc\Model;
use core\util\Strings;


final class BillModel extends Model
{

    private $description;
    private $user;
    private $category;
    private $date;
    private $value;
    private $due;
    private $type;
    private $payment;
    private $obs;

    public function __construct(
        $id = null,
        $description = null,
        UserModel $user = null,
        CategoryModel $category = null,
        $date = null,
        $value = 0,
        $due = null,
        $type = null,
        $payment = null,
        $obs = null
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->user = is_null($user) ? new UserModel() : $user;
        $this->category = is_null($category) ? new CategoryModel() : $category;
        $this->date = $date;
        $this->value = $value;
        $this->due = $due;
        $this->type = $type;
        $this->payment = $payment;
        $this->obs = $obs;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser(UserModel $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */
    public function setCategory(CategoryModel $category)
    {
        $this->category = $category;

        return $this;
    }




    /**
     * Get the value of date
     */
    public function getDate($formated = false)
    {
        if (!$formated)
            return $this->date;
        else
            return Strings::formatDate($this->date);
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of due
     */
    public function getDue()
    {
        return $this->due;
    }

    /**
     * Set the value of due
     *
     * @return  self
     */
    public function setDue($due)
    {
        $this->due = $due;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set the value of payment
     *
     * @return  self
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get the value of obs
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set the value of obs
     *
     * @return  self
     */
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    public function show()
    {

    }

    public function getCategoryAsString()
    {
        return $this->category->getName();
    }

    public function getTypeAsString()
    {
        switch ($this->type) {
            case 'D':
                return 'Dinheiro';
                break;
            case 'C':
                return 'Cartão';
                break;
            case 'B':
                return 'Boleto';
                break;
            default:
                return 'Dinheiro';
                break;
        }

    }


}