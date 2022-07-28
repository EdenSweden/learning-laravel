<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Get & show all listings:
    public function index() {
        //request helper function:
        //dd(request('tag'));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
            //EASY PAGINATION DONE AS ABOVE:
            //paginate(numResultsPerPage). then go to listings index view and see what is there.
            //(otherwise, you would say get and it would show all results.)
            //If you want simple pagination without numbers and just next/prev buttons, fn above should be simplePaginate(6)
            // :: is php syntax for static method
            //'tag' above must be in brackets because the tag property within the requets is an array, and otherwise we will get an error.
        ]);
    }

    // Show single listing:
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create form:
        public function create() {
            return view('listings.create');
        }

    // Store Listing Data:
    public function store(Request $request){

        //by default, the logo is stored in storage/app. To change location, go to config/filesystems.php
        //dd($request->file('logo')->store());
        //HOW TO DO FORM VALIDATION:
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
            //tells it to create logos folder & store there ^
            //Afterward, you need to create a link between folders so that the image is publicly accessible. Command is php artisan storage:link.
            //Then url path to logo will be [site || localhost:PORT]/storage/logos/[file-name-here]
        }
        //TO CREATE SOMETHING IN THE DATABASE, use ModelNameHere::create
        Listing::create($formFields);

        //one way to create a flash message after listing is created (obv. import Session class):
        // Session::flash('message', 'Listing created successfully.');

        //another way is to put it on the redirect and make sure a view is displayed (see components):
        return redirect('/')->with('message', 'Listing created successfully.');
    }

    //Show edit form
    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    //Update listing
    public function update(Request $request, Listing $listing){

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        //current listing already exists, so we will use a regular (non-static) method to access it:
        $listing->update($formFields);

        //go back:
        return back()->with('message', 'Listing updated successfully.');
    }

    //Delete listing:
    public function destroy(Listing $listing) {
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully.');
    }

}
