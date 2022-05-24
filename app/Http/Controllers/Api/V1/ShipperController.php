<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShipperRequest;
use App\Http\Requests\UpdateShipperRequest;
use App\Http\Resources\ShipperCollection;
use App\Http\Resources\ShipperResource;
use App\Models\Shipper;
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShipperRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShipperRequest $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShipperRequest  $request
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipperRequest $request, Shipper $shipper)
    {
        //
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
    public function destroy(Shipper $shipper)
    {
        Shipper::destroy($shipper->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
