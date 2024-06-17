<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Responses\Response;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Validators\ProductValidator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private ProductValidator $productValidator,
    ) {

    }

    /**
      * @OA\Get(
      *     tags={"Products"},
      *     security={{"token": {}}},
      *     summary="Returns a list of products",
      *     description="Returns a object of all products",
      *     path="/api/v1/products",
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="list of products"),
      * ),
      *
     */

    public function index(): JsonResponse
    {
        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Lista de Produtos',
                $this->productService->getAllProducts(),
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
      *     tags={"Products"},
      *     security={{"token": {}}},
      *     summary="Returns a one product",
      *     description="Returns a one product",
      *     path="/api/v1/product/{$id}",
      *     @OA\Parameter(
      *         description="Product Id",
      *         in="path",
      *         name="id",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="one product"),
      * ),
      *
    */

    public function show($idP): JsonResponse
    {
        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Produto $idP Encontrado Com Sucesso",
                $this->productService->get($idP),
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
      *     tags={"Products"},
      *     security={{"token": {}}},
      *     summary="Return a product updated",
      *     description="Return a product updated",
      *     path="/api/v1/product/{id}",
      *    @OA\Parameter(
      *         description="`Product Id",
      *         in="path",
      *         name="id",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *    @OA\Parameter(
      *         description="Product Name",
      *         in="query",
      *         name="name",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *      @OA\Parameter(
      *         description="Product Quantity",
      *         in="query",
      *         name="quantity",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Description",
      *         in="query",
      *         name="description",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Price",
      *         in="query",
      *         name="price",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Status",
      *         in="query",
      *         name="status",
      *         required=false,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="update Product"),
      * ),
      *
    */

    public function update($idP, Request $request): JsonResponse
    {

        if(!Gate::allows('manage-products')) {
            abort(403, 'Acesso negado');
        }

        $request = $request->all();

        try {

            $this->productValidator->validateStoreUpdateRequest($request, 'update');

            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Produto $idP Atualizado Com Sucesso",
                $this->productService->updateProduct(
                    $this->productService->get($idP),
                    $request
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
      *     tags={"Products"},
      *     security={{"token": {}}},
      *     summary="Returns a product deleted",
      *     description="Returns a product deleted",
      *     path="/api/v1/product/{$id}",
      *     @OA\Parameter(
      *         description="Product Id",
      *         in="path",
      *         name="id",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="return a product deleted"),
      * ),
      *
    */

    public function destroy($idP, Product $product): JsonResponse
    {
        if(!Gate::allows('manage-products')) {
            abort(403, 'Acesso negado');
        }

        try {
            return $this->successJsonResponse(
                Response::HTTP_OK,
                "Produto $idP Excluido Com Sucesso",
                $this->productService->delete($idP, $product),
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
      *     tags={"Products"},
      *     security={{"token": {}}},
      *     summary="Return a product created",
      *     description="Return a product created",
      *     path="/api/v1/product",
      *     @OA\Parameter(
      *         description="Product Name",
      *         in="query",
      *         name="name",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *      @OA\Parameter(
      *         description="Product Quantity",
      *         in="query",
      *         name="quantity",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Description",
      *         in="query",
      *         name="description",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Price",
      *         in="query",
      *         name="price",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Product Status",
      *         in="query",
      *         name="status",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     security={ {"bearer": {}} },
      *     @OA\Response(response="200", description="Create Product"),
      * ),
      *
    */

    public function store(Request $request): JsonResponse
    {
        try {

            $this->productValidator->validateStoreUpdateRequest($request->all(), 'store');

            return $this->successJsonResponse(
                Response::HTTP_CREATED,
                'Produto Criado Com Sucesso',
                $this->productService->createProduct($request->all()),
            );
        } catch (Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }
}
