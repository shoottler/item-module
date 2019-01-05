<?php
/**
 * Created by PhpStorm.
 * User: angelformica
 * Date: 2018-12-13
 * Time: 17:17
 */

namespace Modules\Item\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use Modules\Item\Entities\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Item\Transformers\ItemCollection;
use Modules\Item\Transformers\ItemResource;

class ItemController extends Controller {

	/**
	 * List the services of the given company
	 * @param Request $request
	 *
	 * @return ItemCollection
	 */
	public function index(Request $request){
		$company = Company::findOrFail($request->get('company_id'));
		return new ItemCollection($company->items);
	}

	/**
	 * Show the requested service
	 * @param $id
	 *
	 * @return ItemResource
	 */
	public function show($id){
		return new ItemResource(Item::findOrFail($id));
	}

	/**
	 * Create a service for the given company
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request){
		$request->validate([
			'company_id' => 'required',
			'name' => [
				'required',
				'max:255',
				Rule::unique('items')->where(function ($query) use($request) {
					return $query->where('name', $request->input('name'))
					             ->where('company_id', $request->input('company_id'));
				})
			]
		]);
		$data = $request->all();
		$company = Company::findOrFail($request->get('company_id'));
		$item = new Item($data);
		$request->validate($item::$rules);
		$company->items()->save($item);
		return response()->json([
			'data' => $item,
			'message' => 'The service was created successfully'
		],201);
	}

	/**
	 * Update the service with the new data
	 * @param Request $request
	 * @param $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request,$id){
		$item = Item::findOrFail($id);
		$request->validate([
			'name' => [
				'required',
				Rule::unique('items','name')->ignore($item->id,'id'),
				'max:255',
			],
		]);
		$data = $request->all();
		$item->update($data);
		return response()->json([
			'data' => $item,
			'message' => 'The service has been updated successfully'
		],200);
	}

	/**
	 * Delete the service
	 * @param $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id){
		$item = Item::findOrFail($id);
		$item->delete();
		return response()->json(null,204);
	}
}