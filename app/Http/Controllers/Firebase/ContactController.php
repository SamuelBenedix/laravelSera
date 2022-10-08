<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class ContactController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
    }

    /**
     * @OA\Get(
     *     path = "/api/contact",
     *     tags = {"Contact"},
     *     summary = "Get list of Contact",
     *     @OA\Response(
     *          response = 200,
     *          description = "success",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                      @OA\Property(property="-NDn1_FMcIFJ8Tbl3Xlc", type="string", format="array",
     *                      example={
     *                              "email":"example@example.com",
     *                              "name":"example",
     *                              "phone":"088812321321"
     *                      }
     *                   )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index()
    {
        $ref = $this->database->getReference($this->tablename)->getValue();
        return response()->json([
            'data' => $ref
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/contact",
     *     tags={"Contact"},
     *     summary="Add Contact",
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
     *                     "email":"example@example.com",
     *                     "name":"example",
     *                     "phone":"12324123"
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
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "phone":"12324123",
     *                      }
     *              )
     *          )
     *     )
     * )
     */

    public function store(Request $request)
    {
        $customer = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $ref = $this->database->getReference($this->tablename)->push($customer);

        if ($ref) {
            return response()->json([
                'data' => $customer
            ]);
        }
    }

    /**
     * Get Detail Contact
     * @OA\Get (
     *     path="/api/customer/contact/{uid}",
     *     tags={"Contact"},
     *     @OA\Parameter(
     *         in="path",
     *         name="uid",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *           @OA\JsonContent(
     *                      @OA\Property(property="data", type="string", format="array",
     *                      example={
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "phone":"12324123",
     *                      }
     *              )
     *          )
     *     )
     * )
     */

    public function show($id)
    {
        $ref = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        if ($ref) {
            return response()->json([
                'data' => $ref
            ]);
        }
    }



    /**
     * @OA\Put(
     *     path="/api/contact/{uid}",
     *     tags={"Contact"},
     *     summary="Update Contact",
     *     @OA\Parameter(
     *         in="path",
     *         name="uid",
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
     *                     "email":"example@example.com",
     *                     "name":"example",
     *                     "phone":"12324123"
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
     *                              "name":"example",
     *                              "email":"example@example.com",
     *                              "phone":"12324123",
     *                      }
     *              )
     *          )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $customer = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        $res = $this->database->getReference($this->tablename . '/' . $id)->update($customer);
        if ($res) {
            return response()->json([
                'data' => $customer
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path = "/api/contact/{_id}",
     *     tags = {"Contact"},
     *     summary = "Delete Contact",
     *     @OA\Parameter(
     *         in="path",
     *         name="_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Contact data deleted successfully",
     *         @OA\JsonContent(
     *              @OA\Property(property="message",type="string",example="Contact data deleted successfully"),
     *              ),
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->database->getReference($this->tablename . '/' . $id)->remove();

        return response()->json([
            'message' => 'Contact data deleted successfully'
        ]);
    }
}
