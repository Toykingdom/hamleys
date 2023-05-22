<?php
namespace App\Services\Herzblut;

use App\Services\Herzblut\Actions\SaveCustomer;
use App\Services\Herzblut\Actions\SearchCustomers;
use App\Services\Herzblut\Actions\FetchCustomer;
use Illuminate\Validation\ValidationException;

class Trader {
    public $client;
    public $customerModel;

    public function __construct()
    {
        $this->client = new TraderClient();
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return TraderCustomer
     */
    public function getCustomerModel(): TraderCustomer
    {
        return $this->customerModel;
    }

    /**
     * Get a new instance of the user model.
     *
     * @param array $input
     * @return TraderCustomer
     */
    public function setCustomerModel(array $input = []): TraderCustomer
    {
        $this->customerModel = new TraderCustomer($input);
        return $this->customerModel;
    }

    /**
     * @param array $input
     * @return TraderCustomer
     */
    public function saveCustomer(array $input): TraderCustomer
    {
        $this->setCustomerModel($input);
        SaveCustomer::save($this->customerModel);
        return $this->customerModel;
    }

    /**
     * @param string $input
     * @return TraderCustomer[]
     */
    public function searchCustomers(string $input): array
    {
        return SearchCustomers::search($input);
    }

    /**
     * @param string $account_code
     * @return TraderCustomer || null
     * @throws ValidationException
     */
    public function fetchCustomer(string $account_code)
    {
        return FetchCustomer::fetch($account_code);
    }
}
