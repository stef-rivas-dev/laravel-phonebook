<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Return all contacts stored
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * Return a single contacts full details
     *
     * @return \App\Contact
     */
    public function show(Contact $contact)
    {
        return $contact;
    }

    /**
     * Store a new contact from request data or overrided
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data Associative array of request input
     * @param boolean $asObj Condition to return a response or contact object
     * @return \App\Contact|\Illuminate\Http\Response
     */
    public function store(Request $request, $data = null, $asObj = false)
    {
        $data = $data ?? $request->all();

        $contact = Contact::create($data);

        // Return contact object
        if ($asObj) { return $contact; }

        return response()->json($contact, 201);
    }

    /**
     * Update a contact's details and create
     *
     * one if it does not exist
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id The contact id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $statusCode = 200;

        $input = [];

        $contact = Contact::find($id);

        // Create a contact if not found
        if (! ($contact instanceof Contact)) {
            $label = $request->input('label', Contact::DEFAULT_LABEL);
            $input = array_merge($request->all(), ['label' => $label]);
            $contact = $this->store($request, $input, true);
            $statusCode = 201;
        } else {
            $contact->update($request->all());
        }

        return response()->json($contact, $statusCode);
    }

    /**
     * Delete a contact
     *
     * @param \App\Contact
     * @return \Illuminate\Http\Response
     */
    public function delete(Contact $contact)
    {
        $contact->delete();
        return response()->json(null, 204);
    }
}