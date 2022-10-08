<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIMonggoCrudController extends Controller
{
    /**
     * @OA\Get(
     *     path = "/api/customer",
     *     tags = {"Customer"},
     *     summary = "Get list of Customer",
     *     @OA\Response(
     *          response = 200,
     *          description = "success",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                  @OA\Property(property="_id",type="string",example="633f78c918ff2f00d70dab58"),
     *              @OA\Property(property="name",type="string",example="example"),
     *              @OA\Property(property="email",type="string",example="example@example.com"),
     *              @OA\Property(property="created_at",type="string",example="2022-10-07T00:54:33.000000Z"),
     *              @OA\Property(property="updated_at",type="string",example="2022-10-07T00:54:33.000000Z"),
     *                 )
     *             )
     *         )

     *     )
     * )
     */

    public function index()
    {
        $customer = Customer::all();
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/customer",
     *     tags={"Customer"},
     *     summary="Add Customer",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "email":"example@example.com"
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *          response = 200,
     *          description = "success",
     *           @OA\JsonContent(
     *                      @OA\Property(property="data", type="string", format="array",
     *                      example={
     *                              "_id":"633f78c918ff2f00d70dab58",
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "created_at":"2022-10-07T00:54:33.000000Z",
     *                              "created_at":"2022-10-07T00:54:33.000000Z"
     *                      }
     *              )
     *          )
     *     )
     * )
     */
    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Get Detail Customer
     * @OA\Get (
     *     path="/api/customer//{_id}",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         in="path",
     *         name="_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *           @OA\JsonContent(
     *                      @OA\Property(property="data", type="string", format="array",
     *                      example={
     *                              "_id":"633f78c918ff2f00d70dab58",
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "created_at":"2022-10-07T00:54:33.000000Z",
     *                              "created_at":"2022-10-07T00:54:33.000000Z"
     *                      }
     *              )
     *          )
     *     )
     * )
     */

    public function show(Customer $customer)
    {
        return  response()->json([
            'data' => $customer
        ]);
    }


    /**
     * @OA\Put(
     *     path = "/api/customer/{_id}",
     *     tags = {"Customer"},
     *     summary = "Update Customer",
     *     @OA\Parameter(
     *         in="path",
     *         name="_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "email":"example@example.com"
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *          response = 200,
     *          description = "success",
     *           @OA\JsonContent(
     *                      @OA\Property(property="data", type="string", format="array",
     *                      example={
     *                              "_id":"633f78c918ff2f00d70dab58",
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "created_at":"2022-10-07T00:54:33.000000Z",
     *                              "created_at":"2022-10-07T00:54:33.000000Z"
     *                      }
     *              )
     *          )

     *     )
     * )
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $customer->name = $request->name;
        $customer->email  = $request->email;
        $customer->save();

        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * @OA\Delete(
     *     path = "/api/customer/{_id}",
     *     tags = {"Customer"},
     *     summary = "Delete Customer",
     *     @OA\Parameter(
     *         in="path",
     *         name="_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response = 200,
     *          description = "success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string",example="Customer data deleted successfully"),
     *              ),
     *         )
     *     )
     * )
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([
            'message' => 'Customer data deleted successfully'
        ]);
    }
}
