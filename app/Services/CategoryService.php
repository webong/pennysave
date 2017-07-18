<?php

namespace App\Services;

use App\Category;
use App\Traits\UploadTrait;
use DB;

class CategoryService
{

    use UploadTrait;

    public $dim_photo = [null, 320, 240];
    public $dim_thumbnail = ['thumb', 150, 150];

    public function create($request)
    {
        if ($request->hasFile('photo')) {
            // [prepended name, length, width]
            $dimensions = [$this->dim_photo, $this->dim_thumbnail];
            $uploadedPhotos = $this->upload('categories', $request->file('photo'), $dimensions);
            if (is_array($uploadedPhotos)) {
                // Multiple Files and Possibly Multiple Dimensions
                if ($uploadedPhotos[0] == 'm_dim') {
                    // Check that Single FIle with Multiple Dimensions is returned
                    return $this->addRecord($action = 'new', $request, $uploadedPhotos);
                }
                return redirect()->back()->with(['error' => 'There Was An Error Handling The Photo']);
            }
            return redirect()->back()->with(['error' => 'There Was An Error Handling The Photo']);
        }
        return redirect()->back()->with(['error' => 'Please Upload An Image']);
    }

    public function update($request)
    {
        if ($request->hasFile('photo')) {
            // [prepended name, length, width]
            $dimensions = [$this->dim_photo, $this->dim_thumbnail];
            $uploadedPhotos = $this->upload('categories', $request->file('photo'), $dimensions);
            if (is_array($uploadedPhotos)) {
                // Multiple Files and Possibly Multiple Dimensions
                if ($uploadedPhotos[0] == 'm_dim') {
                    // Check that Single FIle with Multiple Dimensions is returned
                    return $this->addRecord($action = 'update', $request, $uploadedPhotos);
                }
                return redirect()->back()->with(['error' => 'There Was An Error Handling The Photo']);
            }
            return redirect()->back()->with(['error' => 'There Was An Error Handling The Photo']);
        } else {
            // Photo is not being updated with other details
            return $this->addRecord($action = 'update', $request, $uploadedPhotos = null);
        }
        return redirect()->back()->with(['error' => 'Please Upload An Image']);
    }

    public function addRecord($action, $request, $data)
    {
        if ($action == 'new') {
            $category = new Category;
            $category->name           = $request->name;
            $category->photo          = urlencode($data[1]);
            $category->description    = $request->description;
            $category->type           = $request->type;
            $category->thumbnail      = urlencode($data[2]);
            if ($category->save()) {
                return $category;
            }
        } else {
            $category = Category::where('id', $request->id)->first();
            $category->name           = $request->name;
            $category->photo          = (is_null($data)) ? $category->photo : urlencode($data[1]);
            $category->description    = $request->description;
            $category->type           = $request->type;
            $category->thumbnail      = (is_null($data)) ? $category->thumbnail : urlencode($data[2]);
            if ($category->save()) {
                return $category;
            }
        }
    }

    public function categories()
    {
        $data['paid'] = Category::where('type', 'Paid')->get();
        $data['free'] = Category::where('type', 'Free')->get();
        return $data;
    }

    public function allCategories()
    {
        return Category::withCount('question')->get();
    }

    public function addCategory()
    {
        return Category::with('question')->get();
    }

    public function getCategory($id)
    {
        return (! is_null($id)) ?
            $this->confirmCategory($id) :
            $this->defaultCategory();
    }

    public function confirmCategory($id, $edit = null)
    {
        $category = Category::withCount('question')
              ->where('id', $id)->first();
        if ($category) {
            return $category;
            // To Show That It's Called from $this->editCategory($id)
            if (! is_null($edit)) {
                return null;
            }
        }
        return $this->defaultCategory();
    }

    public function defaultCategory()
    {
        return Category::withCount('question')
              ->where('name', 'Uncategorized')->orWhere('id', 1)->first();
    }

}
