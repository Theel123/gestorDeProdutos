<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Responses\Response;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Validators\CustomerValidator;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService,
        private CustomerValidator $customerValidator
    ) {
    }

    /**
      * @OA\Get(
      *     tags={"Customers"},
      *     security={{"token": {}}},
      *     summary="Returns a list of customers",
      *     description="Returns a object of all customers",
      *     path="/api/v1/customers",
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="list of Customers"),
      * ),
      *
     */

    public function index(): JsonResponse
    {
        if(!Gate::allows('manage-customer')) {
            abort(403, 'Acesso negado');
        }

        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Lista de Usuários',
                $this->customerService->getAllCustomers(),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
     * @OA\Get(
     *     tags={"Customers"},
     *     security={{"token": {}}},
     *     summary="Returns a one customer",
     *     description="Returns a object of customer",
     *     path="/api/v1/customer/{id}",
     *     @OA\Parameter(
     *         description="Customer Id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     security={ {"bearer": {}} },
     *     @OA\Response(response="200", description="One Customer"),
     * ),
     *sss
    */

    public function show(int $id): JsonResponse
    {
        try {

            $this->customerValidator->validateUserFromEntity($this->customerService->get($id));

            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Usuário Encontrado Com Sucesso',
                $this->customerService->get($id),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
      * @OA\Post(
      *     tags={"Customers"},
      *     summary="Return a customer created",
      *     description="Return a customer created",
      *     path="/api/v1/customer/store",
      *     @OA\Parameter(
      *         description="Customer Name",
      *         in="query",
      *         name="name",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *      @OA\Parameter(
      *         description="Customer Email",
      *         in="query",
      *         name="email",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Customer Password",
      *         in="query",
      *         name="password",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Response(response="200", description="Create Customer"),
      * ),
      *
     */

    public function store(Request $request): JsonResponse
    {
        try {

            $this->customerValidator->validateStoreUpdateRequest($request->all(), 'store');

            return $this->successJsonResponse(
                Response::HTTP_CREATED,
                'Usuário Criado Com Sucesso',
                $this->customerService->createCustomer($request->all()),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
      * @OA\Put(
      *     tags={"Customers"},
      *     security={{"token": {}}},
      *     summary="Return a customer updated",
      *     description="Return a customer updated",
      *     path="/api/v1/customer/{id}",
      *    @OA\Parameter(
      *         description="Customer Id",
      *         in="path",
      *         name="id",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Customer Name",
      *         in="query",
      *         name="name",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *      @OA\Parameter(
      *         description="Customer Email",
      *         in="query",
      *         name="email",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="update Customer"),
      * ),
      *
     */

    public function update(Request $request, $idC): JsonResponse
    {
        try {

            $this->customerValidator->validateStoreUpdateRequest($request->all(), 'update');
            $this->customerValidator->validateUserFromEntity($this->customerService->get($idC));

            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Usuário $idC Atualizado Com Sucesso",
                $this->customerService->updateCustomer(
                    $this->customerService->get($idC),
                    $request->all()
                )
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
      * @OA\Delete(
      *     tags={"Customers"},
      *     security={{"token": {}}},
      *     summary="Return a customer deleted",
      *     description="Return a customer deleted",
      *     path="/api/v1/customer/{id}",
      *     @OA\Parameter(
      *         description="Customer Id",
      *         in="path",
      *         name="id",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="delete Customer"),
      * ),
      *
     */

    public function destroy($idC): JsonResponse
    {
        try {
            $this->customerValidator->validateUserFromEntity($this->customerService->get($idC));

            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Usuário $idC Excluido Com Sucesso",
                $this->customerService->deleteCustomer($idC),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }
}
