<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/contacts",
     *      summary="Prints list of contacts",
     *      tags={ "Contact" },
     *      @OA\Parameter(
     *          name="name",
     *          description="Filter by name",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="John Doe"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="shipper-name",
     *          description="Filter by shipper name",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Kris Inc"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="contact-type",
     *          description="Filter by contact type",
     *          in="query",
     *          @OA\Schema(
     *              type="enum",
     *              enum={"primary", "site", "shipping", "billing", "admin"},
     *              example="billing"
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
    public function index(Request $request): ContactCollection
    {
        if ($request->all()) {
            return new ContactCollection(Contact::filterByRequest($request)->paginate());
        }

        return new ContactCollection(Contact::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/v1/contacts/{contact-id}",
     *      summary="Prints details for a single contact",
     *      tags={ "Contact" },
     *      @OA\Parameter(
     *          name="contact-id",
     *          description="Contact ID",
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example="24"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Contact")),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function show(Contact $contact): ContactResource
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/api/v1/contacts/{contact-id}",
     *      security={"sanctum": {}},
     *      summary="Delete a specified resource",
     *      tags={"Contact"},
     *      @OA\Parameter(
     *          name="contact-id",
     *          description="contact id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              example=4
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Contact")),
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
    public function destroy(Contact $contact)
    {
        Contact::destroy($contact->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
