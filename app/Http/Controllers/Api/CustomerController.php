<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Responses\Response;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CustomerRequests\StoreCustomerFormRequest;
use App\Http\Requests\CustomerRequests\UpdateCustomerFormRequest;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService,
    ) {

    }

    /**
      * @OA\Get(
      *     tags={"Customers"},
      *     security={{"token": {}}},
      *     summary="Returns a list of customers",
      *     description="Returns a object of all customers",
      *     path="/api/v1/customers",
      *     @OA\Response(response="200", description="list of Customers"),
      * ),
      *
     */

    public function index(): JsonResponse
    {
        if (!Gate::allows('view-customer-list')) {
            abort(403, 'Acesso Negado');
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
     *     @OA\Response(response="200", description="One Customer"),
     * ),
     *sss
    */

    public function show(): JsonResponse
    {
        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Usuário Encontrado Com Sucesso',
                $this->customerService->get(auth()->user()->id),
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
      *     @OA\Parameter(
      *         description="Customer Password",
      *         in="query",
      *         name="password",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Response(response="200", description="Create Customer"),
      * ),
      *
     */

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'max:15'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
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
      *     @OA\Response(response="200", description="update Customer"),
      * ),
      *
     */

    public function update(Request $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users'],
            'password' => ['nullable', 'min:6', 'max:15'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Usuário $userId Atualizado Com Sucesso",
                $this->customerService->updateCustomer(
                    $this->customerService->get($userId),
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
      *     @OA\Response(response="200", description="delete Customer"),
      * ),
      *
     */

    public function destroy(): JsonResponse
    {
        $userId = auth()->user()->id;

        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Usuário $userId Excluido Com Sucesso",
                $this->customerService->deleteCustomer($userId),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }
}
