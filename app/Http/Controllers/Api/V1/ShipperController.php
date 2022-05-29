<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShipperRequest;
use App\Http\Requests\UpdateShipperRequest;
use App\Http\Resources\ShipperCollection;
use App\Http\Resources\ShipperResource;
use App\Models\Shipper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShipperController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/shippers",
     *      summary="Prints list of shippers",
     *      tags={ "Shipper" },
     *      @OA\Parameter(
     *          name="name",
     *          description="Filter by name",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Kris Inc"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Shipper")),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function index(Request $request): ShipperCollection
    {
        if ($request->has('name')) {
            return new ShipperCollection(Shipper::filterByRequest($request)->paginate());
        }

        return new ShipperCollection(Shipper::paginate());
    }

    /**
     * @OA\Post(
     *      path="/api/v1/shippers",
     *      summary="Create a new shipper record",
     *      security={"sanctum": {}},
     *      tags={"Shipper"},
     *      @OA\RequestBody(
     *          request="ShipperCreateRequest",
     *          description="Shipper data to be created",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Bills Inc"
     *              ),
     *              @OA\Property(
     *                  property="address",
     *                  type="string",
     *                  example="47 Upperthong Ln\nHolmfirth\nHD9 3UZ"
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function store(StoreShipperRequest $storeShipperRequest): JsonResponse
    {
        $shipper = Shipper::create($storeShipperRequest->validated());

        return response()->json([
            'links' => [
                'self' => route('shippers.show', ['shipper-id' => $shipper->id]),
            ],
            'data' => [
                'id' => $shipper->id,
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/shippers/{shipper-id}",
     *      summary="Prints details for a single shipper",
     *      tags={ "Shipper" },
     *      @OA\Parameter(
     *          name="shiiper-id",
     *          description="Shipper ID",
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example="6"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Shipper")),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function show(Shipper $shipper): ShipperResource
    {
        return new ShipperResource($shipper);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/shippers/{shipper-id}",
     *      summary="Update a shipper record",
     *      security={"sanctum": {}},
     *      tags={"Shipper"},
     *      @OA\RequestBody(
     *          request="ShipperUpdateRequest",
     *          description="Shipper data to be updated",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Bills Inc"
     *              ),
     *              @OA\Property(
     *                  property="address",
     *                  type="string",
     *                  example="47 Upperthong Ln\nHolmfirth\nHD9 3UZ"
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function update(UpdateShipperRequest $updateShipperRequest, Shipper $shipper): JsonResponse
    {
        $shipper->update($updateShipperRequest->validated());

        return response()->json([
            'links' => [
                'self' => route('shippers.show', ['shipper-id' => $shipper->id]),
            ],
            'data' => [
                'id' => $shipper->id,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/api/v1/shippers/{shipper-id}",
     *      security={"sanctum": {}},
     *      summary="Delete a specified resource",
     *      tags={"Shipper"},
     *      @OA\Parameter(
     *          name="shipper_id",
     *          description="Shipper id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example=2
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Shipper")),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function destroy(Shipper $shipper): JsonResponse
    {
        Shipper::destroy($shipper->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
