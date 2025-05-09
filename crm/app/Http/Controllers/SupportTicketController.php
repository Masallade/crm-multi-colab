<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketUpdatedNotification;
use App\Models\SupportTicket;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportTicketController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		$companies = Company::select('id', 'company_name')->get();

		if ($logged_user->can('view-ticket'))
		{
			if (request()->ajax())
			{
				$tickets = SupportTicket::with('company:id,company_name', 'employee:id,first_name,last_name', 'department:id,department_name', 'fromEmployee:id,first_name,last_name')
					->when(!in_array($logged_user->role_users_id, [1, 6]), function($query) use ($logged_user) {
						$query->where(function($q) use ($logged_user) {
							$q->where('from_employee', $logged_user->id)
								->orWhere('employee_id', $logged_user->id);
						});
					})
					->get();

				return datatables()->of($tickets)
					->setRowId(function ($ticket)
					{
						return $ticket->id;
					})
					->addColumn('company', function ($row)
					{
						$company_name = $row->company->company_name ?? ' ';
						$department_name = empty($row->department->department_name) ? '' : $row->department->department_name;

						return $company_name . ' (' . $department_name . ')';
					})
					->addColumn('employee', function ($row)
					{
						if ($row->employee)
						{
							return $row->employee->first_name . ' ' . $row->employee->last_name;
						}
						return '';
					})
					->addColumn('from_employee', function ($row)
					{
						if ($row->fromEmployee)
						{
							return $row->fromEmployee->first_name . ' ' . $row->fromEmployee->last_name;
						}
						return '';
					})
					->addColumn('ticket_details', function ($row)
					{
						if ($row->ticket_attachment)
						{
							return $row->ticket_code . '<br><h6><a href="' . route('tickets.downloadTicket', $row->id) . '">' . trans('file.File') . '</a></h6>';
						} else
						{
							return $row->ticket_code;
						}
					})
					->addColumn('action', function ($data)
					{
						$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('tickets.show', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-ticket') && 
							$data->from_employee == auth()->user()->id && 
							!in_array(auth()->user()->role_users_id, [1, 6]))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-ticket'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action', 'ticket_details'])
					->make(true);
			}

			return view('SupportTicket.index', compact('companies'));
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
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		if (auth()->user()->can('store-ticket') || auth()->user())
		{
			$validator = Validator::make($request->only('subject', 'company_id', 'department_id', 'employee_id', 'ticket_priority', 'description', 'ticket_note'
				, 'ticket_attachments', 'from_employee'),
				[
					'subject' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'ticket_priority' => 'required',
					'ticket_attachment' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
					'from_employee' => 'required|exists:employees,id'
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['ticket_code'] = $this->ticketId();
			$data['subject'] = $request->subject;
			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;
			$data ['description'] = $request->description;
			$data ['ticket_priority'] = $request->ticket_priority;
			$data ['ticket_note'] = $request->ticket_note;
			$data ['ticket_status'] = $request->ticket_status ?? 'pending';
			$data ['from_employee'] = $request->from_employee;

			$file = $request->ticket_attachments;

			$file_name = null;

			if (isset($file))
			{
				$file_name = $data['ticket_code'];
				if ($file->isValid())
				{
					$file_name = 'ticket_' . $file_name . '.' . $file->getClientOriginalExtension();
					$file->storeAs('ticket_attachments', $file_name);
					$data['ticket_attachment'] = $file_name;
				}
			}

			$ticket = SupportTicket::create($data);

			if ($ticket->ticket_status == 'open')
			{
				$notificable = User::where('role_users_id', 1)
					->orWhere('id', $data['employee_id'])
					->get();

				Notification::send($notificable, new TicketCreatedNotification($ticket));
			}

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function ticketId()
	{
		$unique = Str::random(8);

		$check = SupportTicket::where('ticket_code', $unique)->first();

		if ($check)
		{
			return $this->ticketId();
		}

		return $unique;
	}

	public function show(SupportTicket $ticket)
	{
		try
		{
			$name = DB::table('employee_support_ticket')->where('support_ticket_id', $ticket->id)->pluck('employee_id')->toArray();
		} catch (Exception $e)
		{
			$name = null;
		}

		$logged_user = auth()->user();

		if ($logged_user->can('view-ticket') || 
			$ticket->from_employee == $logged_user->id || 
			$ticket->employee_id == $logged_user->id || 
			in_array($logged_user->id, $name))
		{
			$employees = DB::table('employees')
				->select('employees.id', DB::raw("CONCAT(employees.first_name,' ',employees.last_name) as full_name"))
				->get();

			return view('SupportTicket.details', compact('ticket', 'employees', 'name'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = SupportTicket::findOrFail($id);
			$departments = Department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->where('is_active',1)->where('exit_date',NULL)->get();

			return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments]);
		}
	}

	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-ticket') && !in_array($logged_user->role_users_id, [1, 6]))
		{
			$id = $request->hidden_id;
			$ticket = SupportTicket::findOrFail($id);

			// Check if current user is the ticket creator
			if ($ticket->from_employee != auth()->user()->id) {
				return response()->json(['error' => __('You are not authorized to edit this ticket')]);
			}

			$validator = Validator::make($request->only('subject', 'company_id', 'department_id', 'employee_id', 'ticket_priority', 'description', 'ticket_note'
			),
				[
					'subject' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'ticket_priority' => 'required',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['subject'] = $request->subject;
			$data ['description'] = $request->description;
			$data ['ticket_note'] = $request->ticket_note;

			$data['employee_id'] = $request->employee_id;

			$data ['company_id'] = $request->company_id;

			$data['department_id'] = $request->department_id;

			$data['ticket_priority'] = $request->ticket_priority;

			SupportTicket::whereId($id)->update($data);
			$ticket = SupportTicket::findOrFail($id);
			$employee = $ticket->employee;

			$notificable = User::where('role_users_id', 1)
				->orWhere('id', $employee->id)
				->get();

			Notification::send($notificable, new TicketUpdatedNotification($ticket));

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

		if ($logged_user->can('delete-ticket'))
		{
			$ticket = SupportTicket::findOrFail($id);
			$file_path = $ticket->ticket_attachment;

			if ($file_path)
			{
				$file_path = public_path('uploads/ticket_attachments/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$ticket->delete();

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

		if ($logged_user->can('delete-ticket'))
		{
			$ticket_id = $request['ticketIdArray'];
			$tickets = SupportTicket::whereIntegerInRaw('id', $ticket_id)->get();

			foreach ($tickets as $ticket)
			{
				$file_path = $ticket->ticket_attachment;

				if ($file_path)
				{
					$file_path = public_path('uploads/ticket_attachments/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$ticket->delete();
			}

			return response()->json(['success' => __('Multi Delete', ['key' => __('Support Ticket')])]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{

		$file = SupportTicket::findOrFail($id);

		$file_path = $file->ticket_attachment;

		$download_path = public_path("uploads/ticket_attachments/" . $file_path);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);

			return $response;
		} else
		{
			return abort('404', __('File not Found'));
		}
	}


	public function detailsStore(Request $request)
	{
		$validator = Validator::make($request->only('ticket_remarks', 'ticket_status', 'ticket_id'),
			[
				'ticket_remarks' => 'required',
				'ticket_status' => 'required',
				'ticket_id' => 'required|exists:support_tickets,id'
			]
		);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$ticket = SupportTicket::findOrFail($request->ticket_id);
		$data = [
			'ticket_remarks' => $request->ticket_remarks,
			'ticket_status' => $request->ticket_status
		];

		$ticket->update($data);

		$assigned = $ticket->assignedEmployees()->get();
		$notificable = User::where('role_users_id', 1)
			->orWhere('id', $ticket->employee->id)
			->get();

		Notification::send($notificable, new TicketUpdatedNotification($ticket));

		if (sizeof($assigned) > 0) {
			Notification::send($assigned, new TicketUpdatedNotification($ticket));
		}

		// Store success message in session
		session()->flash('success', 'Ticket updated successfully.');
		
		// Return redirect response
		return redirect()->route('tickets.index');
	}


	public function notesStore(Request $request, SupportTicket $ticket)
	{
		$validator = Validator::make($request->only('ticket_note'),
			[
				'ticket_note' => 'required',
			]
//				,
//				[
//					'ticket_note.required' => 'Note can not be empty',
//				]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['ticket_note'] = $request->ticket_note;

		$ticket->update($data);

		return response()->json(['success' => 'Data Updated successfully.', 'ticket' => $ticket]);
	}

}
