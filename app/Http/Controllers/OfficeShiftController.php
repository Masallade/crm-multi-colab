<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\office_shift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OfficeShiftController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = Company::select('id', 'company_name')->get();

		if ($logged_user->can('view-office_shift'))
		{
			if (request()->ajax())
			{
				return datatables()->of(office_shift::with('company')->get())
					->setRowId(function ($office_shift)
					{
						return $office_shift->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('action', function ($data)
					{
						$button = '';
						if (auth()->user()->can('edit-office_shift'))
						{
							$button = '<a id="' . $data->id . '" class="edit btn btn-primary btn-sm" href="' . route('office_shift.edit', $data->id) . '"><i class="dripicons-pencil"></i></a>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-office_shift'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('timesheet.office_shift.index', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$logged_user = auth()->user();
		$companies = Company::select('id', 'company_name')->get();

		if ($logged_user->can('store-office_shift'))
		{
			return view('timesheet.office_shift.create', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-office_shift'))
		{
			$validator = Validator::make($request->only('shift_name', 'company_id', 'default_shift', 'monday_in', 'monday_out', 'tuesday_in', 'tuesday_out', 'wednesday_in', 'wednesday_out', 'thursday_in', 'thursday_out', 'friday_in', 'friday_out', 'saturday_in', 'saturday_out', 'sunday_in', 'sunday_out'
			),
				[
					'shift_name' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['shift_name'] = $request->shift_name;
			$data['monday_in'] = $request->monday_in;
			$data['monday_out'] = $request->monday_out;
            $data['monday_break_minutes'] = $this->buildBreakMinutes($request, 'monday');
			$data['tuesday_in'] = $request->tuesday_in;
			$data['tuesday_out'] = $request->tuesday_out;
            $data['tuesday_break_minutes'] = $this->buildBreakMinutes($request, 'tuesday');
			$data['wednesday_in'] = $request->wednesday_in;
			$data['wednesday_out'] = $request->wednesday_out;
            $data['wednesday_break_minutes'] = $this->buildBreakMinutes($request, 'wednesday');
			$data['thursday_in'] = $request->thursday_in;
			$data['thursday_out'] = $request->thursday_out;
            $data['thursday_break_minutes'] = $this->buildBreakMinutes($request, 'thursday');
			$data['friday_in'] = $request->friday_in;
			$data['friday_out'] = $request->friday_out;
            $data['friday_break_minutes'] = $this->buildBreakMinutes($request, 'friday');
			$data['saturday_in'] = $request->saturday_in;
			$data['saturday_out'] = $request->saturday_out;
            $data['saturday_break_minutes'] = $this->buildBreakMinutes($request, 'saturday');
			$data['sunday_in'] = $request->sunday_in;
			$data['sunday_out'] = $request->sunday_out;
            $data['sunday_break_minutes'] = $this->buildBreakMinutes($request, 'sunday');
			$data['company_id'] = $request->company_id;


			office_shift::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-office_shift'))
		{
			$office_shift = office_shift::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$companies = Company::select('id', 'company_name')->get();

			return view('timesheet.office_shift.edit', compact('office_shift', 'company_name', 'companies'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-office_shift'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('shift_name', 'company_id', 'default_shift', 'monday_in', 'monday_out', 'tuesday_in', 'tuesday_out', 'wednesday_in', 'wednesday_out', 'thursday_in', 'thursday_out', 'friday_in', 'friday_out', 'saturday_in', 'saturday_out', 'sunday_in', 'sunday_out'
			),
				[
					'shift_name' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['shift_name'] = $request->shift_name;
			$data['monday_in'] = $request->monday_in;
			$data['monday_out'] = $request->monday_out;
            $data['monday_break_minutes'] = $this->buildBreakMinutes($request, 'monday');
			$data['tuesday_in'] = $request->tuesday_in;
			$data['tuesday_out'] = $request->tuesday_out;
            $data['tuesday_break_minutes'] = $this->buildBreakMinutes($request, 'tuesday');
			$data['wednesday_in'] = $request->wednesday_in;
			$data['wednesday_out'] = $request->wednesday_out;
            $data['wednesday_break_minutes'] = $this->buildBreakMinutes($request, 'wednesday');
			$data['thursday_in'] = $request->thursday_in;
			$data['thursday_out'] = $request->thursday_out;
            $data['thursday_break_minutes'] = $this->buildBreakMinutes($request, 'thursday');
			$data['friday_in'] = $request->friday_in;
			$data['friday_out'] = $request->friday_out;
            $data['friday_break_minutes'] = $this->buildBreakMinutes($request, 'friday');
			$data['saturday_in'] = $request->saturday_in;
			$data['saturday_out'] = $request->saturday_out;
            $data['saturday_break_minutes'] = $this->buildBreakMinutes($request, 'saturday');
			$data['sunday_in'] = $request->sunday_in;
			$data['sunday_out'] = $request->sunday_out;
            $data['sunday_break_minutes'] = $this->buildBreakMinutes($request, 'sunday');
			if ($request->company_id)
			{
				$data['company_id'] = $request->company_id;
			}

			office_shift::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-office_shift'))
		{
			office_shift::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-office_shift'))
		{

			$office_shift_id = $request['officeShiftIdArray'];
			$office_shift = office_shift::whereIntegerInRaw('id', $office_shift_id);
			if ($office_shift->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => __('Office Shift')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected shifts can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

    /**
     * Build break minutes from hours/minutes inputs for a given day.
     * Defaults to 60 minutes (1 hour) if nothing is provided.
     */
    private function buildBreakMinutes(Request $request, string $day): int
    {
        $hoursKey = $day . '_break_hours';
        $minutesKey = $day . '_break_minutes';

        $hours = (int) $request->input($hoursKey, 1);
        $minutes = (int) $request->input($minutesKey, 0);

        if ($hours < 0) $hours = 0;
        if ($hours > 4) $hours = 4;
        if ($minutes < 0) $minutes = 0;
        if ($minutes > 59) $minutes = 59;

        return $hours * 60 + $minutes;
    }


}
