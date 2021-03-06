<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
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
     * @OA\Post(
     *      path="/api/v1/contacts",
     *      summary="Create a new contact record",
     *      security={"sanctum": {}},
     *      tags={"Contact"},
     *      @OA\RequestBody(
     *          request="ContactCreateRequest",
     *          description="Contact data to be created",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="shipper_id",
     *                  type="integer",
     *                  example=22
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Maximillian Bills"
     *              ),
     *              @OA\Property(
     *                  property="contact_number",
     *                  type="string",
     *                  example="+1 (770) 854-3563"
     *              ),
     *              @OA\Property(
     *                  property="contact_type",
     *                  type="enum",
     *                  enum={"primary", "site", "shipping", "billing", "admin"},
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
    public function store(StoreContactRequest $storeContactRequest): JsonResponse
    {
        $contact = Contact::create($storeContactRequest->validated());

        return response()->json([
            'links' => [
                'self' => route('contacts.show', ['contact_id' => $contact->id]),
            ],
            'data' => [
                'id' => $contact->id,
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/contacts/{contact_id}",
     *      summary="Prints details for a single contact",
     *      tags={ "Contact" },
     *      @OA\Parameter(
     *          name="contact_id",
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
    public function show(Request $request): ContactResource
    {
        return new ContactResource(Contact::findOrFail($request->route('contact_id')));
    }

    /**
     * @OA\Put(
     *      path="/api/v1/contacts/{contact_id}",
     *      summary="Update a contact record",
     *      security={"sanctum": {}},
     *      tags={"Contact"},
     *      @OA\RequestBody(
     *          request="ContactUpdateRequest",
     *          description="Contact data to be updated",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="shipper_id",
     *                  type="integer",
     *                  example=22
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Maximillian Bills"
     *              ),
     *              @OA\Property(
     *                  property="contact_number",
     *                  type="string",
     *                  example="+1 (770) 854-3563"
     *              ),
     *              @OA\Property(
     *                  property="contact_type",
     *                  type="enum",
     *                  enum={"primary", "site", "shipping", "billing", "admin"},
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
    public function update(UpdateContactRequest $updateContactRequest): ContactResource
    {
        $contact = Contact::findOrFail($updateContactRequest->route('contact_id'));
        $contact->update($updateContactRequest->validated());

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/api/v1/contacts/{contact_id}",
     *      security={"sanctum": {}},
     *      summary="Delete a specified resource",
     *      tags={"Contact"},
     *      @OA\Parameter(
     *          name="contact_id",
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
    public function destroy(Contact $contact): JsonResponse
    {
        Contact::destroy($contact->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
