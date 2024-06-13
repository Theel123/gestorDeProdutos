<?php

namespace App\Services;

use App\Models\User;
use App\Services\BaseService;
use App\Factories\CustomerFactory;
use Illuminate\Support\Collection;
use App\Exceptions\CustomerExceptions;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends BaseService
{
    public function __construct(
        private CustomerFactory $customerFactory,
        private User $user,
    ) {
    }

    public function getAllCustomers($paginate = null): Collection
    {
        return $this->getAll($this->user, $paginate);
    }

    public function get(int $idC): User
    {
        return $this->getById($idC, $this->user);
    }

    public function deleteCustomer($idC): bool
    {
        return $this->delete($idC, $this->user);
    }

    public function getByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function createCustomer(
        array $data
    ): User {

        if ($this->getByEmail($data['email'])) {
            throw CustomerExceptions::emailAlreadyRegistered();
        }

        $customer = $this->customerFactory->create(
            $data['name'],
            $data['email'],
            $data['password'],
        );

        $this->create($customer);

        return $customer;
    }

    public function updateCustomer(User $customer, array $data)
    {
        $customer = $customer->fill($data);

        $this->create($customer);

        return $customer;
    }

    public function getLoggedUser(): Model
    {
        try {
            if (empty(auth()->user()->id)) {
                throw CustomerExceptions::differentUserRequestingData();
            }

            return $this->getById(auth()->user()->id, $this->user);
        } catch (\Exception $e) {
            throw new \Exception('Usuário não é válido ou não está autenticado');
        }
    }
}
